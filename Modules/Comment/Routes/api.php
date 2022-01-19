<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Routes For Role Admin
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['api' , 'isAdmin']  ,  'prefix' => 'dash' , 'as' => 'api.']  , function($router) {
    $router->get('comments'  ,  'Admin\CommentController@index')->name('comments.index');
});

/*
|--------------------------------------------------------------------------
| Routes For Role User
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['api'] , 'prefix' => 'v1' , 'as' => 'api.']  , function($router) {
    $router->post('add-comment/article' , 'Api\V1\CommentController@addComment')->name('addComment');
    $router->post('remove-comment/article'  , 'Api\V1\CommentController@removeComment')->name('removeComment');
});
