<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Models
use App\Models\User;

//Controllers
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ChangePasswordController;

use App\Http\Controllers\RoleController;

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

// Route::resource('products', ProductController::class);


Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
    return $request->user();
});


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::post('/forgot-password', [NewPasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [NewPasswordController::class, 'reset']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail']);
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');

Route::post('/change-password', [ChangePasswordController::class,'store'])->name('change.password');


Route::get('/roles', [RoleController::class, 'index']);
Route::post('/roles', [RoleController::class, 'store']);
Route::put('/roles/{id}', [RoleController::class, 'update']);
Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

});

