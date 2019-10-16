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

Route::get('/dashboard', 'DashboardController@index');
Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/games', 'GamesController@index');
    Route::get('/show', 'QuestionController@show');
    Route::get('/quiz', function () {
        return view('games.quiz');
    })->name('quiz');
});

Route::get('/fetch-questions', 'QuestionController@fetchQuestions');
