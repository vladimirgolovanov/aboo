<?php

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('post', 'PostController', ['except' => ['create', 'edit', 'index']]);
Route::get('/post/create/{postGroup}', ['as' => 'post.create', 'uses' => 'PostController@create']);
Route::get('/post/create_post_group/{postGroupType}', ['as' => 'post.create_post_group', 'uses' => 'PostController@createPostGroup']);
Route::get('/post/destroy/image/{image}', ['as' => 'post.destroy_image', 'uses' => 'PostController@destroyImage']);
Route::get('/', ['as' => 'post.index', 'uses' => 'PostController@index']);
// @todo: use js and post here
Route::get('post/archive/{post}', ['as' => 'post.archive', 'uses' => 'PostController@archivePost']);
Route::post('post/upload_image', ['as' => 'post.upload_image', 'uses' => 'PostController@uploadImage']);
Route::post('post/save_text', ['as' => 'post.save_text', 'uses' => 'PostController@saveText']);
Route::post('post/save_post_group_header', ['as' => 'post.save_post_group_header', 'uses' => 'PostController@savePostGroupHeader']);

Route::get('/collection/{postGroup}', ['as' => 'collection', 'uses' => 'CollectionController@group']);
Route::get('/collection/{postGroup}/{type}', 'CollectionController@group')
     ->where('type', 'archive')
     ->name('collection.archive');

Route::get('/wishlist/{postGroup}', 'WishlistController@group')->name('wishlist');
Route::get('/wishlist/{postGroup}/tag/{tag}', 'WishlistController@tag')->name('wishlist.tag');
Route::get('/wishlist/{postGroup}/{type}', 'WishlistController@group')
     ->where('type', 'archive')
     ->name('wishlist.archive');

Route::get('/user/{username}', 'PostController@userpage')->name('userpage');
