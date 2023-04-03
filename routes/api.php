<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\MediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//public
//Authentication
Route::post('/registration',[AuthController::class,'registration']);
Route::post('/login',[AuthController::class,'login']);

//blog
Route::get('/blogs',[BlogController::class,'show_all_blog']);
Route::get('/blogs/{id}',[BlogController::class,'show_single_blog']);
Route::delete('/blogs/delete/{id}',[BlogController::class,'destroy_blog']);

//media
Route::get('/medias',[MediaController::class,'show_all_media']);
Route::get('/medias/{id}',[MediaController::class,'show_single_media']);
Route::delete('/medias/delete/{id}',[MediaController::class,'destroy_media']);


Route::group(['middleware' => ['auth:sanctum']],function () {
    //Authentication
    Route::post('/logout',[AuthController::class,'logout']);
    //Blog
    Route::post('/blogs',[BlogController::class,'create_blog']);
    Route::post('/blogs/{id}',[BlogController::class,'update_blog']);
    
    //Media
    Route::post('/medias',[MediaController::class,'create_media']);
    Route::post('/medias/{id}',[MediaController::class,'update_media']);
    //Digital_Booth    
}
);
