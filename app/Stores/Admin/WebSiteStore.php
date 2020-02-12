<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2019/12/8
 * @Time: 10:17
 */

namespace App\Stores\Admin;

use App\Models\Admin;
use App\Models\Menu;
use App\Stores\BaseStore;
use App\Tools\MenuUtils;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class WebSiteStore extends BaseStore
{
    protected $objUtilsMenu, $objUtilsPermission;

    public function __construct()
    {
        parent::__construct();
        $this->objUtilsMenu = new MenuUtils();
        $this->objUtilsPermission = new PermissionStore();
    }
    /**
     * 获取菜单
     * @return array
     */
    public function getMenus()
    {
        // 获取用户ID
        $admin_id = auth('admin')->id();
        // 获取用户所属角色信息
        $role_ids = $this->objUtilsPermission->getRoleIds($admin_id, 'admin');
        // 获取所有需要显示的菜单
        if (in_array(config('website.webMasterRoleIds'), $role_ids)) {// 超级管理员，拥有所有权限
            $menus_all = Menu::where(['status' => 1])
                ->orderBy('sort')
                ->get()
                ->toArray();
        } else { // 权限菜单
            $permissionMenus = $this->objUtilsPermission->getPermissionMenus($role_ids);
            $menus_all = [];
            foreach ($permissionMenus as $menu) {
                $menus_all[] = [
                    'id' => $menu->id,
                    'parentId' => $menu->parentId,
                    'name' => $menu->name,
                    'url' => $menu->url,
                    'icon' => $menu->icon,
                    'sort' => $menu->sort
                ];
            }
        }
        // 生成菜单
        $menus = $this->objUtilsMenu->generateTree($menus_all);

        return $menus;
    }

    /**
     * HeaderPage
     * @return array
     */
    public function getHeaderPage()
    {
        // 获取当前路由名称
        $rule = Route::currentRouteAction();
        $rule_arr = explode('\\', $rule);
        $action = Arr::last($rule_arr);
        if ($action == 'IndexController@index') {
            return ['title' => '控制台', 'link' => ['控制台'], 'home' => false];
        }
        $menu = DB::connection($this->CONN_DB)->table($this->MENU_TB)
            ->where('permission', 'like', '%/'.$action.'%')
            ->first();
        $link = [];
        $home = true;
        if ($menu) {
            $title = $menu->name;
            if ($menu->parentId != 0) {
                $this->_get_parent_menus($menu->parentId, $link);
                $link = array_reverse($link);
                array_push($link, $title);
                unset($link[0]);
            } else {
                $home = false;
            }
        } else {
            $title = '首页';
        }

        return ['title' => $title, 'link' => $link, 'home' => $home];
    }

    /**
     * 获取所有父级菜单
     * @param $parentId
     * @param array $link
     */
    protected function _get_parent_menus($parentId, &$link=[])
    {
        $menu = DB::connection($this->CONN_DB)->table($this->MENU_TB)
            ->where(['id' => $parentId])
            ->first();
        if ($menu->name) {
            $link[] = $menu->name;
        }
        if ($menu->parentId != 0) {
            $this->_get_parent_menus($menu->parentId, $link);
        }
    }

}