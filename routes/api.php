<?php

use App\Http\Controllers\ManagerController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('sendSMS',[SMSController::class,'send']);
Route::post('partner/create',[UserController::class,'create']);
Route::post('partner/sign',[UserController::class,'sign']);
Route::post('paymentResult',[UserController::class,'paymentResult']);
Route::middleware(['auth:sanctum', 'abilities:partner'])->group(function (): void {
    Route::prefix('partner')->group(function(){
        Route::post('/addDocs',[UserController::class,'addDocs']);
        Route::post('pay',[UserController::class,'payment']);

        Route::get('getActiveDocs',[UserController::class,'getActiveDocs']);
        Route::get('getDocs',[UserController::class,'getDocs']);

        Route::post('send',[UserController::class,'send']);
    });
});
Route::any('infobip',[SMSController::class,'infobip'])->name('infobip');
Route::prefix('manager')->group(function(){
   Route::post('/create',[ManagerController::class,'create']);
   Route::post('/approve',[ManagerController::class,'approve']);
});
