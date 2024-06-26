<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Models\Appointment;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', [LoginController::class, 'logout']);

    Route::get('user', [UserController::class, 'current']);
    
    Route::get('roles', [RoleController::class, 'index']);
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::post('users/{user}', [UserController::class, 'update']);
    Route::delete('users/{user}', [UserController::class, 'destroy']);
    Route::get('courts', [CourtController::class, 'index']);
    Route::get('courts/{court}', [CourtController::class, 'show']);
    Route::post('courts/{court}', [CourtController::class, 'update']);
    Route::post('courts', [CourtController::class, 'store']);
    Route::delete('courts/{court}', [CourtController::class, 'destroy']);


    Route::post('appointment/{appointment}/users', [AppointmentUserController::class, 'update']);
    Route::post('appointment', [AppointmentController::class, 'store']);
    Route::get('appointments', [AppointmentController::class, 'index']);
    Route::get('appointmentsUser', [AppointmentController::class, 'getAppointment']);
    Route::get('appointment/{appointmentId}', [AppointmentController::class, 'getUserAppointment']);
    Route::put('appointment/{id}', [AppointmentController::class, 'updateStatus']);
    Route::get('lessons', [AppointmentController::class, 'getLessons']);
    Route::delete('appointment/{appointmentId}', [AppointmentController::class, 'destroy']);

    Route::patch('settings/profile', [ProfileController::class, 'update']);
    Route::patch('settings/password', [PasswordController::class, 'update']);
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);

    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

    Route::post('email/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend']);

    Route::post('oauth/{driver}', [OAuthController::class, 'redirect']);
    Route::get('oauth/{driver}/callback', [OAuthController::class, 'handleCallback'])->name('oauth.callback');
});
