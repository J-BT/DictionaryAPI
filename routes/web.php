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

Route::get('/welcomeAPI', function(){
    // return view('welcomeAPI');
    return "<h1> Welcome to Dictionary API !! </h1>";
});

// Route::get('/jishoHistory/{id}', function($id){
//     // return view('welcomeAPI');
//     return App\Models\JishoHistory::find($id);
// });

// Route::get('/jishoHistories', function(){
//     // return view('welcomeAPI');
//     return App\Models\JishoHistory::all();
// });