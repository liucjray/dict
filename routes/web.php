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

Route::get('/', 'DictionaryController@ce')
    ->name('dict:shanbay:ce');

Route::get('/ce/{word?}', 'DictionaryController@ce')
    ->name('dict:shanbay:ce');

Route::get('/cj/{word?}', 'DictionaryController@cj')
    ->name('dict:tianhuo:cj');