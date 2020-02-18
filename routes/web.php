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

Route::get('/', function () {
    $companies = \App\Company::all();
    $cities = \App\City::all();
    return view('list')->with(['companies' => $companies, 'cities' => $cities]);
})->name('home');

Route::post('/company/delete/{id}', 'HomeController@delete')->name('delete-company');
Route::get('/company/{id}', 'HomeController@edit')->name('edit-company');
Route::post('/company/modify/{id}', 'HomeController@modify')->name('modify-company');
Route::post('/company/store', 'HomeController@store')->name('store-company');
