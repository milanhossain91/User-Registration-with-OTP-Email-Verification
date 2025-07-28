<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\ChooseUsController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Api\TrainingController;
use App\Http\Controllers\Api\PermissionsController;

use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\ResetPasswordController;


// Public Routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
// Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm']);

Route::post('/send-otp', [ForgotPasswordController::class, 'sendOtp']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPasswordWithOtp']);

// Protected Routes
Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/loggeduser', [UserController::class, 'logged_user']);
    Route::post('/changepassword', [UserController::class, 'change_password']);
    
    

    //List
    Route::get('/role_list', [UserController::class, 'role_list']);
    Route::get('/permission_list', [UserController::class, 'permission_list']);
    Route::get('/user_list', [UserController::class, 'user_list']);
    Route::get('/all_user_list', [UserController::class, 'all_user_list']);

    Route::get('/user_show/{id}', [UserController::class, 'show']);

    //User Update
    Route::get('/user_edit/{id}', [UserController::class, 'user_edit']);
    Route::put('/user_update/{id}', [UserController::class, 'user_update']);

    Route::get('/role_wise_user', [UserController::class, 'role_wise_user']);

    //User Update
    Route::put('/user_update/{id}', [UserController::class, 'user_update']);

    //User Delete
    Route::delete('/user_delete/{id}', [UserController::class, 'user_delete']);

    //Assign Permission
    Route::put('/assign_permission/{id}', [UserController::class, 'assign_permission']);

    //role & permission
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);

    Route::get('/applications', [ApplicationController::class, 'index']);
    Route::get('/applications/{application}', [ApplicationController::class, 'show']);
    Route::put('/applications/{application}', [ApplicationController::class, 'update']);   // Full update
    Route::patch('/applications/{application}', [ApplicationController::class, 'update']); // Partial update
    Route::delete('/applications/{application}', [ApplicationController::class, 'destroy']); // Delete

    Route::apiResource('courses', CourseController::class);
    Route::apiResource('trainings', TrainingController::class);
    Route::apiResource('choose-us', ChooseUsController::class);


    // Route::post('/courses/{course}/custom-update', [CourseController::class, 'custom_update']);
    // Route::post('/trainings/{training}/custom-update', [TrainingController::class, 'custom_update']);
    // Route::post('/choose-us/{chooseUs}/custom-update', [ChooseUsController::class, 'custom_update']);

});


Route::post('/applications', [ApplicationController::class, 'store']);
Route::post('/login_user', [UserController::class, 'login_user']);

Route::get('/courses_list', [CourseController::class, 'courses_list']);
Route::get('/trainings_list', [TrainingController::class, 'trainings_list']);
Route::get('/choose_us_list', [ChooseUsController::class, 'choose_us_list']);


