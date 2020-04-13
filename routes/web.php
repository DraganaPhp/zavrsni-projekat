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
Route::get('/blog-posts', 'BlogPostsController@index')->name('front.blog_posts.index');
Route::get('/blogs/single/{blogPost}', 'BlogPostsController@single')->name('front.blog_posts.single');
Route::get('/blogs/author/{blogPost}', 'BlogPostsController@blogPostsAuthor')->name('front.blog_posts.blog_posts_author');
Route::get('/blogs/category/{blogPost}', 'BlogPostsController@blogPostsCategory')->name('front.blog_posts.blog_posts_category');
Route::get('/blogs/tag/{tag}', 'BlogPostsController@blogPostsTag')->name('front.blog_posts.blog_posts_tag');
//Route::post('/blogs/search', 'BlogPostsController@blogPostsSearch')->name('front.blog_posts.blog_posts_search');
Route::get('/blogs/search', 'BlogPostsController@blogPostsSearch')->name('front.blog_posts.blog_posts_search');

Route::get('/comments/blogPost/{blogPost}}', 'CommentsController@blogPostComments')->name('front.comments.blog_post_comments');
Route::post('/comments/send-comment}', 'CommentsController@sendComment')->name('front.comments.send_comment');


Route::get('/contact-us', 'ContactController@index')->name('front.contact.index');
Route::post('/contact-us/send-message', 'ContactController@sendMessage')->name('front.contact.send_message');

Route::get('/home', 'HomeController@index')->name('home');


Auth::routes();

Route::middleware('auth')->prefix('/admin')->namespace('Admin')->group(function () {

    Route::get('/', 'IndexController@index')->name('admin.index.index');
});
Route::middleware('auth')->prefix('/admin')->namespace('Admin')->group(function () {

    Route::get('/', 'IndexController@index')->name('admin.index.index');


    //Routes for UsersController
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


    //Routes for SizesController
    Route::prefix('/tags')->group(function () {

        Route::get('/', 'TagsController@index')->name('admin.tags.index'); // /admin/tags
        Route::get('/add', 'TagsController@add')->name('admin.tags.add');
        Route::post('/insert', 'TagsController@insert')->name('admin.tags.insert');

        Route::get('/edit/{tag}', 'TagsController@edit')->name('admin.tags.edit');
        Route::post('/update/{tag}', 'TagsController@update')->name('admin.tags.update');

        Route::post('/delete', 'TagsController@delete')->name('admin.tags.delete');
        Route::post('/datatable', 'TagsController@datatable')->name('admin.tags.datatable');
    });

    //Routes for SlidesController
    Route::prefix('/slides')->group(function () {

        Route::get('/', 'SlidesController@index')->name('admin.slides.index'); // /admin/slides
        Route::get('/add', 'SlidesController@add')->name('admin.slides.add');
        Route::post('/insert', 'SlidesController@insert')->name('admin.slides.insert');

        Route::get('/edit/{slide}', 'SlidesController@edit')->name('admin.slides.edit');
        Route::post('/update/{slide}', 'SlidesController@update')->name('admin.slides.update');

        Route::post('/disable-status', 'SlidesController@disableStatus')->name('admin.slides.disable_status');
        Route::post('/enable-status', 'SlidesController@enableStatus')->name('admin.slides.enable_status');

        Route::post('/delete', 'SlidesController@delete')->name('admin.slides.delete');
        Route::post('/delete-photo/{slide}', 'SlidesController@deletePhoto')->name('admin.slides.delete_photo');
        Route::post('/change-priorities', 'SlidesController@changePriorities')->name('admin.slides.change_priorities');
    });

    //Routes for BlogPostCategoriesController
    Route::prefix('/blog-post-categories')->group(function () {

        Route::get('/', 'BlogPostCategoriesController@index')->name('admin.blog_post_categories.index'); // /admin/sizes
        Route::get('/add', 'BlogPostCategoriesController@add')->name('admin.blog_post_categories.add');
        Route::post('/insert', 'BlogPostCategoriesController@insert')->name('admin.blog_post_categories.insert');

        Route::get('/edit/{blogPostCategory}', 'BlogPostCategoriesController@edit')->name('admin.blog_post_categories.edit');
        Route::post('/update/{blogPostCategory}', 'BlogPostCategoriesController@update')->name('admin.blog_post_categories.update');

        Route::post('/delete', 'BlogPostCategoriesController@delete')->name('admin.blog_post_categories.delete');
        Route::post('/change-priorities', 'BlogPostCategoriesController@changePriorities')->name('admin.blog_post_categories.change_priorities');
    });

    //Routes for BlogPostsController
    Route::prefix('/blog-posts')->group(function () {

        Route::get('/', 'BlogPostsController@index')->name('admin.blog_posts.index');
        Route::get('/add', 'BlogPostsController@add')->name('admin.blog_posts.add');
        Route::post('/insert', 'BlogPostsController@insert')->name('admin.blog_posts.insert');

        Route::get('/edit/{blogPost}', 'BlogPostsController@edit')->name('admin.blog_posts.edit');
        Route::post('/update/{blogPost}', 'BlogPostsController@update')->name('admin.blog_posts.update');

        Route::post('/delete', 'BlogPostsController@delete')->name('admin.blog_posts.delete');
        Route::post('/disable', 'BlogPostsController@disable')->name('admin.blog_posts.disable');
        Route::post('/enable', 'BlogPostsController@enable')->name('admin.blog_posts.enable');
        Route::post('/make-unimportant', 'BlogPostsController@make_unimportant')->name('admin.blog_posts.make_unimportant');
        Route::post('/make-important', 'BlogPostsController@make_important')->name('admin.blog_posts.make_important');
        Route::post('/delete-photo/{blogPost}', 'BlogPostsController@deletePhoto')->name('admin.blog_posts.delete_photo');
        Route::post('/datatable', 'BlogPostsController@datatable')->name('admin.blog_posts.datatable');
    });

    //Routes for CommentsController
    Route::prefix('/comments')->group(function () {

        Route::get('/', 'CommentsController@index')->name('admin.comments.index');
        Route::post('/disable', 'CommentsController@disable')->name('admin.comments.disable');
        Route::post('/enable', 'CommentsController@enable')->name('admin.comments.enable');
        Route::post('/datatable', 'CommentsController@datatable')->name('admin.comments.datatable');
    });
});
