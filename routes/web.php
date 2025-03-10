<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShuttleOfferController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
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

        //tags route
        Route::get('/tags', [TagController::class, 'index'])->name('admin.tags');
        Route::post('/tags', [TagController::class, 'store'])->name('admin.tags.store');
        Route::get('/tags/{tag:id}',[TagController::class,'edit'])->name('admin.tags.edit');
        Route::post('/tags/{tag:id}/update', [TagController::class, 'update'])->name('admin.tags.update');
        Route::delete('/tags/{tag:id}/delete', [TagController::class, 'destroy'])->name('admin.tags.destroy');

        //
        Route::get('/users', [UserController::class, 'index'])->name('admin.users');
        Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/users/{user:id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user:id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

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
