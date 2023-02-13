<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('user/store',[UserController::class,'store']);

Route::get('users/get/{flag}',[UserController::class,'index']);

Route::get('/test' ,function(){
    p("Wwrking");
});

// Route::get('user/{id}' ,[UserController::class , 'show']);

Route::middleware('auth:api')->delete('user/delete/{id}',[UserController::class ,'destroy']);
Route::put('user/put/{id}',[UserController::class ,'update']);
Route::patch('change-password/{id}',[UserController::class,'changePassword']);

// Route::middleware('auth:api')->group(function(){
//     Route::get('user/{id}' ,[UserController::class , 'show']);
// });
Route::middleware('auth:api')->post('create', [UserController::class, 'show']);