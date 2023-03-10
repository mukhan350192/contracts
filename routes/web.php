<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register',function (){
   return view('register');
});

Route::get('partner-page',function (){
   return view('partner-page');
});
Route::get('login',function (){
    return view('login');
});
Route::get('upload',function (){
    return view('upload');
});
Route::get('send',function (){
    return view('send');
});
Route::get('payment',function (){
    return view('payment');
});
