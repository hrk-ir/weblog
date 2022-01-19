<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Http\Controllers\Api\DashboardController;

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

Route::group(['middleware' => ['api' , 'isAdmin']  ,  'prefix' => 'dash' , 'as' => 'api.']  , function($router) {
    $router->post('/'  ,    [DashboardController::class, 'index' ])->name('dashboard');
});
