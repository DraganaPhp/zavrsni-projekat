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


Route::get('/', 'IndexController@index')->name('front.index.index');
;
Route::get('/blogs', 'BlogsController@index')->name('front.blogs.index');


Route::get('/blogs/single/{blog}', 'BlogsController@single')->name('front.blogs.single');


Route::get('/contact-us', 'ContactController@index')->name('front.contact.index');
Route::post('/contact-us/send-message', 'ContactController@sendMessage')->name('front.contact.send_message');

Route::get('/home', 'HomeController@index')->name('home');


Auth::routes();

Route::middleware('auth')->prefix('/admin')->namespace('Admin')->group(function () {

    Route::get('/', 'IndexController@index')->name('admin.index.index');
});
Route::middleware('auth')->prefix('/admin')->namespace('Admin')->group(function () {

    Route::get('/', 'IndexController@index')->name('admin.index.index');


   Route::prefix('/users')->group(function () {

        Route::get('/', 'UsersController@index')->name('admin.users.index'); // /admin/sizes
        Route::get('/add', 'UsersController@add')->name('admin.users.add');
        Route::post('/insert', 'UsersController@insert')->name('admin.users.insert');

        Route::get('/edit/{user}', 'UsersController@edit')->name('admin.users.edit');
        Route::post('/update/{user}', 'UsersController@update')->name('admin.users.update');

        Route::post('/delete', 'UsersController@delete')->name('admin.users.delete');
        Route::post('/disable-status', 'UsersController@disableStatus')->name('admin.users.disable_status');
        Route::post('/enable-status', 'UsersController@enableStatus')->name('admin.users.enable_status');
        Route::post('/delete-photo/{user}', 'UsersController@deletePhoto')->name('admin.users.delete_photo');
        Route::post('/datatable', 'UsersController@datatable')->name('admin.users.datatable');
    });


    Route::prefix('/profile')->group(function () {

        Route::get('/edit', 'ProfileController@edit')->name('admin.profile.edit');
        Route::post('/update', 'ProfileController@update')->name('admin.profile.update');

        Route::post('/delete-photo/', 'ProfileController@deletePhoto')->name('admin.profile.delete_photo');

        Route::get('/change-password', 'ProfileController@changePassword')->name('admin.profile.change_password');
        Route::post('/change-password', 'ProfileController@changePasswordConfirm')->name('admin.profile.change_password_confirm');
    });
});