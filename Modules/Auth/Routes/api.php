<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\V1\AuthController;

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

Route::group(['middleware' => 'api' , 'prefix' => 'v1', 'as' => 'api.']  , function($router) {
    $router->post('register' ,      [AuthController::class, 'register'])->name('register');
    $router->post('login'    ,      [AuthController::class, 'login'   ])->name('login');
    $router->post('reset/password', [AuthController::class, 'ResetPassword'])->name('resetPassword');
    $router->post('logout'   ,      [AuthController::class, 'logout'  ])->name('logout');
    $router->post('refresh'  ,      [AuthController::class, 'refresh' ])->name('refreshToken');
    $router->post('profile'  ,      [AuthController::class, 'profile' ])->name('profile');
});
