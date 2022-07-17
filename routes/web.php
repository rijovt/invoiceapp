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

/*Route::get('/', function () {
    return view('auth.login');
});*/

Auth::routes();

Route::get('/', 'InvoiceController@index')->name('home');
Route::get('/create', 'InvoiceController@create')->name('create');
Route::post('/additem', 'InvoiceController@additem')->name('additem');
Route::delete('destroyitem/{item}', 'InvoiceController@destroyitem')->name('destroyitem');
Route::post('/finalize', 'InvoiceController@finalize')->name('finalize');
Route::get('print/{id}', 'InvoiceController@print')->name('print');