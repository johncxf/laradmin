<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2019/12/21
 * @Time: 11:10
 */

namespace App\Stores\Admin;


use App\Stores\BaseStore;
use Illuminate\Support\Facades\DB;

class PermissionStore extends BaseStore
{
    /**
     * UserUtils constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 所属所有角色ID
     * @param $userId
     * @param string $type
     * @return array
     */
    public function getRoleIds($userId, $type='admin')
    {
        return DB::connection($this->CONN_DB)->table($this->ROLE_USER_TB)
            ->where(['user_id' => $userId, 'type' => $type])
            ->distinct()
            ->pluck('role_id')
            ->toArray();
    }

    /**
     * 获取所有权限菜单
     * @param $roleIds
     * @return array
     */
    public function getPermissionMenus($roleIds)
    {
        $permission = $this->getPermission($roleIds);
        return DB::connection($this->CONN_DB)->table($this->MENU_TB)
            ->whereIn('permission', $permission)
            ->where(['status' => 1])
            ->orderBy('sort')
            ->get()
            ->toArray();
    }

    /**
     * 获取所有权限规则
     * @param $roleIds
     * @return array
     */
    protected function getPermission($roleIds)
    {
        $role_names = DB::connection($this->CONN_DB)->table($this->AUTH_ACCESS_TB)
            ->whereIn('role_id', $roleIds)
            ->pluck('rule_name')
            ->toArray();
        return $role_names;
    }

}