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

Auth::routes();

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', 'HomeController@index')->name('home');

// Dark Mode
Route::get('/dark', 'HomeController@darkMode')->name('dark');

Route::get('/config', 'UserController@config')->name('config');
Route::post('/update/personal', 'UserController@updatePersonal')->name('user.personal');
Route::post('/update/login', 'UserController@updateLogin')->name('user.login');
Route::post('/update/password', 'UserController@updatePassword')->name('user.password');

// Update Profile picture
Route::match(['get', 'post'], '/update/photo', 'ImageController@ajaxImage');

// Upload Images
Route::post('/upload', 'ImageController@store')->name('image.store');
Route::get('/image/{id}', 'ImageController@show')->name('image.show');

// Comments
Route::post('/comment', 'CommentController@store')->name('comment.store');
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');

// Likes
Route::post('/like', 'LikeController@like')->name('like.store');
Route::post('/dislike', 'LikeController@dislike')->name('like.delete');
Route::post('/show-likes', 'LikeController@show')->name('like.show');
