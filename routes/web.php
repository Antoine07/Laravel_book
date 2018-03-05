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

// routes Front

Route::get('/', 'FrontController@index')->name('home');
// route pour afficher un livre, route sécurisée
Route::get('book/{id}', 'FrontController@show');

// retourne une resource en fonction de son id
Route::get('book/{id}', 'FrontController@show');

//afficher tous les livres d'un auteur 
Route::get('author/{id}', 'FrontController@showBookByAuthor');

// pour afficher tous les livres associés à un genre
Route::get('genre/{id}', 'FrontController@showBookByGenre');

Auth::routes();

// routes sécurisées 

Route::resource('admin/book', 'BookController')->middleware('auth');


Route::post('vote', 'FrontController@create')->name('vote');













