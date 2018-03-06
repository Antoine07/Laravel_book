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
Route::get('book/{id}', 'FrontController@show')->name('book_front');

//afficher tous les livres d'un auteur 
Route::get('author/{id}', 'FrontController@showBookByAuthor')->name('author_book');

// pour afficher tous les livres associés à un genre
Route::get('genre/{id}', 'FrontController@showBookByGenre')->name('genre_book');


Auth::routes();

// routes sécurisées 

Route::resource('admin/book', 'BookController')->middleware('auth');


Route::post('vote', 'FrontController@create')->name('vote');











