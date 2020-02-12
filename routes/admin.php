<?php
/**
 * Description：后台管理中心路由设置
 * Created by Phpstorm
 * User: chenxinfang
 * Date: 2019/11/6
 * Time: 19:07
 */

Route::name('admin.')->prefix('admin')->namespace('Admin')->middleware('web')->group(function () {
    // 用户登录
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login');
    // 用户退出
    Route::get('logout', 'LoginController@logout')->name('logout');
});
Route::prefix('admin')->namespace('Admin')->middleware(['web', 'auth.admin'])->group(function () {
    // 首页
    Route::get('/', 'IndexController@index');
    Route::get('index', 'IndexController@index')->name('admin.index');
    Route::middleware('permission')->group(function () {
        // 菜单
        Route::get('menu/synchro', 'MenuController@synchro')->name('admin.menu.synchro');
        Route::resource('menu', 'MenuController');
        Route::get('menu/delete/{menu}', 'MenuController@delete')->name('admin.menu.delete');
        // 角色
        Route::resource('role', 'RoleController');
        Route::get('role/permission/{role}', 'RoleController@permission')->name('admin.role.permission');
        Route::post('role/permission', 'RoleController@permissionStore')->name('admin.role.permission');
        // 管理员管理
        Route::resource('admin', 'AdminController');
        Route::get('admin/enable/{admin}', 'AdminController@enable')->name('admin.admin.enable');
        Route::get('admin/forbidden/{admin}', 'AdminController@forbidden')->name('admin.admin.forbidden');
        // 个人设置
        Route::get('person/index', 'PersonController@index')->name('admin.person.index');
        Route::post('person/reset', 'PersonController@reset')->name('admin.person.reset');
        Route::post('person/update', 'PersonController@update')->name('admin.person.update');
        // 系统配置
        Route::get('site/index', 'SiteController@index')->name('admin.site.index');
        Route::post('site/set', 'SiteController@set')->name('admin.site.set');
        // 栏目管理
        Route::resource('category', 'CategoryController');
        // 用户管理
        Route::get('user/index', 'UserController@index')->name('admin.user.index');
        // 标签管理
        Route::resource('tag', 'TagController');
        // 分类管理
        Route::resource('item', 'ItemController');
        // 文章管理
        Route::get('article/issue/{aid}', 'ArticleController@issue');
        Route::resource('article', 'ArticleController');
        // 链接管理
        Route::resource('link', 'LinkController');
        // 幻灯片管理
        Route::resource('slide', 'SlideController');
    });


});