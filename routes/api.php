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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('products','ProductController');
Route::post('/rating/new','DetailController@setrating')->name('setrating');
Route::get('/rating/{id}','DetailController@getrating')->name('getrating');//for review refer part 29
Route::get('/product/search','DetailController@search');//search using vue
