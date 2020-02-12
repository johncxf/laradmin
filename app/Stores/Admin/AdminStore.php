<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2019/12/5
 * @Time: 16:33
 */

namespace App\Stores\Admin;


use App\Models\Admin;
use App\Stores\BaseStore;
use Illuminate\Support\Facades\DB;

class AdminStore extends BaseStore
{
    /**
     * AdminStore constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 查询所有管理员信息
     * @param $limit
     * @return array
     */
    public function getAllAdmins($limit=10)
    {
        $admins = Admin::paginate($limit);
        foreach ($admins as $key => $admin) {
            $roles = DB::connection($this->CONN_DB)->table($this->ROLE_USER_TB)
                ->where(['type' => 'admin', 'user_id' => $admin['id']])
                ->pluck('role_id')
                ->toArray();
            $role_name = '';
            if (!empty($roles)) {
                foreach ($roles as $role_id) {
                    $name = DB::connection($this->CONN_DB)->table($this->ROLE_TB)->where(['id' => $role_id])->value('name');
                    if ($name) {
                        $role_name .= $name.';';
                    }
                }
                $role_name = rtrim($role_name, ';');
            }
            $admins[$key]['role'] = $role_name;
        }
        return $admins;
    }

    /**
     * 获取所有角色信息
     * @return array
     */
    public function getAllRoles()
    {
        return DB::connection($this->CONN_DB)->table($this->ROLE_TB)
            ->where(['status' => 1])
            ->select('id', 'name')
            ->get()
            ->toArray();
    }

    /**
     * 添加管理员
     * @param $data
     * @param array $roleIds
     * @return bool
     */
    public function addAdmin($data, $roleIds=[])
    {
        $userId = DB::connection($this->CONN_DB)->table($this->ADMIN_TB)->insertGetId($data);
        if (!$userId) {
            return false;
        }
        if (!empty($roleIds)) {
            foreach ($roleIds as $roleId) {
                DB::connection($this->CONN_DB)->table($this->ROLE_USER_TB)
                    ->insert(['role_id' => $roleId, 'user_id' => $userId, 'type' => 'admin']);
            }
        }
        return true;
    }

    /**
     * 获取管理员信息
     * @param $admin_id
     * @return array
     */
    public function getAdminInfo($admin_id)
    {
        return DB::connection($this->CONN_DB)->table($this->ADMIN_TB)
            ->find($admin_id);
    }

    /**
     * 获取管理员所属角色id
     * @param $admin_id
     * @return array
     */
    public function getMyRoleIds($admin_id)
    {
        return DB::connection($this->CONN_DB)->table($this->ROLE_USER_TB)
            ->where(['user_id' => $admin_id, 'type' => 'admin'])
            ->distinct()
            ->pluck('role_id')
            ->toArray();
    }

    /**
     * 更新管理员信息
     * @param $data
     * @param array $roleIds
     * @return bool
     */
    public function updateAdmin($data, $id=0, $roleIds=[])
    {
        $update_id = DB::connection($this->CONN_DB)->table($this->ADMIN_TB)
            ->where(['id' => $id])
            ->update($data);
        if (!$update_id) {
            return false;
        }
        if (!empty($roleIds)) {
            DB::connection($this->CONN_DB)->table($this->ROLE_USER_TB)
                ->where(['user_id' => $id, 'type' => 'admin'])
                ->delete();
            foreach ($roleIds as $roleId) {
                DB::connection($this->CONN_DB)->table($this->ROLE_USER_TB)
                    ->insert(['role_id' => $roleId, 'user_id' => $id, 'type' => 'admin']);
            }
        }
        return true;
    }

    /**
     * 删除管理员
     * @param $admin_id
     * @return bool
     */
    public function deleteAdmin($admin_id)
    {
        if (!isset($admin_id)) {
            return false;
        }
        DB::connection($this->CONN_DB)->table($this->ADMIN_TB)
            ->where(['id' => $admin_id])
            ->delete();
        DB::connection($this->CONN_DB)->table($this->ROLE_USER_TB)
            ->where(['user_id' => $admin_id, 'type' => 'admin'])
            ->delete();
        return true;
    }

    /**
     * 将admin状态改为0
     * @param $admin_id
     * @return int
     */
    public function forbidden($admin_id)
    {
        return DB::connection($this->CONN_DB)->table($this->ADMIN_TB)
            ->where(['id' => $admin_id])
            ->update(['status' => 0]);
    }

    /**
     * 将admin状态改为1
     * @param $admin_id
     * @return int
     */
    public function enable($admin_id)
    {
        return DB::connection($this->CONN_DB)->table($this->ADMIN_TB)
            ->where(['id' => $admin_id])
            ->update(['status' => 1]);
    }

}