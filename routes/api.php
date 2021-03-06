<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('signup',[AuthController::class,'signUp']);
Route::post('login',[AuthController::class,'login']);
Route::get('UnAuthorized',[AuthController::class,'UnAuthorized'])->name('UnAuthorized'); 
Route::post('send',[ChatsController::class,'sendMessage']);
Route::get('userchats',[ChatsController::class,'userChats']);
Route::get('getchats',[ChatsController::class,'getChats']);
Route::get('chatmessages/{chatId}',[ChatsController::class,'chatMessages']);
