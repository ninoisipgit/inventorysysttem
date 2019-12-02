<?php

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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('home');
   });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/category', 'CategoryController@getCategoryPage')->middleware('auth');

Route::get('/supplier', 'SupplierController@getSupplierPage')->middleware('auth');

Route::get('/product', 'ProductController@getProductPage')->middleware('auth');


Route::post('/saveCategory', 'CategoryController@saveCategory');

Route::get('/getCategoryList','CategoryController@getCategory');

Route::post('/delCategory','CategoryController@delCategory');
// Supplier routes
Route::post('/saveSupplier', 'SupplierController@saveSupplier');

Route::get('/getSupplierList','SupplierController@getSupplier');

Route::post('/delSupplier','SupplierController@delSupplier');

// product  routes
Route::post('/saveProduct', 'ProductController@saveProduct');

Route::get('/getProductList','ProductController@getProduct');

Route::post('/delProduct','ProductController@delProduct');

// reports
Route::get('/pricereport', 'ReportsController@getPriceReportPage')->middleware('auth');

Route::get('/getAmountList','ReportsController@getAmountList');


// Route::get('/product', 'ReportsController@getProductPage')->middleware('auth');








