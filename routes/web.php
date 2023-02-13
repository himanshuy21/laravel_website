<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Models\textModel;

Route::get('/view', function () {
    return view('welcome');
});

Route::get('list' ,[textModel::class,'modelOperatiions']);
Route::get('count',[textModel::class,'countOperations']);
Route::get('wherename',[textModel::class,'whereOperations']);
Route::get('insert',[textModel::class,'insertOperations']);
Route::get('update',[textModel::class,'updateOperations']);
Route::get('delete',[textModel::class,'deleteOperations']);