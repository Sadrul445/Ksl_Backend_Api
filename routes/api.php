<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BoothController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\IpoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//public
//Mail
Route::post('/contact-form', [ContactController::class, 'submitForm']);

//Authentication
Route::post('/registration', [AuthController::class, 'registration']);
Route::post('/login', [AuthController::class, 'login']);

//Blog
Route::get('/blogs', [BlogController::class, 'show_all_blog']);
Route::get('/blogs/{id}', [BlogController::class, 'show_single_blog']);
Route::delete('/blogs/delete/{blog_id}', [BlogController::class, 'destroy_blog']);

//Media
Route::get('/medias', [MediaController::class, 'show_all_media']);
Route::get('/medias/{id}', [MediaController::class, 'show_single_media']);
Route::delete('/medias/delete/{media_id}', [MediaController::class, 'destroy_media']);

//Booth
Route::get('/booths', [BoothController::class, 'show_all_booths']);
Route::get('/booths/{id}', [BoothController::class, 'show_single_booths']);
Route::delete('/booths/delete/{booth_id}', [BoothController::class, 'delete_booths']);

//Branch
Route::get('/branches', [BranchController::class, 'show_all_branches']);
Route::get('/branches/{id}', [BranchController::class, 'show_single_branches']);
Route::delete('/branches/delete/{branch_id}', [BranchController::class, 'delete_branches']);

//Employee
Route::get('/employees', [EmployeeController::class, 'show_all_employee']);
Route::get('/employees/{id}', [EmployeeController::class, 'show_single_employee']);
Route::delete('/employees/delete/{employee_id}', [EmployeeController::class, 'delete_employee']);

//Ipo
Route::get('/ipo', [IpoController::class, 'show_all_ipo']);
Route::get('/ipo/{id}', [IpoController::class, 'show_single_ipo']);
Route::delete('/ipo/delete/{id}', [IpoController::class, 'delete_ipo']);

Route::group(
    ['middleware' => ['auth:sanctum']],
    function () {
        //Authentication
        Route::post('/logout', [AuthController::class, 'logout']);

        //Blog
        Route::post('/blogs', [BlogController::class, 'create_blog']);
        Route::post('/blogs/{id}', [BlogController::class, 'update_blog']);

        //Booth
        Route::post('/booths', [BoothController::class, 'create_booths']);
        Route::post('/booths/{id}', [BoothController::class, 'update_booths']);
        //Branch
        Route::post('/branches', [BranchController::class, 'create_branches']);
        Route::post('/branches/{id}', [BranchController::class, 'update_branches']);

        //Employee
        Route::post('/employees', [EmployeeController::class, 'create_employee']);
        Route::post('/employees/{id}', [EmployeeController::class, 'update_employee']);

        //Ipo
        Route::post('/ipo', [IpoController::class, 'create_ipo']);
        Route::post('/ipo/{id}', [IpoController::class, 'update_ipo']);

        //Media
        Route::post('/medias', [MediaController::class, 'create_media']);
        Route::post('/medias/{id}', [MediaController::class, 'update_media']);
    }
);
