<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Cart;
use \App\Models\CartItems;
use \App\Models\Orders;
use \App\Models\OrderItems;
use \App\Models\Product;
use \App\Models\Customer;
use \App\Models\Review;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Session;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     
    private function formatNumberToK($num) {
        if ($num >= 1000) {
            return round($num / 1000, 1);
        }
        return $num;
    }

    public function index()
    {
        // dd(auth()->user()->user_type);
        if(auth()->user()->user_type == 'admin')
		{
		    $trendingProducts           =   Product::withCount('orderItems')
            		                                ->where('is_trending', 'yes')
            		                                ->where('is_finished', 'yes')
            		                                ->get();
		    
		    $reviews                    =   Review::inRandomOrder()->take(5)->get();
            $orderCount                 =   Orders::count();
            $customerCount              =   Customer::count();
            $orderearnings              =   Orders::where('is_paid', 'yes')
                                                    ->where('cancel_status', 'no')
                                                    ->sum('total_amount');
             
            $productCount               =   Product::count();
            $cancelorderCount           =   Orders::where('cancel_status','yes')->count();
            $successorderCount          =   Orders::where('cancel_status','no')->count();
            
            
            $totalOrders                =   $cancelorderCount + $successorderCount;

            $transactionRatio           =   $totalOrders > 0 ? round(($successorderCount / $totalOrders) * 100, 2) : 0;
            
            $orderearningsFormatted     =   $this->formatNumberToK($orderearnings);
            
            
  
            return view('admin.dashboard.index', [
                'trendingProducts'      => $trendingProducts,
                'orderCount'            => $orderCount,
                'customerCount'         => $customerCount,
                'orderearnings'         => $orderearningsFormatted,
                'reviews'               => $reviews,
                'productCount'          => $productCount,
                'successorderCount'     => $successorderCount,
                'cancelorderCount'      => $cancelorderCount,
                'transactionRatio'      => $transactionRatio,
                
            ]);
		}
		if(auth()->user()->user_type == 'staff')
		{
		    
			   return view('staff.dashboard.index');
			
		}
// 		return redirect('/');
    }
    
   /* public function getMonthlyStats()
    {
        $orders                         =   Orders::select('created_at', 'total_amount', 'cancel_status')->where('is_paid', 'yes')->get();
    
        $monthsKeys                     =   collect();
        for ($i = 11; $i >= 0; $i--) 
        {
            $monthsKeys->push(Carbon::now()->subMonths($i)->format('Y-m'));
        }
    
        $grouped                        =   $orders->groupBy(function ($order) { return Carbon::parse($order->created_at)->format('Y-m'); });
    
        $monthlyStats                   =   $monthsKeys->map(function ($monthKey) use ($grouped) 
                                        {
                                            $ordersInMonth = $grouped->get($monthKey, collect());
    
                                            return [
                                                'month' => Carbon::parse($monthKey . '-01')->format('M Y'),
                                                'totalamountcomes' => $ordersInMonth->sum('total_amount'),
                                                'success_orders' => $ordersInMonth->where('cancel_status', 'no')->sum('total_amount'),
                                                'cancelled_orders' => $ordersInMonth->where('cancel_status', 'yes')->sum('total_amount'),
                                            ];
                                        });
    
        return response()->json($monthlyStats);
    }

*/



public function getMonthlyStats(Request $request)
{
    $period = $request->input('period', 'all');
    $now = Carbon::now(); // DO NOT mutate this directly

    $query = Orders::select('created_at', 'total_amount', 'cancel_status')
                   ->where('is_paid', 'yes');

    // Filter orders by period
    if ($period === '1m') {
        $query->where('created_at', '>=', $now->copy()->startOfMonth());
    } elseif ($period === '6m') {
        $query->where('created_at', '>=', $now->copy()->subMonths(5)->startOfMonth()); // include current month
    } elseif ($period === '1y') {
        $query->where('created_at', '>=', $now->copy()->startOfYear());
    }

    $orders = $query->get();

    // Prepare months keys
    $monthsKeys = collect();
    if ($period === '1m') {
        $monthsKeys->push($now->format('Y-m')); // Only current month
    } elseif ($period === '6m') {
        for ($i = 5; $i >= 0; $i--) {
            $monthsKeys->push($now->copy()->subMonths($i)->format('Y-m'));
        }
    } elseif ($period === '1y') {
        for ($i = 11; $i >= 0; $i--) {
            $monthsKeys->push($now->copy()->subMonths($i)->format('Y-m'));
        }
    } else {
        // Default to 12 months
        for ($i = 11; $i >= 0; $i--) {
            $monthsKeys->push($now->copy()->subMonths($i)->format('Y-m'));
        }
    }

    // Group orders by year-month
    $grouped = $orders->groupBy(function ($order) {
        return Carbon::parse($order->created_at)->format('Y-m');
    });

    // Prepare the stats data
    $monthlyStats = $monthsKeys->map(function ($monthKey) use ($grouped) {
        $ordersInMonth = $grouped->get($monthKey, collect());

        return [
            'month' => Carbon::parse($monthKey . '-01')->format('M Y'),
            'totalamountcomes' => $ordersInMonth->sum('total_amount'),
            'success_orders' => $ordersInMonth->where('cancel_status', 'no')->sum('total_amount'),
            'cancelled_orders' => $ordersInMonth->where('cancel_status', 'yes')->sum('total_amount'),
        ];
    });

    return response()->json($monthlyStats);
}


    
}
