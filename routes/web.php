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

Auth::routes();
Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::get('/about', 'PageController@about')->name('about');
Route::get('/contact', 'PageController@contact')->name('contact');
Route::post('/contact', 'PageController@sendContact');

Route::get('/upload', 'UploadController@getUpload')->name('upload');
Route::post('/upload', 'UploadController@postUpload');
Route::get('/upload/{id}', 'UploadController@download')->name('upload.download');
//Route::post('ckeditor/image_upload', 'UploadController@upload');


Route::get('/questions/search', 'QuestionController@search')->name('questions.search');
Route::get('/questions/searchjs', 'QuestionController@searchjs')->name('questions.searchjs');
Route::get('/questions/create', 'QuestionController@create')->name('questions.create');
Route::get('/questions/index', 'QuestionController@index')->name('questions.index');
Route::get('/questions/show/{username}', 'QuestionController@show')->name('questions.show');
Route::get('/questions/{username}/edit', 'QuestionController@edit')->name('questions.edit');
Route::post('/questions/store', 'QuestionController@store')->name('questions.store');
Route::get('/questions/{username}/destroy', 'QuestionController@destroy')->name('questions.destroy');

Route::get('/answers/{username}/edit', 'AnswersController@edit')->name('answers.edit');
Route::post('/answers/store', 'AnswersController@store')->name('answers.store');
Route::get('/answers/{username}/destroy', 'AnswersController@destroy')->name('answers.destroy');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('profile/{user}', 'PageController@profile')->name('profile');
Route::get('subscribe/{user}', 'PageController@subscribe')->name('subscribe');
Route::get('/recent', 'PageController@recent')->name('recent');
Route::get('/popular', 'PageController@popular')->name('popular');
Route::get('_includes.nav.topnav', 'PageController@template')->name('template');
Route::resource('categories', 'CategoriesController');

Route::get('/github/{username}', 'ApiController@github')->name('github');

Route::get('/login/{provider}', 'Auth\SocialAccountController@redirectToProvider');
Route::get('/login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');

Route::get('pay/{plan}', 'PaymentsController@pay')->name('pay');
Route::post('pay/{plan}', 'PaymentsController@pay');
Route::get('cancel', 'PaymentsController@cancel')->name('cancel');
Route::get('user/invoice/{invoiceId}', 'PaymentsController@invoice')->name('invoice');
