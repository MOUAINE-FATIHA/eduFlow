<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RecommendationController;
use App\Http\Controllers\Api\WishlistController;


Route::prefix('auth')->group(function () {
    Route::post('register',       [AuthController::class, 'register']);
    Route::post('login',          [AuthController::class, 'login']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});

Route::middleware('auth:api')->group(function () {

    Route::post('auth/logout', [AuthController::class, 'logout']);

    Route::get('courses',     [CourseController::class, 'index']);
    Route::get('courses/{id}', [CourseController::class, 'show']);

    Route::middleware('role:teacher')->prefix('teacher')->group(function () {
        Route::get('courses',         [CourseController::class, 'myCourses']);
        Route::post('courses',        [CourseController::class, 'store']);
        Route::put('courses/{id}',    [CourseController::class, 'update']);
        Route::delete('courses/{id}', [CourseController::class, 'destroy']);
    });

});

Route::middleware('role:student')->prefix('student')->group(function () {
    Route::get('recommendations',      [RecommendationController::class, 'index']);
    Route::post('interests',           [RecommendationController::class, 'updateInterests']);
    Route::get('wishlist',             [WishlistController::class, 'index']);
    Route::post('wishlist',            [WishlistController::class, 'store']);
    Route::delete('wishlist/{courseId}', [WishlistController::class, 'destroy']);
});
