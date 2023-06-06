<?php

use App\Http\Controllers\LawyerController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PartnerDocumentController;
use App\Http\Controllers\PartnerSMSController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PaymentController;
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
Route::get('partner/create',[PartnerController::class,'create']);
//Route::post('manager/add/account',[UserController::class,'managerCreate']);
Route::post('partner/sign',[PartnerController::class,'sign']);
Route::post('paymentResult',[PaymentController::class,'paymentResult']);

Route::middleware(['auth:sanctum', 'abilities:partner'])->group(function (): void {
    Route::prefix('partner')->group(function(){
        Route::post('addDocs',[PartnerDocumentController::class,'addDocs']);
        //todo
        Route::get('pay',[UserController::class,'payment']);
        Route::get('getActiveDocs',[PartnerDocumentController::class,'getActiveDocs']);
        Route::get('getDocs',[PartnerDocumentController::class,'getDocs']);
        //todo
        Route::get('send',[UserController::class,'send']);

        Route::get('logout',[PartnerController::class,'logout']);
        Route::get('profile',[PartnerController::class,'profile']);


        Route::get('approve',[PartnerDocumentController::class,'approve']);

        Route::get('getSendingSMS',[PartnerSMSController::class,'getSendingSMS']);
        Route::get('getSigningSMS',[PartnerSMSController::class,'getSigningSMS']);
        Route::get('transaction',[PaymentController::class,'transaction']);
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
/*
Route::middleware(['auth:sanctum','abilities:manager'])->group(function():void{
   Route::prefix('manager')->group(function(){
       Route::get('getAllDocs',[ManagerController::class,'getAll']);
       Route::post('approve',[ManagerController::class,'approve']);
    });
});*/
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
Route::get('/remember_password',[PasswordController::class,'remember_password']);
Route::get('/restore_password',[PasswordController::class,'restore_password']);
