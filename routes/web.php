<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 首页
Route::get('/', 'HomeController@index')->name('home');
// 登录认证
Auth::routes(['verify' => true]);
// home模块下
Route::namespace('Home')->middleware('web')->group(function () {
    // 栏目
    Route::get('category/{alias}.html', 'CategoryController@index');
    // 文章
    Route::get('article/{aid}.html', 'ArticleController@index');
    // 下载资源
    Route::get('download', 'DownloadController@index');
    Route::get('download/detail/{rid}', 'DownloadController@detail');

});
// 需要登录验证路由
Route::namespace('Home')->middleware(['web','auth','verified'])->group(function () {
    // 个人主页
    Route::get('profile/index', 'ProfileController@index');
    // 账号设置
    Route::get('profile/site', 'ProfileController@site');
    // 重置邮箱
    Route::post('profile/reset_email', 'ProfileController@resetEmail');
    // 动态
    Route::get('profile/moment', 'ProfileController@moment');
    // 消息
    Route::get('profile/message', 'ProfileController@message');
    // 我的收藏
    Route::get('profile/star', 'ProfileController@star');
    // 基本资料
    Route::get('profile/info', 'ProfileController@info');
    Route::post('profile/updateinfo', 'ProfileController@updateInfo');
    // 评论
    Route::post('comment/store', 'CommentController@store');
    // 评论回复
    Route::post('comment/reply', 'CommentController@reply');
    // 文章点赞
    Route::get('article/praise/{aid}', 'ArticleController@praise');
    // 文章收藏
    Route::get('article/star/{aid}', 'ArticleController@star');
    // 上传头像
    Route::post('profile/upload_avatar', 'ProfileController@uploadAvatar');
    // 资源
    Route::resource('resource', 'ResourceController', ['except' => ['show']]);
    // 资源收藏
    Route::get('download/star/{rid}', 'DownloadController@star');
    // 资源下载
    Route::get('download/make/{rid}', 'DownloadController@make');
    // 金币消费明细
    Route::get('account/gold', 'AccountController@gold');

});
Route::namespace('Common')->middleware(['web','auth'])->group(function () {
    // 个人主页
    Route::post('mail/send_captcha', 'MailController@sendCaptcha');
});
//公共上传操作
Route::any('/upload', 'Common\UploadController@make');
Route::any('/compress_upload', 'Common\UploadController@compressUpload');

