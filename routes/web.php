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
    return view('welcome');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{user}', 'ProfilesController@index')->name('profile.show');

//Polls controller
Route::get('/p/polls','PollsController@index');
Route::get('/p/create', 'PollsController@create');
Route::post('/p', 'PollsController@store');
Route::get('/p/types_polls', 'PollsController@types_polls');
Route::get('/p/{poll}', 'PollsController@show');
Route::get('/p/get_poll/{id}', 'PollsController@get_poll');

//tournaments controller
Route::get('/t/tournaments','TournamentsController@index');

//Votes Controller
Route::get('/v/get_results/{poll}', 'VotesController@get_results_from_poll');
Route::post('/v/vote/{poll}', 'VotesController@make_vote');
