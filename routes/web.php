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

Route::get('/', function () {
    //you have to login
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/pertanyaan', 'PertanyaanController@index')->name('home');
Route::get('/pertanyaan/{id}', 'PertanyaanController@show')->name('show');
Route::post('/pertanyaan/create', 'PertanyaanController@create')->name('create');
Route::post('/pertanyaan/upVote/{id}', 'PertanyaanController@upVote')->name('upvote');
Route::post('/pertanyaan/downVote/{id}', 'PertanyaanController@downVote')->name('downvote');

Route::post('/jawaban/create/{id}', 'JawabanController@create')->name('createJawaban');
Route::post('/jawaban/upVote/{id}', 'JawabanController@upVote')->name('upvote');
Route::post('/jawaban/downVote/{id}', 'JawabanController@downVote')->name('downvote');
