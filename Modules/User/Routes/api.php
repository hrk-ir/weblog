<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Api\V1\UserController;
use Modules\User\Http\Controllers\Admin\UserController as AdminUserController;


/*
|--------------------------------------------------------------------------
| Routes For Role User
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => 'auth:api' ,  'prefix' => 'v1', 'as' => 'api.']  , function($router) {
    $router->post('profile' , [UserController::class, 'userProfile' ])->name('profile');
    $router->post('user/articles/like' , [UserController::class, 'articleLikes' ])->name('articleLikes');
    $router->post('user/articles/comment' , [UserController::class, 'articleComments' ])->name('articleComments');
});

/*
|--------------------------------------------------------------------------
| Routes For Role Admin
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['api' , 'isAdmin']  ,  'prefix' => 'dash' , 'as' => 'api.']  , function($router) {
    $router->get('users'  ,    [AdminUserController::class, 'users' ])->name('usersList');
});
