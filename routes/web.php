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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/post/create/{postGroup}', ['as' => 'post.create', 'uses' => 'PostController@create']);
Route::get('/post/create_post_group/{createPostGroup}', ['as' => 'post.create_post_group', 'uses' => 'PostController@create']);
Route::get('/post/destroy/image/{image}', ['as' => 'post.destroy_image', 'uses' => 'PostController@destroyImage']);
Route::resource('post', 'PostController', ['except' => ['create', 'edit']]);

Route::post('post/upload_image', ['as' => 'post.upload_image', 'uses' => 'PostController@uploadImage']);
Route::post('post/save_text', ['as' => 'post.save_text', 'uses' => 'PostController@saveText']);

Route::get('/collection/{postGroup}', ['as' => 'collection', 'uses' => 'CollectionController@group']);
