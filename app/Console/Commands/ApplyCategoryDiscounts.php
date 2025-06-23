<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CategoryDiscount;
use App\Models\CategoryProductDiscount;
use App\Models\Product;
use App\Models\Sku;
use Carbon\Carbon;
use Exception;

class ApplyCategoryDiscounts extends Command
{
    protected $signature = 'discounts:apply';

    protected $description = 'Apply active category discounts to associated products';

    public function handle()
    {
        // \Log::info('Starting ApplyCategoryDiscounts');

        try {
            $now = Carbon::now();

            // Get all active discounts
            $activeDiscounts = CategoryDiscount::where('from_date', '<=', $now)
                                               ->where('to_date', '>=', $now)
                                               ->get();

            foreach ($activeDiscounts as $discount) {
                $productDiscounts = CategoryProductDiscount::where('category_discount_id', $discount->id)->get();

                foreach ($productDiscounts as $productDiscount) {
                    $product = Product::find($productDiscount->product_id);
                    if ($product) {
                        $productskus = Sku::where('product_id', $product->id)->get();

                        foreach ($productskus as $sku) {
                            if ($sku->discount_applied == 'no') {
                                $sku->old_discount = $sku->discount;
                                $sku->discount = $discount->discount;
                                $sku->special_price = $sku->price - ($sku->price * ($sku->discount / 100));
                                $sku->discount_applied = 'yes';
                                $sku->save();
                            }
                        }
                    }
                }
            }

            // \Log::info('ApplyCategoryDiscounts completed successfully.');
            $this->info('Category discounts applied successfully.');

        } catch (Exception $e) {
            // \Log::error('Error in ApplyCategoryDiscounts: ' . $e->getMessage());
            $this->error('Failed to apply category discounts. Check logs.');
        }
    }
}
