<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CategoryDiscount;
use App\Models\CategoryProductDiscount;
use App\Models\Product;
use App\Models\Sku;
use Carbon\Carbon;

class ResetExpiredCategoryDiscounts extends Command
{
    protected $signature = 'discounts:reset';

    protected $description = 'Reset product SKUs after category discount period ends';

    public function handle()
    {
        $now = Carbon::now();
        \Log::info('Starting ResetCategoryDiscounts');
        $expiredDiscounts = CategoryDiscount::where('to_date', '<', $now)
                                            ->where('completed', '!=', 'yes')
                                            ->get();
                                            
    
        // \Log::info('Found expired discounts count: ' . $expiredDiscounts->count());

        foreach ($expiredDiscounts as $discount)
        {
            // \Log::info('Resetting discounts for category ID: ' . $discount->id);
            $productDiscounts = CategoryProductDiscount::where('category_discount_id', $discount->id)->get();
            foreach ($productDiscounts as $productDiscount)
            {
                $product = Product::find($productDiscount->product_id);

                if ($product)
                {
       
                    $productSkus = Sku::where('product_id', $product->id)->get();
                    foreach ($productSkus as $sku)
                    {
                        // Restore old discount
                        $sku->discount = $sku->old_discount;
                        // Recalculate special price
                        $sku->special_price = $sku->price - ($sku->price * ($sku->discount / 100));
                        $sku->discount_applied = 'no';
                        
                        $sku->save();
                    }
                }
            }

            // Mark discount as completed
            $discount->completed = 'yes';
            $discount->save();
        }

        $this->info('Expired category discounts have been reset and marked as completed.');
    }
}
