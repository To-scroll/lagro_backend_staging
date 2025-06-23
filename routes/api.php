<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\ProductApiController;
use App\Http\Controllers\API\CartApiController;
use App\Http\Controllers\API\WishlistApiController;
use App\Http\Controllers\API\HomeApiController;

use App\Http\Controllers\API\UserApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::post('login', 'App\Http\Controllers\API\LoginController@login');
Route::post('login', [LoginController::class, 'login']);
Route::post('sign-up', [LoginController::class, 'signUp']);
Route::post('verify-signup', [LoginController::class, 'VerifySignup']);
Route::post('forgot-password', [LoginController::class, 'forgotPassword']);
Route::post('reset-password', [LoginController::class, 'resetPassword']);




Route::group(['middleware'=>['auth:api']],function(){

    Route::get('get-user', [LoginController::class, 'getUser'])->name('get-user');
    Route::post('logout', [LoginController::class, 'logout']);
    Route::post('change-password-otp', [LoginController::class, 'sendChangePasswordOtp']);
    Route::post('change-password', [LoginController::class, 'changePassword']);
    Route::post('update-profile',[LoginController::class,'updateProfile']);

   
    Route::post('cart-count',[CartApiController::class,'cartCount']);
    Route::post('remove-cart-items',[CartApiController::class,'removeCartItems']);
    Route::post('update-cart',[CartApiController::class,'updateCart']);

    Route::post('add-address',[UserApiController::class,'addAddress']);
    Route::get('get-address',[UserApiController::class,'getAddress']);
    Route::post('delete-address',[UserApiController::class,'deleteAddress']);
    Route::post('update-address',[UserApiController::class,'updateAddress']);
    
    Route::post('apply-coupon',[UserApiController::class,'applyCoupon']);//Not Applicable
    Route::post('checkout',[UserApiController::class,'checkout']);//Not Applicable
    
    
    Route::post('place-order',[UserApiController::class,'placeOrder']);
    Route::post('verify-payment',[UserApiController::class,'verifyPayment']);
    Route::get('order-history',[UserApiController::class,'orderHistory']);
    Route::Post('cancel-order',[UserApiController::class,'cancelOrder']);
 
 
    Route::post('add-review',[UserApiController::class,'addReview']);

    Route::get('wihslist-count',[WishlistApiController::class,'wishlistCount']);
    Route::post('remove-wishlist-items',[WishlistApiController::class,'removeWishlistItems']);
    Route::post('update-wishlist',[WishlistApiController::class,'updateWishlist']);
    
    
    
    Route::post('add-to-cart',[CartApiController::class,'addToCart']);
    Route::get('fetch-cart',[CartApiController::class,'fetchCart']);
    
     
});


Route::get('get-all',[HomeApiController::class,'index']);

Route::get('shop-by-category',[ProductApiController::class,'getShopByCatProducts']);
Route::get('featured-products',[ProductApiController::class,'getFeaturedProducts']);

Route::get('get-all-categories',[ProductApiController::class,'getAllCategories']);
Route::get('get-all-products',[ProductApiController::class,'getAllProducts']);
Route::get('search-products',[ProductApiController::class,'searchProducts']);
Route::post('get-product-price',[ProductApiController::class,'getProductPrice']);

Route::get('get-products',[ProductApiController::class,'index']);
Route::get('single-product/{id}',[ProductApiController::class,'productDetails']);

Route::post('new-products',[ProductApiController::class,'getNewProducts']);
Route::post('trending-products',[ProductApiController::class,'getTrendingProducts']);


Route::post('add-to-wishlist',[WishlistApiController::class,'addToWishlist']);
Route::get('fetch-wishlist',[WishlistApiController::class,'fetchWishlist']);


Route::get('get-locations',[HomeApiController::class,'getLocations']);
Route::post('add-contact',[HomeApiController::class,'addToContact']);
   
Route::get('offer-details',[ProductApiController::class,'getOfferDetails']);
Route::get('get-offerProducts',[ProductApiController::class,'getOfferProducts']);

Route::get('get-pages',[HomeApiController::class,'getPages']);

Route::Post('check-availabile',[UserApiController::class,'CheckAvailable']);

Route::get('get-filtered-products',[ProductApiController::class,'getFilteredProducts']);

Route::get('get-price-filtered-products',[ProductApiController::class,'getPriceFilteredProducts']);

Route::get('get-largest-priced-product',[ProductApiController::class,'getLargestpriceproduct']);

//only for special purpose
Route::post('clear-user', [LoginController::class, 'Clearuser']);