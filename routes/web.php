<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShuttleOfferController;
use App\Http\Middleware\Permissed;
use App\Http\Middleware\role;
use Illuminate\Support\Facades\Route;

// Apply Premissed middleware to all routes
Route::get('/', function () {
    return view('home');
})->name('home');
Route::middleware([Permissed::class])->group(function () {

    Route::group(['middleware' => 'auth'], function () {
        Route::prefix('dashboard')->group(function () {
            Route::get('/', function () {
                return view('admin.dashboard');
            });
        })->name('dashboard');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.create');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    Route::middleware(role::class . ':admin')->prefix('admin')->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles.index');
        Route::post('/roles', [RoleController::class, 'store'])->name('admin.roles.store');
        Route::get('/roles/{role:id}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');
        Route::post('/roles/{role:id}/edit', [RoleController::class, 'update'])->name('admin.roles.update');
        Route::delete('/roles/{role:id}/delete', [RoleController::class, 'destroy'])->name('admin.roles.delete');
    });

    Route::middleware(role::class . ':company')->prefix('company')->group(function () {
        Route::get('/shuttle', [ShuttleOfferController::class, 'index'])->name('offers.index');
        Route::get('/shuttle/create',[ShuttleOfferController::class,'create'])->name('shuttle_Offer');
        Route::post('/shuttle/create',[ShuttleOfferController::class,'store'])->name('shuttle_Offer.store');
        Route::get('/shuttle/{shuttle_offer:id}/edit',[ShuttleOfferController::class,'edit'])->name('shuttle_Offer.edit');
        Route::put('/shuttle/{shuttle_offer:id}/edit',[ShuttleOfferController::class,'update'])->name('shuttle_Offer.update');
        Route::delete('/shuttle/{shuttle_offer:id}/delete',[ShuttleOfferController::class,'destroy'])->name('shuttle_Offer.delete');
    });
});
