<?php

use Illuminate\Http\Request;

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

$api = app(\Dingo\Api\Routing\Router::class);

$api->version('v1', ['namespace' => 'App\Http\Controllers\Api'], function ($api) {
    // 小程序认证，登录、授权、验证登录接口
    $api->post('/smallapp/login', 'OauthController@login');
    $api->post('/smallapp/oauth', 'OauthController@oauth');
    $api->get('/smallapp/token', 'OauthController@token');
});

#默认配置指定的是v1版本，可以直接通过 {host}/api/version 访问到
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
    // 认证
    $api->post('/login', 'AuthController@login');
    $api->get('/logout', 'AuthController@logout');
    $api->get('/me', 'AuthController@me');
    // 文章
    $api->get('/contents', 'ContentController@index');
    $api->get('/contents/{id}', 'ContentController@show');
    $api->get('/top_contents', 'ContentController@top');
    // banner
    $api->get('/banners/{limit?}', 'BannerController@index');
    // 栏目
    $api->get('/categories', 'CategoryController@index');
    // 博客
    $api->get('/blog', 'BlogController@index');
    $api->get('/blog/{id}', 'BlogController@show');
    // 博客banner
    $api->get('/blog_banners/{limit?}', 'BlogController@blogBanner');

});