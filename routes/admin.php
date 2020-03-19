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
        Route::resource('menu', 'MenuController', ['except' => ['show']]);
        Route::get('menu/delete/{menu}', 'MenuController@delete')->name('admin.menu.delete');
        // 前台菜单管理
        Route::get('index_menu/synchro', 'IndexMenuController@synchro')->name('index_menu.synchro');
        Route::resource('index_menu', 'IndexMenuController', ['except' => ['show']]);
        Route::get('index_menu/delete/{menu}', 'IndexMenuController@delete')->name('index_menu.delete');
        // 角色
        Route::resource('role', 'RoleController', ['except' => ['show']]);
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
        Route::resource('category', 'CategoryController', ['except' => ['show']]);
        // 用户管理
        Route::get('user/index', 'UserController@index')->name('admin.user.index');
        Route::get('user/change_status/{uid}', 'UserController@changeStatus');
        // 标签管理
        Route::resource('tag', 'TagController', ['except' => ['show']]);
        // 分类管理
        Route::resource('item', 'ItemController', ['except' => ['show']]);
        // 文章管理
        Route::get('article/issue/{aid}', 'ArticleController@issue');
        Route::resource('article', 'ArticleController', ['except' => ['show']]);
        // 链接管理
        Route::resource('link', 'LinkController', ['except' => ['show']]);
        // 幻灯片管理
        Route::resource('slide', 'SlideController', ['except' => ['show']]);
    });


});