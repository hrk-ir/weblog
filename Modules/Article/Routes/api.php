<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes For Role Admin
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['auth:api' , 'isAdmin']  ,  'prefix' => 'dash', 'as' => 'api.']  , function($router) {
    $router->apiResource('articles', 'Admin\ArticleController');
});

/*
|--------------------------------------------------------------------------
| Routes For Role User
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['auth:api']  , 'prefix' => 'v1' , 'as' => 'api.']  , function($router) {
    $router->get('article/index' , 'Api\V1\ArticleController@index')->name('ArticlesList');
    $router->get('article/{id}' , 'Api\V1\ArticleController@show')->name('ArticleShow');
    $router->post('articles/groupBy/categories', 'Api\V1\ArticleController@ArticlesByCategories')->name('ArticlesByCategory');
    $router->post('article/{id}/add-like' , 'Api\V1\LikeController@addLikesToArticle')->name('addLikes')
        ->middleware('throttle:30,1');
    $router->post('article/{id}/remove-like' , 'Api\V1\LikeController@removeLikesToArticle')->name('disLikes')
        ->middleware('throttle:30,1');

});
