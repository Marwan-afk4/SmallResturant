<?php

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\RequestController;
use App\Http\Controllers\Admin\RequestController as AdminRequestController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum','IsAdmin'])->group(function () {

//////////////////////////////////////// Menus //////////////////////////////////////////////////

    Route::post('/admin/add/menu',[MenuController::class,'addproduct']);

    Route::get('/admin/menu/{Resturantid}',[MenuController::class,'GetMenu']);

    Route::get('/admin/resturantsandcategories',[MenuController::class,'getResturantsandCategories']);

    Route::put('/admin/update/menu/{id}',[MenuController::class,'updateProduct']);

    Route::delete('/admin/delete/menu/{id}',[MenuController::class,'deleteProduct']);

////////////////////////////////////////////// User ///////////////////////////////////////

    Route::get('/admin/users',[UserController::class,'getUsers']);

//////////////////////////////////// All Bookings ////////////////////////////////////////

    Route::get('/admin/bookings',[AdminRequestController::class,'getBookings']);

    Route::put('/admin/acceptbooking/{id}',[AdminRequestController::class,'acceptBooking']);

    Route::put('/admin/rejectbooking/{id}',[AdminRequestController::class,'rejectBooking']);

});


Route::middleware(['auth:sanctum','IsUser'])->group(function () {

//////////////////////////////////////////////// Profile ///////////////////////////////////////////////

    Route::get('/user/profile', [ProfileController::class, 'profile']);

    Route::put('/user/profile/update', [ProfileController::class, 'update']);

    Route::delete('/user/logout', [ProfileController::class, 'logout']);

    Route::delete('/user/deleteaccount', [ProfileController::class, 'deleteAccount']);

////////////////////////////////////////// Tabels /////////////////////////////////////////

    Route::post('/user/availabletables', [BookingController::class, 'getAvailableTables']);

    Route::post('/user/booktable', [BookingController::class, 'bookTable']);

    Route::get('/user/mybookings', [RequestController::class, 'getbookings']);
});

