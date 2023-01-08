<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)->prefix("/auth/")->group(function () {
    Route::post("login", "login");
});

Route::controller(RegisterController::class)->prefix("/account/")->group(function () {
    Route::post("register", "register");
    Route::post("confirm-registration","confirmRegistration");
});
Route::controller(FriendController::class)->prefix("/friend/")->group(function () {
    Route::post("search", "findFriend");
    Route::post("add", "addFriend");
    Route::post("un-friend", "unFriend");
});
Route::controller(ConversationController::class)->prefix("/conversation/")->group(function () {
    Route::post("add", "addNewConversation");
    Route::post("leave", "leaveConversation");
});


