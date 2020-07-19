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

Route::view('/', 'welcome');

// Statuses routes
Route::get('statuses/{status}', 'StatusController@show')->name('statuses.show');
Route::get('statuses','StatusController@index')->name('statuses.index');
Route::post('statuses', 'StatusController@store')->name('statuses.store')->middleware('auth');

// Statuses Likes routes
Route::post('statuses/{status}/likes', 'StatusLikeController@store')->name('statuses.likes.store')->middleware('auth');
Route::delete('statuses/{status}/likes', 'StatusLikeController@destroy')->name('statuses.likes.destroy')->middleware('auth');

// Statuses Comments routes
Route::post('statuses/{status}/comments','StatusCommentController@store')->name('statuses.comments.store')->middleware('auth');

// Comments Likes routes
Route::post('comments/{comment}/likes', 'CommentLikeController@store')->name('comments.likes.store')->middleware('auth');
Route::delete('comments/{comment}/likes', 'CommentLikeController@destroy')->name('comments.likes.destroy')->middleware('auth');

// Users routes
Route::get('@{user}','UserController@show')->name('users.show');

// Users statuses routes
Route::get('users/{user}/statuses', 'UserStatusController@index')->name('users.statuses.index');

// Friendships routes
Route::post('friendships/{recipient}','FriendshipController@store')->name('friendships.store')->middleware('auth');
Route::delete('friendships/{user}','FriendshipController@destroy')->name('friendships.destroy')->middleware('auth');

// Request Friendships routes
Route::get('friendships/requests', 'AcceptFriendshipController@index')->name('accept-friendships.index')->middleware('auth');
Route::post('accept-friendships/{sender}', 'AcceptFriendshipController@store')->name('accept-friendships.store')->middleware('auth');
Route::delete('accept-friendships/{sender}', 'AcceptFriendshipController@destroy')->name('accept-friendships.destroy')->middleware('auth');

// Notification routes
Route::get('notifications', 'NotificationController@index')->name('notifications.index')->middleware('auth');

// Read Notification routes
Route::post('read-notifications/{notification}', 'ReadNotificationController@store')->name('read-notifications.store')->middleware('auth');
Route::delete('read-notifications/{notification}', 'ReadNotificationController@destroy')->name('read-notifications.destroy')->middleware('auth');

Route::auth();
