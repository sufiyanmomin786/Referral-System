<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return redirect('/login');
});

Route::group(['middleware'=>['is_login']],function(){
    Route::get('/register', [UserController::class, 'loadRegister']);
    Route::post('/user-registered', [UserController::class, 'registered'])->name('registerd');

    Route::get('/referral-register',[UserController::class, 'loadReferralRegister']);
    Route::get('email-verification/{token}',[UserController::class, 'emailVerification']);

    Route::get('/login',[UserController::class,'loadLogin']);
    Route::post('/login',[UserController::class,'userLogin'])->name('login');
});

Route::group(['middleware'=>['is_logout']],function(){
    Route::get('/dashboard',[UserController::class,'loaddashboard']);
    Route::get('/logout',[UserController::class,'logout'])->name('logout');

});
