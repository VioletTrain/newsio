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

Route::get('events/{removed?}', "EventController@events")->name('events');
Route::post('event', "EventController@create")->name('create_event');
Route::post('links', "EventController@addLinks")->name('add_link');

Route::get('websites/{status}', "WebsiteController@websites")->name('websites');
Route::post('website', "WebsiteController@apply")->name('apply_website');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::delete('event', 'EventController@removeEvent')->name('remove_event');
    Route::put('event', 'EventController@restoreEvent')->name('restore_event');
    Route::delete('link', 'EventController@removeLink')->name('remove_link');
    Route::put('link', 'EventController@restoreLink')->name('restore_link');
    //Route::put('event', "Admin\EventController@edit")->name('edit_event');
});

Route::get('test', "TestController@test")->name('test');
