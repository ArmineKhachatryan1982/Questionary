<?php

use App\Http\Controllers\API\GetCategoryController;
use App\Http\Controllers\API\GetTestViaLinkController;
use App\Http\Controllers\API\TestController;
use App\Http\Controllers\API\UserPastedTestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
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

Route::group([
    'prefix' => 'auth'

], function ($router) {
    Route::post('register',RegisterController::class);
    Route::post('login', [AuthController::class, 'login']);

    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    Route::group(["middleware"=> ['setlang']],function ($router) {
        Route::group(["middleware"=> ['apiAuth']],function ($router) {
        Route::get('get-categories', GetCategoryController::class);
        Route::post('test',TestController::class);
        });

    });


});

Route::group(["middleware"=> ['setlang']],function ($router) {

    Route::get('test/{link}',GetTestViaLinkController::class);
    Route::post('get-test-result',UserPastedTestController::class);

});

Route::get('google', [GoogleController::class, 'redirectToGoogle'])->name('google-auth');
Route::get('auth/google/call-back', [GoogleController::class, 'handleGoogleCallback']);



