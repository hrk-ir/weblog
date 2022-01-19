<?php


use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Routes For Role Admin
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['auth:api' , 'isAdmin']  ,  'prefix' => 'dash', 'as' => 'api.']  , function($router) {
    $router->apiResource('categories', 'Admin\CategoryController');
});

/*
|--------------------------------------------------------------------------
| Routes For Role User
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['auth:api']  , 'prefix' => 'v1' , 'as' => 'api.']  , function($router) {
    $router->get('categories' , 'Api\V1\CategoryController@index')->name('CategoryList');
    $router->get('category/{id}' , 'Api\V1\CategoryController@show')->name('CategoryShow');
});
