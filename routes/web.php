<?php

use App\Http\Controllers\CustomAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/login',[CustomAuthController::class,'login'])->middleware('alreadyLoggedUser');
Route::get('/registration',[CustomAuthController::class,'registration'])->middleware('alreadyLoggedUser');
Route::post('/user-registration',[CustomAuthController::class,'saveUser']);
Route::post('/user-login',[CustomAuthController::class,'loginUser']);
Route::get('/dashboard',[CustomAuthController::class,'dashboard'])->middleware('isLoggedIn');
Route::get('/logout',[CustomAuthController::class,'logout']);
