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
    if (Auth::check()) {
        return redirect('/' . auth()->user()->username);
    } else {
        return redirect('/auth/login');
    }
});

// Authentication Routes...
Route::get('/auth/{type}', 'Auth\LoginController@showAuthForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Auth::Routes();

Route::get('/{user}', 'ProfilesController@index')->name('profile.show');

//Polls controller
Route::get('/p/polls', 'PollsController@index');
Route::get('/p/create', 'PollsController@create');
Route::post('/p', 'PollsController@store');
Route::get('/p/types_polls', 'PollsController@types_polls');
Route::get('/p/{poll}', 'PollsController@show');
Route::get('/p/get_poll/{id}', 'PollsController@get_poll');

//tournaments controller
Route::get('/t/tournaments', 'TournamentsController@index');
Route::get('/t/create', 'TournamentsController@create');
Route::post('/t', 'TournamentsController@create_tournament');
Route::get('/t/{tournament}', 'TournamentsController@edit');
Route::get('/t/{tournament}/preview', 'TournamentsController@tournament_preview');
Route::patch('/t/{tournament}', 'TournamentsController@update_tournament');

//Images controller
Route::get('/u/images', 'ImageController@index');
Route::post('/u/image', 'ImageController@store');


//Votes Controller
Route::get('/v/get_results/{poll}', 'VotesController@get_results_from_poll');
Route::post('/v/vote/{poll}', 'VotesController@make_vote');
