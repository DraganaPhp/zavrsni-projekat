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