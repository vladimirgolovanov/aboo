<?php

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/post/create/{postGroup}', ['as' => 'post.create', 'uses' => 'PostController@create']);
Route::get('/post/create_post_group/{postGroupType}', ['as' => 'post.create_post_group', 'uses' => 'PostController@createPostGroup']);
Route::get('/post/destroy/image/{image}', ['as' => 'post.destroy_image', 'uses' => 'PostController@destroyImage']);
Route::resource('post', 'PostController', ['except' => ['create', 'edit', 'index']]);

Route::get('/', ['as' => 'post.index', 'uses' => 'PostController@index']);
Route::post('post/upload_image', ['as' => 'post.upload_image', 'uses' => 'PostController@uploadImage']);
Route::post('post/save_text', ['as' => 'post.save_text', 'uses' => 'PostController@saveText']);

Route::get('/collection/{postGroup}', ['as' => 'collection', 'uses' => 'CollectionController@group']);

Route::get('/wishlist/{postGroup}', ['as' => 'wishlist', 'uses' => 'WishlistController@group']);

Route::get('/user/{username}', 'PostController@userpage')->name('userpage');
