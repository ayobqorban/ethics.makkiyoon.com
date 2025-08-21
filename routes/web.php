<?php
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Auth::routes();
//  login
Route::get('/login', [LoginController::class,'login'])->name('login');
Route::post('/phone',[LoginController::class,'check_phone'])->name('check_phone');
Route::get('/otp',[LoginController::class,'otp_form'])->name('otp_form');
Route::post('/otp_check',[LoginController::class,'otp_check'])->name('otp_check');

Route::middleware('auth')->group(function(){
    // users
    // Route::resource('/users',AccountController::class);
    // Route::resource('/users/{type}/index',AccountController::class);
    // Route::delete('/users/{id}', [AccountController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{type}',[AccountController::class,'user_list']);

}); // middleware Auth


// Route::get('/storage-link',function(){
//     $target = storage_path('app/public');
//     $link = $_SERVER['DOCUMENT_ROOT'].'/storage';
//     symlink($target,$link);
// });