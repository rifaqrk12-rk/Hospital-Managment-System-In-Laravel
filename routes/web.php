<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\login\RegisterController;
use App\Http\Middleware\CheckUser;
use App\Http\Middleware\CheckAdmin;

Route::get('register', function () {
    return view('login.register');
})->name('register');

Route::get('/', function () {

    return view('login.login');
})->name('login');

Route::post('login-process', [RegisterController::class, 'index'])->name('login-process');

Route::get('loginnow', [RegisterController::class, 'login'])->name('loginnow');



//patient middleware
Route::middleware(CheckUser::class)->group(function () {

    Route::get('patient-dashboard', function(){

        return view('layout.patient-dashboard');

    })->name('patient');
    Route::get('logoutnow', [RegisterController::class, 'logout']);

    Route::view('view-doctors','appointment.doctor')->name('view-doctors');
    Route::view('view-appointment','appointment.patient-appointment')->name('view');
 


});

//admin middleware
Route::middleware(CheckAdmin::class)->group(function () {

    Route::get('admin-dashboard', function(){

        return view('layout.admin-dashboard');

    })->name('admin');
    Route::get('logout', [RegisterController::class, 'logout']);

    Route::view('adddepartment','department.adddepartment')->name('adddepart');

    Route::view('adddoctor','doctor.adddoctor')->name('doctor');
       Route::view('check-appointment','appointment.checkappointment');
       Route::view('testing','welcome');

});

