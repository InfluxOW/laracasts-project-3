<?php

use App\User;
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

Route::get('/', function () {
    return redirect()->route('login');
});
Route::view('/about', 'about')->name('about');

Route::get('threads', 'ThreadsController@index')->name('threads.index')->middleware('clean_query_string');
Route::get('threads/create', 'ThreadsController@create')->name('threads.create');
Route::get('threads/{channel:slug}', 'ThreadsController@index')->name('threads.filter')->middleware('clean_query_string');
Route::get('threads/{channel:slug}/{thread:slug}', 'ThreadsController@show')->name('threads.show');
Route::patch('threads/{thread}', 'ThreadsController@update')->name('threads.update');
Route::delete('threads/{thread}', 'ThreadsController@destroy')->name('threads.destroy');
Route::post('threads', 'ThreadsController@store')->name('threads.store');

Route::resource('profiles', 'ProfilesController')->only('show', 'edit', 'update')->parameters([
    'profiles' => 'user:username'
]);

Route::get('/threads/{channel:slug}/{thread:slug}/replies', 'ThreadRepliesController@index')->name('threads.replies.index');
Route::post('/threads/{channel:slug}/{thread:slug}/replies', 'ThreadRepliesController@store')->name('threads.replies.store');
Route::delete('replies/{reply}', 'ThreadRepliesController@destroy')->name('threads.replies.destroy');
Route::patch('replies/{reply}', 'ThreadRepliesController@update')->name('threads.replies.update');

Route::post('/favorites/{favoriteableType}/{favoriteableId}', 'FavoritesController@store')->name('favorites.store');
Route::delete('/favorites/{favoriteableType}/{favoriteableId}', 'FavoritesController@destroy')->name('favorites.destroy');

Route::post('/subscriptions/{subscribableType}/{subscribableId}', 'SubscriptionsController@store')->name('subscriptions.store');
Route::delete('/subscriptions/{subscribableType}/{subscribableId}', 'SubscriptionsController@destroy')->name('subscriptions.destroy');

Route::get('/profiles/{user:username}/notifications', 'NotificationsController@index')->name('notifications.index');
Route::delete('/profiles/{user:username}/notifications/{notification}', 'NotificationsController@destroy')->name('notifications.destroy');

Auth::routes();

Route::name('api.')->namespace('Api')->group(function () {
    Route::get('users', 'UsersController@index')->name('users.index');
    Route::post('users/{user:username}/avatar', 'UserAvatarsController@store')->name('avatars.store');
});
