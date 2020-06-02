<?php

use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
})->name('link');
Route::resource('post', 'PostFileController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('dowload', 'HomeController@download')->name('download');
Route::resource('upload', 'PostFileController');
Route::get('check-file-exists', 'HomeController@getName')->name('CheckFileExists');

