<?php

use Illuminate\Http\Request;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => ['api']], function ()
{
    Route::group(['prefix' => 'products'], function ()
    {
        Route::get('/', [
            'as' => 'products',
            'uses' => '\App\Http\Controllers\ProductsController@index'
        ]);

        Route::get('/concrete-category', [
            'as' => 'products',
            'uses' => '\App\Http\Controllers\ProductsController@getProductsOfConcreteCategory'
        ]);

        Route::post('/', [
            'as' => 'products.store',
            'uses' => '\App\Http\Controllers\ProductsController@store'
        ]);

        Route::put('/', [
            'as' => 'products.update',
            'uses' => '\App\Http\Controllers\ProductsController@update'
        ]);

        Route::delete('/{id}', [
            'as' => 'products.delete',
            'uses' => '\App\Http\Controllers\ProductsController@destroy'
        ]);
    });

    Route::group(['prefix' => 'categories'], function ()
    {
        Route::get('/', [
            'as' => 'categories',
            'uses' => '\App\Http\Controllers\CategoriesController@index'
        ]);

        Route::post('/', [
            'as' => 'categories.store',
            'uses' => '\App\Http\Controllers\CategoriesController@store'
        ]);

        Route::put('/', [
            'as' => 'categories.update',
            'uses' => '\App\Http\Controllers\CategoriesController@update'
        ]);

        Route::delete('/{id}', [
            'as' => 'categories.delete',
            'uses' => '\App\Http\Controllers\CategoriesController@destroy'
        ]);
    });
});