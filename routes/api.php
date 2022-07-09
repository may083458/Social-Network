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

Route::post('/auth/register', ['App\Http\Controllers\Api\AuthController', 'register']);

Route::post('/auth/login', ['App\Http\Controllers\Api\AuthController', 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/page/create', ['App\Http\Controllers\Api\PageController', 'create']);
    Route::put('/follow/person/{personId}', ['App\Http\Controllers\Api\FollowerController', 'followPerson']);
    Route::put('/follow/page/{pageId}', ['App\Http\Controllers\Api\FollowerController', 'followPage']);
    Route::post('/person/attach-post', ['App\Http\Controllers\Api\PostController', 'personAttachPost']);
    Route::post('/page/{pageid}/attach-post', ['App\Http\Controllers\Api\PostController', 'pageAttachPost']);
    Route::get('/person/feed', ['App\Http\Controllers\Api\PostController', 'feed']);
});
