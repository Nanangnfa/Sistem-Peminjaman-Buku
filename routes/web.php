<?php

use App\Models\Category;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RentlogController;
use App\Http\Controllers\BookRentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[PublicController::class, 'index']);

Route::middleware('only_guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticating']);
    Route::get('register', [AuthController::class, 'register']);
    Route::post('register', [AuthController::class, 'registerProcess']);
});

Route::middleware('auth')->group(function () {
    route::get('logout', [AuthController::class, 'logout']);
    route::get('profile', [UserController::class, 'profile'])->Middleware('only_client');

    Route::middleware('only_admin')->group(function () {
        route::get('dashboard', [DashboardController::class, 'index']);

        route::get('books', [BookController::class, 'index']);
        route::get('book-add', [BookController::class, 'add']);
        route::post('book-add', [BookController::class, 'store']);
        route::get('book-edit/{slug}', [BookController::class, 'edit']);
        route::post('book-edit/{slug}', [BookController::class, 'update']);
        route::get('book-delete/{slug}', [BookController::class, 'delete']);
        route::get('book-destroy/{slug}', [BookController::class, 'destroy']);
        route::get('book-deleted', [BookController::class, 'deletedBook']);
        route::get('book-restore/{slug}', [BookController::class, 'restore']);



        route::get('categories', [CategoryController::class, 'index']);
        route::get('category-add', [CategoryController::class, 'add']);
        route::post('category-add', [CategoryController::class, 'store']);
        route::get('category-edit/{slug}', [CategoryController::class, 'edit']);
        route::put('category-edit/{slug}', [CategoryController::class, 'update']);
        route::get('category-delete/{slug}', [CategoryController::class, 'delete']);
        route::get('category-destroy/{slug}', [CategoryController::class, 'destroy']);
        route::get('category-deleted', [CategoryController::class, 'deletedCategory']);
        route::get('category-restore/{slug}', [CategoryController::class, 'restore']);

        route::get('users', [UserController::class, 'index']);
        route::get('registered-users', [UserController::class, 'registeredUser']);
        route::get('user-detail/{slug}', [UserController::class, 'show']);
        route::get('user-approve/{slug}', [UserController::class, 'approve']);
        route::get('user-ban/{slug}', [UserController::class, 'delete']);
        route::get('user-destroy/{slug}', [UserController::class, 'destroy']);
        route::get('user-banned', [UserController::class, 'bannedUser']);
        route::get('user-restore/{slug}', [UserController::class, 'restore']);

        route::get('book-rent', [BookRentController::class, 'index']);
        route::post('book-rent', [BookRentController::class, 'store']);
        
        route::get('rent-logs', [RentlogController::class, 'index']);

        route::get('book-return', [BookRentController::class, 'returnBook']);
        route::post('book-return', [BookRentController::class, 'saveReturnBook']);
        
    });

});