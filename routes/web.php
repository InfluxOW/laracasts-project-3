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
/* Threads */
Route::get('threads/search', 'SearchController@show')->name('threads.search');
Route::get('threads', 'ThreadsController@index')->name('threads.index')->middleware('clean_query_string');
Route::get('threads/create', 'ThreadsController@create')->name('threads.create');
Route::get('threads/{channel:slug}', 'ThreadsController@index')->name('threads.filter')->middleware('clean_query_string');
Route::get('threads/{channel:slug}/{thread:slug}', 'ThreadsController@show')->name('threads.show');
Route::patch('threads/{thread}', 'ThreadsController@update')->name('threads.update');
Route::delete('threads/{thread}', 'ThreadsController@destroy')->name('threads.destroy');
Route::post('threads', 'ThreadsController@store')->name('threads.store');
Route::post('threads/{thread}/close', 'ClosedThreadsController@store')->name('closed-thread.store');
Route::post('threads/{thread}/pin', 'PinnedThreadsController@store')->name('pinned-threads.store')->middleware('admin');
Route::delete('threads/{thread}/pin', 'PinnedThreadsController@destroy')->name('pinned-threads.destroy')->middleware('admin');
/* User Profiles */
Route::resource('profiles', 'ProfilesController')->only('show', 'update')->parameters([
    'profiles' => 'user:username'
]);
/* Thread Replies */
Route::get('threads/{channel:slug}/{thread:slug}/replies', 'ThreadRepliesController@index')->name('threads.replies.index');
Route::post('threads/{channel:slug}/{thread:slug}/replies', 'ThreadRepliesController@store')->name('threads.replies.store');
Route::delete('replies/{reply}', 'ThreadRepliesController@destroy')->name('threads.replies.destroy');
Route::patch('replies/{reply}', 'ThreadRepliesController@update')->name('threads.replies.update');
Route::post('replies/{reply}/best', 'BestRepliesController@store')->name('best-reply.store');
/* Favorites */
Route::post('favorites/{favoriteableType}/{favoriteableId}', 'FavoritesController@store')->name('favorites.store');
Route::delete('favorites/{favoriteableType}/{favoriteableId}', 'FavoritesController@destroy')->name('favorites.destroy');
/* Subscriptions */
Route::post('subscriptions/{subscribableType}/{subscribableId}', 'SubscriptionsController@store')->name('subscriptions.store');
Route::delete('subscriptions/{subscribableType}/{subscribableId}', 'SubscriptionsController@destroy')->name('subscriptions.destroy');
/* Notifications */
Route::get('profiles/{user:username}/notifications', 'NotificationsController@index')->name('notifications.index');
Route::delete('profiles/{user:username}/notifications/{notification}', 'NotificationsController@destroy')->name('notifications.destroy');
/* Uploads */
Route::post('uploads/{filename}/{folder}', 'UploadsController@store')->name('uploads.store');

Auth::routes(['verify' => true]);

Route::name('api.')->namespace('Api')->prefix('api/')->group(function () {
    Route::get('users', 'UsersController@index')->name('users.index');
    Route::post('users/{user:username}/{filename}/{folder}', 'UserImagesController@store')->name('user.images.store');
});
/* Socialite */
Route::get('login/{provider}', 'Auth\SocialiteController@redirectToProvider')->name('socialite.login');
Route::get('login/{provider}/callback', 'Auth\SocialiteController@handleProviderCallback')->name('socialite.callback');
/* Admin dashboard */
Route::name('admin.')->namespace('Admin')->prefix('admin/')->middleware('admin')->group(function () {
    Route::view('/', 'admin.dashboard')->name('dashboard');
    Route::resource('channels', 'ChannelsController')->only('index', 'store', 'create', 'destroy', 'update');
});
