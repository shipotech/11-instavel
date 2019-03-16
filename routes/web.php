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
Route::post('/scroll', 'HomeController@scroll');

Route::get('/php', 'PhpController@index');
// Dark Mode
Route::get('/dark', 'HomeController@darkMode')->name('dark');

// User Data
Route::get('/config', 'UserController@config')->name('config');
Route::post('/update/personal', 'UserController@updatePersonal')->name('user.personal');
Route::post('/update/login', 'UserController@updateLogin')->name('user.login');
Route::post('/update/password', 'UserController@updatePassword')->name('user.password');
Route::get('/profile/{id}', 'UserController@profile')->name('user.profile');
Route::post('/scroll/profile', 'UserController@scroll');

// People (all users)
Route::get('/people', 'UserController@index')->name('user.people');
Route::post('/scroll/people', 'UserController@scrollPeople');
Route::post('/search', 'UserController@search');

// Update Profile picture
Route::match(['get', 'post'], '/update/photo', 'ImageController@ajaxImage');

// Upload Images
Route::post('/upload', 'ImageController@store')->name('image.store');
Route::get('/image/{id}', 'ImageController@show')->name('image.show');
Route::get('/image/delete/{id}', 'ImageController@delete')->name('image.delete');
Route::get('/image/edit/{id}', 'ImageController@edit')->name('image.edit');
Route::post('/image/update', 'ImageController@update')->name('image.update');

// Comments
Route::post('/comment', 'CommentController@store')->name('comment.store');
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');

// Likes
Route::post('/like', 'LikeController@like')->name('like.store');
Route::post('/dislike', 'LikeController@dislike')->name('like.delete');
Route::post('/show-likes', 'LikeController@show');
