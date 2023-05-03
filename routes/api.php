<?php

use App\Http\Controllers\LawyerController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerigramController;
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

//create unit tests for all routes


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('sendSMS',[SMSController::class,'send']);
Route::get('partner/create',[UserController::class,'create']);
Route::post('manager/add/account',[UserController::class,'managerCreate']);
Route::post('partner/sign',[UserController::class,'sign']);
Route::post('paymentResult',[UserController::class,'paymentResult']);
Route::middleware(['auth:sanctum', 'abilities:partner'])->group(function (): void {
    Route::prefix('partner')->group(function(){
        Route::post('addDocs',[UserController::class,'addDocs']);
        Route::get('pay',[UserController::class,'payment']);
        Route::get('getActiveDocs',[UserController::class,'getActiveDocs']);
        Route::get('getDocs',[UserController::class,'getDocs']);
        Route::get('send',[UserController::class,'send']);
        Route::get('logout',[UserController::class,'logout']);
        Route::get('profile',[UserController::class,'profile']);
        Route::get('approve',[UserController::class,'approve']);
        Route::get('getSendingSMS',[UserController::class,'getSendingSMS']);
        Route::get('getSigningSMS',[UserController::class,'getSigningSMS']);
        Route::get('transaction',[UserController::class,'transaction']);
    });
});
Route::any('infobip',[SMSController::class,'infobip'])->name('infobip');
Route::prefix('manager')->group(function(){
   Route::post('/create',[ManagerController::class,'create']);

});

Route::post('client/create',[UserController::class,'clientCreate']);
Route::middleware(['auth:sanctum', 'abilities:client'])->group(function(): void{
   Route::prefix('client')->group(function ():void{
      Route::get('getDocs',[UserController::class,'getClientDocs']);
   });
});
Route::middleware(['auth:sanctum','abilities:manager'])->group(function():void{
   Route::prefix('manager')->group(function(){
       Route::get('getAllDocs',[ManagerController::class,'getAll']);
       Route::post('approve',[ManagerController::class,'approve']);
    });
});
//verigram
Route::get('getAccessToken',[VerigramController::class,'getAccessToken']);
Route::post('fields',[VerigramController::class,'fields']);
Route::post('verilive',[VerigramController::class,'verilive']);
Route::post('bmg',[VerigramController::class,'bmg']);


//lawyer
Route::post('lawyer/create',[LawyerController::class,'create']);
Route::middleware(['auth:sanctum','abilities:lawyer'])->group(function():void{
    Route::prefix('lawyer')->group(function(){
        Route::get('uncheckingDocs',[LawyerController::class,'uncheckingDocs']);
        Route::post('approve',[LawyerController::class,'approve']);
    });

});

//remember
Route::get('/remember_password',[UserController::class,'remember_password']);
Route::get('/restore_password',[UserController::class,'restore_password']);
