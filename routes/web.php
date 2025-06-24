<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('404', function () {
    return view('front.404');
});

Route::get('/', function () {
    return view('auth.login');
});





Auth::routes();
Route::group(['middleware' => 'auth'], function () 
{
    
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout');
        Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
        Route::get('/monthly-stats', [App\Http\Controllers\HomeController::class, 'getMonthlyStats'])->name('monthlyStats');
    
    
        //badge
    
        Route::resource('badge', 'App\Http\Controllers\BadgeController');
        Route::get('filter_badge', ['as' => 'filter_badge', 'uses' => 'App\Http\Controllers\BadgeController@filter_badge']);
        Route::post('badgeStore', ['as' => 'badgeStore', 'uses' => 'App\Http\Controllers\BadgeController@store']);
        Route::post('badgeUpdate', ['as' => 'badgeUpdate', 'uses' => 'App\Http\Controllers\BadgeController@update']);
        // Route::post('badgeView',[ 'as' =>'badgeView','uses'=>'App\Http\Controllers\BadgeController@badgeView']);
        // Route::post('badge-delete',[ 'as' =>'badge-delete','uses'=>'App\Http\Controllers\BadgeController@destroy']);
        Route::post('changeBadge_status', ['as' => 'changeBadge_status', 'uses' => 'App\Http\Controllers\BadgeController@changeBadge_status']);
        Route::get('get-colors', 'App\Http\Controllers\BadgeController@getColor');
        Route::get('fetchBadge', 'App\Http\Controllers\BadgeController@fetchBadge');
    
        //testimonial
        Route::resource('testimonial', 'App\Http\Controllers\TestimonialController');
        Route::get('testimonialView', 'App\Http\Controllers\TestimonialController@testimonialView');
        Route::get('filter_testimonial', ['as' => 'filter_testimonial', 'uses' => 'App\Http\Controllers\TestimonialController@filter_testimonial']);
        Route::post('testimonialStore', ['as' => 'testimonialStore', 'uses' => 'App\Http\Controllers\TestimonialController@store']);
        Route::post('testimonialUpdate', ['as' => 'testimonialUpdate', 'uses' => 'App\Http\Controllers\TestimonialController@update']);
        // Route::post('testimonialView',[ 'as' =>'testimonialView','uses'=>'App\Http\Controllers\TestimonialController@testimonialView']);
        // Route::post('testimonial/delete',[ 'as' =>'testimonial/delete','uses'=>'App\Http\Controllers\TestimonialController@destroy']);
    
        //category
        Route::resource('category', 'App\Http\Controllers\CategoryController');
        Route::get('filter_category', ['as' => 'filter_category', 'uses' => 'App\Http\Controllers\CategoryController@filter_category']);
        Route::post('categoryStore', ['as' => 'categoryStore', 'uses' => 'App\Http\Controllers\CategoryController@store']);
        Route::post('categoryUpdate', ['as' => 'categoryUpdate', 'uses' => 'App\Http\Controllers\CategoryController@update']);
        // Route::post('category-delete',[ 'as' =>'category-delete','uses'=>'App\Http\Controllers\CategoryController@destroy']);
        Route::post('changeCategory_status', ['as' => 'changeCategory_status', 'uses' => 'App\Http\Controllers\CategoryController@changeCategory_status']);
        Route::post('fetchCategory', ['as' => 'fetchCategory', 'uses' => 'App\Http\Controllers\CategoryController@fetchCategory']);
        Route::get('category-view/{id}', 'App\Http\Controllers\CategoryController@categoryViewPage')->name('category.view');
            
            
        Route::resource('category-discount','App\Http\Controllers\CategoryDiscountController');
        Route::get('filter_categoryDiscount', ['as' => 'filter_categoryDiscount', 'uses' => 'App\Http\Controllers\CategoryDiscountController@filter_categoryDiscount']);
        Route::get('cat_product_list/{id}', 'App\Http\Controllers\CategoryDiscountController@categoryProducts');
        Route::get('categorydiscount-view/{id}', 'App\Http\Controllers\CategoryDiscountController@categoryDiscountViewPage')->name('category-discount.view');
        
    
        //attributes
        Route::resource('attributes', 'App\Http\Controllers\AttributeController');
        Route::get('filter_attributes', ['as' => 'filter_attributes', 'uses' => 'App\Http\Controllers\AttributeController@filter_attributes']);
        Route::post('attributeSave', ['as' => 'attributeSave', 'uses' => 'App\Http\Controllers\AttributeController@attributeSave']);
        Route::post('updateAttribute', ['as' => 'updateAttribute', 'uses' => 'App\Http\Controllers\AttributeController@updateAttribute']);
        Route::get('fetchAttribute', 'App\Http\Controllers\AttributeController@fetchAttribute');
        // Route::post('attribute/delete',[ 'as' =>'attribute/delete','uses'=>'App\Http\Controllers\AttributeController@destroy']);
        
        //attributesoptions
        Route::resource('attribute-options', 'App\Http\Controllers\AttributeOptionsController');
        Route::get('filter_attributesOption', ['as' => 'filter_attributesOption', 'uses' => 'App\Http\Controllers\AttributeOptionsController@filter_attributesOption']);
        Route::post('attributeOptionStore', ['as' => 'attributeOptionStore', 'uses' => 'App\Http\Controllers\AttributeOptionsController@store']);
        Route::post('attributeOptionUpdate', ['as' => 'attributeOptionUpdate', 'uses' => 'App\Http\Controllers\AttributeOptionsController@update']);
        // Route::post('attribute-options/delete',[ 'as' =>'attribute-options/delete','uses'=>'App\Http\Controllers\AttributeOptionsController@destroy']);
        //banner
        Route::resource('banner', 'App\Http\Controllers\BannerController');
        Route::get('filter_banner', ['as' => 'filter_banner', 'uses' => 'App\Http\Controllers\BannerController@filter_banner']);
        Route::post('bannerStore', ['as' => 'bannerStore', 'uses' => 'App\Http\Controllers\BannerController@store']);
        Route::post('bannerUpdate', ['as' => 'bannerUpdate', 'uses' => 'App\Http\Controllers\BannerController@update']);
        // Route::post('banner/delete',[ 'as' =>'banner/delete','uses'=>'App\Http\Controllers\BannerController@destroy']);
        // Route::post('bannerView',[ 'as'=>'bannerView', 'uses'=>'App\Http\Controllers\BannerController@bannerView']);
        Route::get('banner-view/{id}', 'App\Http\Controllers\BannerController@bannerViewPage')->name('banner.view');
    
        //cms
        Route::resource('cms', 'App\Http\Controllers\CmsController');
        // Route::post('cms/delete', 'App\Http\Controllers\CmsController@destroy');
        Route::get('filter_cms', ['as' => 'filter_cms', 'uses' => 'App\Http\Controllers\CmsController@filter_cms']);
        Route::post('cmsStore', ['as' => 'cmsStore', 'uses' => 'App\Http\Controllers\CmsController@store']);
        Route::post('cmsUpdate', ['as' => 'cmsUpdate', 'uses' => 'App\Http\Controllers\CmsController@update']);
        Route::get('cmsView', ['as' => 'cmsView', 'uses' => 'App\Http\Controllers\CmsController@cmsView']);
        Route::post('cmsStatusChange', ['as' => 'cmsStatusChange', 'uses' => 'App\Http\Controllers\CmsController@cmsStatusChange']);
    
        //ORDER
        Route::resource('orders', 'App\Http\Controllers\OrderController');
        Route::get('filter_order', ['as' => 'filter_order', 'uses' => 'App\Http\Controllers\OrderController@filter_order']);
        Route::post('orderStatusChange', ['as' => 'orderStatusChange', 'uses' => 'App\Http\Controllers\OrderController@orderStatusChange']);
        Route::post('deliveryStatusChange', ['as' => 'deliveryStatusChange', 'uses' => 'App\Http\Controllers\OrderController@deliveryStatusChange']);
        Route::post('getStatus', ['as' => 'getStatus', 'uses' => 'App\Http\Controllers\OrderController@getStatus']);
        Route::post('orderUpdate', ['as' => 'orderUpdate', 'uses' => 'App\Http\Controllers\OrderController@orderUpdate']);
    
        //faq
        Route::resource('general-faq', 'App\Http\Controllers\FaqController');
        Route::get('faq-view/{id}', 'App\Http\Controllers\FaqController@faqViewPage')->name('faq.view');
    // Route::post('general-faq/delete','App\Http\Controllers\FaqController@destroy');
        Route::get('filter_faq', ['as' => 'filter_faq', 'uses' => 'App\Http\Controllers\FaqController@filter_faq']);
        Route::post('faqStore', ['as' => 'faqStore', 'uses' => 'App\Http\Controllers\FaqController@store']);
        Route::post('faqUpdate', ['as' => 'faqUpdate', 'uses' => 'App\Http\Controllers\FaqController@update']);
        Route::get('get-faq-question', 'App\Http\Controllers\FaqController@getQuestion');
        Route::delete('delete-question/{id}','App\Http\Controllers\FaqController@deleteQuestion')->name('question.delete');
        Route::get('faqView', 'App\Http\Controllers\FaqController@faqViewPage');
    
        //contact
        Route::resource('contact', 'App\Http\Controllers\ContactController');
        Route::get('filter_contact', ['as' => 'filter_contact', 'uses' => 'App\Http\Controllers\ContactController@filter']);
        Route::get('messageView', 'App\Http\Controllers\ContactController@messageView');
    
        //customer
        Route::resource('customers', 'App\Http\Controllers\CustomerController');
        Route::get('customerView', 'App\Http\Controllers\CustomerController@customerView');
        Route::get('filter_customer', ['as' => 'filter_customer', 'uses' => 'App\Http\Controllers\CustomerController@filter_customer']);
        Route::post('customerUpdate', ['as' => 'customerUpdate', 'uses' => 'App\Http\Controllers\CustomerController@update']);
    
        //salesreport
    
        Route::get('sales-report', ['as' => 'sales-report', 'uses' => 'App\Http\Controllers\SalesReportController@index']);
        Route::get('filter_salesrpt', ['as' => 'filter_salesrpt', 'uses' => 'App\Http\Controllers\SalesReportController@filter_salesrpt']);
        Route::post('downloadSalesReport', ['as' => 'downloadSalesReport', 'uses' => 'App\Http\Controllers\SalesReportController@downloadSalesReport']);
        Route::post('exportSalesReport', ['as' => 'exportSalesReport', 'uses' => 'App\Http\Controllers\SalesReportController@exportSalesReport']);
        Route::post('export-productwise-salesReport', ['as' => 'export-productwise-salesReport', 'uses' => 'App\Http\Controllers\SalesReportController@exportProductwiseSalesReport']);
    
        //invoice
        Route::resource('invoice', 'App\Http\Controllers\InvoiceController');
        Route::get('filter_invoice', ['as' => 'filter_invoice', 'uses' => 'App\Http\Controllers\InvoiceController@filter_invoice']);
        Route::get('download-invoice/{id}', ['as' => 'download-invoice', 'uses' => 'App\Http\Controllers\InvoiceController@downloadInvoice']);
    
        // configuration
        Route::resource('configuration', 'App\Http\Controllers\ConfigController');
        Route::post('config_status', 'App\Http\Controllers\ConfigController@configStatus');
    /*
        //Groups
        Route::resource('groups', 'App\Http\Controllers\GroupController');
        Route::get('filter_group', ['as' => 'filter_group', 'uses' => 'App\Http\Controllers\GroupController@filter_group']);
        Route::post('groupUpdate', ['as' => 'groupUpdate', 'uses' => 'App\Http\Controllers\GroupController@update']);
        Route::post('groups/delete', ['as' => 'groups/delete', 'uses' => 'App\Http\Controllers\GroupController@destroy']);
        Route::post('import-data', 'App\Http\Controllers\GroupController@import')->name('import.data');
        Route::get('search', 'App\Http\Controllers\GroupController@search');
    */
        //Coupon
        Route::resource('coupons', 'App\Http\Controllers\CouponController');
        Route::get('filter_coupon', ['as' => 'filter_coupon', 'uses' => 'App\Http\Controllers\CouponController@filter_coupon']);
        Route::post('couponUpdate', ['as' => 'couponUpdate', 'uses' => 'App\Http\Controllers\CouponController@update']);
        // Route::post('coupons/delete', ['as' => 'coupons/delete', 'uses' => 'App\Http\Controllers\CouponController@destroy']);
        Route::post('changeis_applied', ['as' => 'changeis_applied', 'uses' => 'App\Http\Controllers\CouponController@changeis_applied']);
        Route::post('changepublish_status', ['as' => 'changepublish_status', 'uses' => 'App\Http\Controllers\CouponController@changepublish_status']);
    
        // Route::get('fetchCoupon', 'App\Http\Controllers\CouponController@fetchCoupon');
    
        //review
        Route::resource('reviews', 'App\Http\Controllers\ReviewController');
        Route::get('filter_reviews', 'App\Http\Controllers\ReviewController@filter');
        Route::post('reviewShow', 'App\Http\Controllers\ReviewController@reviewShow');
        Route::post('review_delete', 'App\Http\Controllers\ReviewController@destroy');
        Route::post('changeApproveStatus', 'App\Http\Controllers\ReviewController@changeApproveStatus');
    
        //settings
        Route::resource('settings', 'App\Http\Controllers\SettingsController');
        Route::get('filter_settings', ['as' => 'filter_settings', 'uses' => 'App\Http\Controllers\SettingsController@filter_settings']);
        // Route::post('settingsUpdate/{id}', ['as' => 'settingsUpdate', 'uses' => 'App\Http\Controllers\SettingsController@update']);
        // Route::get('email-settings', [ 'as' => 'email-settings', 'uses' => 'App\Http\Controllers\SettingsController@emailSettings',]);
        Route::get('store-settings', ['as' => 'store-settings', 'uses' => 'App\Http\Controllers\SettingsController@storeSettings']);
        Route::post('changeEnableCart', ['as' => 'changeEnableCart', 'uses' => 'App\Http\Controllers\SettingsController@changeEnableCart']);
        Route::post('changeEnableLocalPickup', ['as' => 'changeEnableLocalPickup', 'uses' => 'App\Http\Controllers\SettingsController@changeEnableLocalPickup']);
    
        //product
        Route::resource('product', 'App\Http\Controllers\ProductController');
        Route::get('filter_product', ['as' => 'filter_product', 'uses' => 'App\Http\Controllers\ProductController@filter_product']);
        Route::post('productStore', ['as' => 'productStore', 'uses' => 'App\Http\Controllers\ProductController@store']);
        Route::post('productUpdate', ['as' => 'productUpdate', 'uses' => 'App\Http\Controllers\ProductController@update']);
        // Route::post('product/delete', ['as' => 'product/delete', 'uses' => 'App\Http\Controllers\ProductController@destroy']);
        Route::post('productView', ['as' => 'productView', 'uses' => 'App\Http\Controllers\ProductController@productView']);
        
        Route::post('changeNew_status', ['as' => 'changeNew_status', 'uses' => 'App\Http\Controllers\ProductController@changeNewStatus']);
        Route::post('changeTrending_status', ['as' => 'changeTrending_status', 'uses' => 'App\Http\Controllers\ProductController@changeTrendingStatus']);
         
        Route::post('changePublished_status', ['as' => 'changePublished_status', 'uses' => 'App\Http\Controllers\ProductController@changePublish_status']);
        Route::post('displayFirstVariation', ['as' => 'displayFirstVariation', 'uses' => 'App\Http\Controllers\ProductController@displayFirstVariation']);
        
        
        
        //new
        Route::post('displayVariation', ['as' => 'displayVariation', 'uses' => 'App\Http\Controllers\ProductController@displayVariation']);
        Route::post('attributeStore', ['as' => 'attributeStore', 'uses' => 'App\Http\Controllers\AttributeController@attributeStore']);
        Route::post('attributeOptionSave', ['as' => 'attributeOptionSave', 'uses' => 'App\Http\Controllers\AttributeController@attributeOptionSave']);
        Route::post('formOptionShow', ['as' => 'formOptionShow', 'uses' => 'App\Http\Controllers\AttributeController@formOptionShow']);
        Route::post('generalFormStore', ['as' => 'generalFormStore', 'uses' => 'App\Http\Controllers\ProductController@generalFormStore']);
        Route::post('validateData', ['as' => 'validateData', 'uses' => 'App\Http\Controllers\ProductController@validateData']);
        Route::post('variantFormSubmit', ['as' => 'variantFormSubmit', 'uses' => 'App\Http\Controllers\ProductController@variantFormSubmit']);
        Route::post('skuFormSubmit', ['as' => 'skuFormSubmit', 'uses' => 'App\Http\Controllers\ProductController@skuFormSubmit']);
        //product update
        Route::post('validateUpdateData', ['as' => 'validateUpdateData', 'uses' => 'App\Http\Controllers\ProductController@validateUpdateData']);
        Route::post('generalFormUpdate', ['as' => 'generalFormUpdate', 'uses' => 'App\Http\Controllers\ProductController@generalFormUpdate']);
        Route::post('variantFormUpdateSubmit', ['as' => 'variantFormUpdateSubmit', 'uses' => 'App\Http\Controllers\ProductController@variantFormUpdateSubmit']);
        Route::post('skuFormUpdate', ['as' => 'skuFormUpdate', 'uses' => 'App\Http\Controllers\ProductController@skuFormUpdate']);
        Route::post('displayVariationEdit', ['as' => 'displayVariationEdit', 'uses' => 'App\Http\Controllers\ProductController@displayVariationEdit']);
        Route::post('deleteSimpleAttributes', ['as' => 'deleteSimpleAttributes', 'uses' => 'App\Http\Controllers\ProductController@deleteSimpleAttributes']);
        Route::post('displayFirstVariationEdit', ['as' => 'displayFirstVariationEdit', 'uses' => 'App\Http\Controllers\ProductController@displayFirstVariationEdit']);
        Route::post('deleteVariableAttributes', ['as' => 'deleteVariableAttributes', 'uses' => 'App\Http\Controllers\ProductController@deleteVariableAttributes']);
    
        // Route::get('createInvoice',['as' => 'createInvoice', 'uses' => 'App\Http\Controllers\OrderController@createInvoice']);
        // Route::get('checkouttest',['as' => 'checkouttest', 'uses' => 'App\Http\Controllers\OrderController@checkouttest']);
    
        Route::post('checkSku', ['as' => 'checkSku', 'uses' => 'App\Http\Controllers\ProductController@checkSku']);
        Route::post('showAttributes', ['as' => 'showAttributes', 'uses' => 'App\Http\Controllers\ProductController@showAttributes']);
    
    
        Route::get('get_product_image','App\Http\Controllers\ProductController@getProductImage')->name('get_product_image');
        
        
        
        Route::resource('locations', 'App\Http\Controllers\LocationController');
        Route::get('filter_locations', ['as' => 'filter_locations', 'uses' => 'App\Http\Controllers\LocationController@filter_locations']);
        Route::post('locationsStore', ['as' => 'locationsStore', 'uses' => 'App\Http\Controllers\LocationController@store']);
        Route::post('locationsUpdate', ['as' => 'locationsUpdate', 'uses' => 'App\Http\Controllers\LocationController@update']);
        Route::get('locations-view/{id}', 'App\Http\Controllers\LocationController@locationsViewPage')->name('locations.view');
    
    
        Route::resource('offers', 'App\Http\Controllers\OfferController');
        Route::get('filter_offers', ['as' => 'filter_offers', 'uses' => 'App\Http\Controllers\OfferController@filter_offers']);
        Route::post('offersStore', ['as' => 'offersStore', 'uses' => 'App\Http\Controllers\OfferController@store']);
        Route::post('offersUpdate', ['as' => 'offersUpdate', 'uses' => 'App\Http\Controllers\OfferController@update']);
        Route::get('offers-view/{id}', 'App\Http\Controllers\OfferController@offersViewPage')->name('offers.view');
        Route::post('changeApply_status', ['as' => 'changeApply_status', 'uses' => 'App\Http\Controllers\OfferController@changeApplyStatus']);
        
        
        Route::resource('blog', 'App\Http\Controllers\BlogController');
        Route::get('filter_blog', ['as' => 'filter_blog', 'uses' => 'App\Http\Controllers\BlogController@filter_blog']);
        Route::post('blogStatusChange', ['as' => 'blogStatusChange', 'uses' => 'App\Http\Controllers\BlogController@BlogStatusChange']);

        Route::resource('staff', 'App\Http\Controllers\StaffController');
        Route::get('filter_staff', ['as' => 'filter_staff', 'uses' => 'App\Http\Controllers\StaffController@filter_staff']);
    
    
   
});



Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

Route::get('/refresh-all', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('route:cache');
    return '<h1>All cache cleared!</h1>';
});



Route::get('/test-schedule', function() {
    \Artisan::call('schedule:run');
    $output = \Artisan::output();
    
    return response()->json([
        'schedule_output' => $output,
        'timestamp' => now()
    ]);
});