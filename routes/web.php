<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/login', [HomeController::class, 'viewLogin'])->name('loginPage');
Route::get('/register', [HomeController::class, 'viewRegister'])->name('registerPage');


Route::post('/user-register', [AuthController::class, 'register'])->name('register');
Route::post('/user-login', [AuthController::class, 'login'])->name('login');

Route::patch('/auth/verify-email/{verification_code}', [AuthController::class, 'verify_email'])->name('verify_email');