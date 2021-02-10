<?php

use App\Notifications\newProductAddedNotification;
use App\Jobs\sendNotificationToAllAdminUser;
use App\Jobs\updateMosaicProductType;
use App\Product;
use App\ProductType;
use App\User;
use App\Role;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

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

Route::redirect('/', 'home', 301);

//home (auth)
Route::get('home', function () {
    if(auth()->user()->hasRoles(['superAdmin','admin'])){
        return redirect('dashboard');
    }else{
        return view('home');
    }
})->middleware('auth')->name('home');

//dashboard (superAdmin,admin)
Route::middleware(['auth','unlock'])->get('dashboard',function(){
    return view('dashboard');
})->name('dashboard');

//create user account
Route::middleware('role:superAdmin')->namespace('Auth')->name('user.')->group(function(){
    Route::get('create/new/user/account','RegisterController@showRegistrationForm')->name('create');
    Route::post('create/new/user/account','RegisterController@register')->name('create');
});

//update, view account (superAdmin,admin,seller,cashier )
//access right (auth,unlock)
Route::middleware(['auth','unlock'])->name('user.')->namespace('accounts')->group(function(){


        //view account (superAdmin,admin,seller,cashier)
        Route::get('profil/user/account/{user}','DisplayUserAccountController@showProfil')->name('profil')->where('user','[0-9]+');

        //update account (superAdmin,admin,seller,cashier)
        Route::get('profil/update/user/account/{user}','UpdateUserAccountController@showProfilUpdateForm')->name('profil.updateFrom')->where('user','[0-9]+');
        Route::post('profil/update/user/account','UpdateUserAccountController@updateProfil')->name('profil.update');


    //create,delete,lock,manage account (admin,seller,caschier)
    //access right(superAdmin)
    Route::middleware('role:superAdmin')->name('SuperAdmin.')->group(function(){

            //show user account
            Route::get('view/user/account/{user}','DisplayUserAccountController@showAccount')->name('account')->where('user','[0-9]+');

            //update account (superAdmin,admin,seller,cashier)
            Route::get('update/user/account/{user}','UpdateUserAccountController@showUserUpdateForm')->name('updateForm')->where('user','[0-9]+');
            Route::post('update/user/account','UpdateUserAccountController@update')->name('update');


            //delete user account
            Route::post('delete/user/account','DeleteUserAccountController@delete')->name('delete');

            //lock user account
            Route::post('lock/user/account','LockUserAccountController@toggleVault')->name('toggleVault');

            //reset user account
            Route::post('reset/user/account','ResetPasswordUserAccountController@reset')->name('reset');

            //manage user accounts
            Route::get('accounts/users','ManageUsersAccountController@showUsers')->name('users');
    });

});

//add,delete,manage product and provider (admin)
//access right (superAdmin,admin)
Route::middleware('role:superadmin,admin')->namespace('products')->name('product.')->group(function(){

        //add,delete,manage product (admin)
        //access right (superAdmin,admin)
        //add new product Ajax
        Route::post('add/new/product','AddNewProductController@addNewProduct')->name('add');
        //update product Ajax
        Route::post('update/product/{id}','UpdateProductController@UpdateProduct')->name('update');
        //get product data Ajax
        Route::get('get/product/{id}','ManageProductsController@getProduct')->name('data');
        //delete product Ajax
        Route::post('delete/product/{id}','DeleteProductController@deleteMultipleProduct')->name('delete');
        //delete multiple product Ajax
        Route::post('delete/multiple/product','DeleteProductController@deleteMultipleProduct')->name('multiple.delete');
         //show product Ajax
         Route::get('product/view/{id}','ManageProductsController@productInfo')->name('view');
        // //display all product present in a category and search
        Route::get('product/category/{categoryId}','ManageProductsController@productsList')->name('list');
        //auto search before hit enter ajax
        Route::get('autocomplete/search/product','ManageProductsController@RealTimeSearchProduct')->name('realTimeSearch');
        //search after hit enter get method
        // Route::get('search/product','ManageProductsController@ProductSearch')->name('search');

        //add,delete,manage stock (admin)
        //access right (superAdmin,admin)
        Route::middleware('role:superadmin,admin')->namespace('stocks')->name('stock.')->group(function(){
        // ajax add new stock ajax
        Route::post('add/new/stock','AddNewStockController@addNewStock')->name('add');
        //get stock data Ajax
        Route::get('get/stock/{id}','ManageStocksController@getStock')->name('data');
        //view stock info ajax
        Route::get('stock/view/{id}','ManageStocksController@stockInfo')->name('view');
        // aiax delete stock ajax
        Route::post('delete/stocks/{id}','DeleteStockController@deleteMultipleStock')->name('delete');
        // ajax delete Multiple Stock
        Route::post('delete/multiple/stock','DeleteStockController@deleteMultipleStock')->name('multiple.delete');
        // Ajax lock stock
        Route::get('stock/lock/{id}','LockStockController@lockStock')->name('lock');
        // Ajax delete stock item
        Route::post('delete/stock/item','DeleteStockController@deleteItem')->name('item.delete');
        // ajax update stock
        Route::post('stock/update/{id}','UpdateStockController@updateStock')->name('update');
        //generate stock barcode
        // Route::post('stock/barcode/{id}','ManageStocksController@stockInfo')->name('barcode');
        //display stock of product
        Route::get('stock/product/{productId}','ManageStocksController@stockList')->name('list');
         //auto search before hit enter ajax
         Route::get('autocomplete/search/stock','ManageStocksController@RealTimeSearchStock')->name('realTimeSearch');
         //delete multiple product Ajax
         Route::post('delete/multiple/stock','DeleteStockController@deleteMultipleStock')->name('multiple.delete');
        });

        //add,delete,manage provider (admin)
        //access right (superAdmin,admin)
         Route::namespace('providers')->name('provider.')->group(function(){

            //add new provider Ajax
            Route::post('add/new/provider','AddNewProviderController@addNewProvider')->name('add');
            //update provider Ajax
            Route::post('update/provider/{id}','UpdateProviderController@UpdateProvider')->name('update');
            //get provider data Ajax
            Route::get('get/product/provider/{id}','ManageProvidersController@getProvider')->name('data');
            //get all providers data Ajax
            Route::get('get/providers','ManageProvidersController@getAllProviders')->name('all');
            //delete provider Ajax
            Route::post('delete/provider/{id}','DeleteProviderController@deleteMultipleProvider')->name('delete');
            //delete multiple provider Ajax
            Route::post('delete/multiple/provider','DeleteProviderController@deleteMultipleProvider')->name('multiple.delete');
             //show providers Ajax
             Route::get('provider/view/{id}','ManageProvidersController@providerInfo')->name('view');
            //display providers list
            Route::get('product/providers','ManageProvidersController@providerList')->name('list');
            //auto search before hit enter ajax
            Route::get('autocomplete/search/provider','ManageProvidersController@realTimeSearchProvider')->name('realTimeSearch');
         });

                 //add,delete,manage category/type of product (admin)
        //access right (superAdmin,admin)
        Route::namespace('categories')->name('category.')->group(function(){

            //add new provider Ajax
            Route::post('add/new/category','AddNewCategoryController@addNewCategory')->name('add');
            //update provider Ajax
            Route::post('update/category/{id}','UpdateCategoryController@UpdateCategory')->name('update');
            //get provider data Ajax
            Route::get('get/product/category/{id}','ManageCategoriesController@getCategory')->name('data');
            //delete provider Ajax
            Route::post('delete/category/{id}','DeleteCategoryController@deleteMultipleCategory')->name('delete');
            //delete multiple provider Ajax
            Route::post('delete/multiple/category','DeleteCategoryController@deleteMultipleCategory')->name('multiple.delete');
             //show providers Ajax
             Route::get('category/view/{id}','ManageCategoriesController@categoryInfo')->name('view');
            //display providers list
            Route::get('product/categories','ManageCategoriesController@productsCategoryList')->name('list');
             //auto search before hit enter ajax
            Route::get('autocomplete/search/category','ManageCategoriesController@realTimeSearchCategory')->name('realTimeSearch');
         });

         //product
         // search autocomplete


        //read notification and delete
        Route::get('read/notifications','ManageProductsController@deleteUserNotifications')->name('notifications.read');

    });



//only for testing
Route::get('test',function(){

});

//desable password reset
//desable registration
//all authencation routes
Auth::routes([
    'reset'=>false,
    'register'=>false
    ]);
