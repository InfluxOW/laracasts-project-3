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

Route::get('threads', 'ThreadsController@index')->name('threads.index');
Route::get('threads/create', 'ThreadsController@create')->name('threads.create');
Route::get('threads/{channel:slug}', 'ThreadsController@index')->name('threads.filter');
Route::get('threads/{channel:slug}/{thread:slug}', 'ThreadsController@show')->name('threads.show');;
Route::patch('threads/{channel:slug}/{thread}', 'ThreadsController@update')->name('threads.update');
Route::delete('threads/{channel:slug}/{thread}', 'ThreadsController@destroy')->name('threads.destroy');
Route::post('threads', 'ThreadsController@store')->name('threads.store');

Route::post('/threads/{channel:slug}/{thread}/replies', 'ThreadRepliesController@store')->name('threads.replies.store');

Auth::routes();
