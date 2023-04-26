<?php

use App\Http\Controllers\ShortURLController;
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

Route::get('restore/{token}',[ShortURLController::class,'restore']);
Route::get('/remember_password',function (){
    return view('remember_password');
});
Route::get('partner-page',function (){
   return view('partner-page');
});
Route::get('login',function (){
    return view('login');
});
Route::get('profile',function (){
    return view('profile');
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
Route::get('rates',function (){
   return view('rates');
});
Route::get('dealHistory',function (){
    return view('deal');
});
Route::get('transactionHistory',function (){
    return view('transaction');
});
Route::get('sign/{token}',[ShortURLController::class,'sign']);

Route::get('client-page',function (){
    return view('client-page');
});
Route::get('lawyer-page',function (){
    return view('lawyer-page');
});

Route::get('super-admin',function (){
    return view('super-admin');
});

Route::get('manager-page',function (){
    return view('manager-page');
});
Route::get('test',function (){
    return view('test');
});
