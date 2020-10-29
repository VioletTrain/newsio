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
Route::put('event', "Admin\EventController@edit")->name('edit_event');

Route::get('test', "TestController@test")->name('test');
