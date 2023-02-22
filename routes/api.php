<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BookshelfController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\BorrowedBookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register_murid',[AuthController::class, 'RegisterMurid']);
Route::post('/register_staff',[AuthController::class, 'RegisterStaff']);
Route::post('/login',[AuthController::class, 'login']);

Route::get('/staff', [StaffController::class, 'index']);
Route::get('/staff/{id}', [StaffController::class, 'show']);
Route::put('/staff/{id}', [StaffController::class, 'update']);
Route::delete('/staff/{id}', [StaffController::class, 'destroy']);

Route::get('/student', [MuridController::class, 'index']);
Route::get('/student/{id}', [MuridController::class, 'show']);
Route::put('/student/{id}', [MuridController::class, 'update']);
Route::delete('/student/{id}', [MuridController::class, 'destroy']);
Route::get('/fined_students', [MuridController::class, 'FinedStudents']);

Route::get('/bookshelf', [BookshelfController::class, 'index']);
Route::post('/bookshelf', [BookshelfController::class, 'store']);
Route::get('/bookshelf/{id}', [BookshelfController::class, 'show']);
Route::put('/bookshelf/{id}', [BookshelfController::class, 'update']);
Route::delete('/bookshelf/{id}', [BookshelfController::class, 'destroy']);

Route::get('/book', [BookController::class, 'index']);
Route::post('/book', [BookController::class, 'store']);
Route::get('/book/{id}', [BookController::class, 'show']);
Route::put('/book/{id}', [BookController::class, 'update']);
Route::delete('/book/{id}', [BookController::class, 'destroy']);

Route::get('/borrowed_book', [BorrowedBookController::class, 'index']);
Route::post('/borrowed_book', [BorrowedBookController::class, 'store']);
Route::get('/borrowed_book/{id}', [BorrowedBookController::class, 'show']);
Route::put('/borrowed_book/{id}', [BorrowedBookController::class, 'update']);
Route::delete('/borrowed_book/{id}', [BorrowedBookController::class, 'destroy']);
Route::delete('/borrowed_book/{id}', [BorrowedBookController::class, 'destroy']);
Route::put('/return_process/{id}', [BorrowedBookController::class, 'returnProcess']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});