<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

// note that  the prefix is admin for all file route

Route::group(['namespace' => 'Dashboard', 'middleware' => 'auth:admin' , 'prefix'=>'admin'], function () {
    
   Route::get('/','DashboardController@index')->name('admin.dashboard'); // the first page admin visits if auth;
   Route::get('logout','LoginController@logout')->name('admin.logout'); 

    Route::group(['prefix' => 'settings'],function(){
      
      Route::get('shipping-methods/{type}','SettingsController@editShippingMethods')-> name('edit.shippings.methods');
      Route::PUT('shipping-methods/{id}','SettingsController@updateShippingMethods')-> name('update.shippings.methods');
    });
    Route::group(['prefix' => 'profile'],function(){
      
      Route::get('edit','profileController@editProfile')-> name('edit.profile');
      Route::PUT('update','profileController@updateProfile')-> name('update.profile');
    });

    ######################### albums routes ############################
    Route::group(['prefix' => 'albums'], function () {
      Route::get('/', 'AlbumsController@index')->name('admin.albums');
      Route::get('create', 'AlbumsController@create')->name('admin.albums.create');
      Route::post('store', 'AlbumsController@store')->name('admin.albums.store');
      Route::get('edit/{id}', 'AlbumsController@edit')->name('admin.albums.edit');
      Route::post('update/{id}', 'AlbumsController@update')->name('admin.albums.update');
      Route::get('delete/{id}', 'AlbumsController@destroy')->name('admin.albums.delete');
    });
      ######################### end albums  #############################


      

       ######################### albumImages  routes ############################
     
     Route::group(['prefix' => 'albumImages'], function () {
      Route::get('/', 'AlbumImagesController@index')->name('admin.albumImages');
      Route::get('general-information', 'AlbumImagesController@create')->name('admin.albumImages.general.create');
      Route::post('store-general-information', 'AlbumImagesController@store')->name('admin.albumImages.general.store');
       
      
      Route::get('images/{id}', 'AlbumImagesController@addImages')->name('admin.albumImages.images');
      Route::post('images', 'AlbumImagesController@saveProductImages')->name('admin.albumImages.images.store');
      Route::post('images/db', 'AlbumImagesController@saveProductImagesDB')->name('admin.albumImages.images.store.db');


      });
      ######################### end albumImages    #############################  
    
   
 });


 Route::group(['namespace' => 'Dashboard','middleware'=>'guest:admin','prefix'=>'admin'],function(){
    Route::get('login','LoginController@login')-> name('admin.login');
    Route::post('login','LoginController@postLogin')-> name('admin.post.login');
 });

 
 
