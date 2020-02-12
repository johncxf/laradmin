<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2019/12/21
 * @Time: 19:38
 */

namespace App\Stores\Admin;

use App\Models\Admin;
use App\Stores\BaseStore;
use Illuminate\Support\Facades\Storage;

class PersonStore extends BaseStore
{
    /**
     * PersonStore constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取管理员信息
     * @param $adminId
     * @return mixed
     */
    public function getAdminInfo($adminId)
    {
        return Admin::where('id', $adminId)->first();
    }

    /**
     * 修改密码
     * @param $password
     * @param $admin_id
     * @return mixed
     */
    public function resetPassword($password, $admin_id)
    {
        return Admin::where('id', $admin_id)->update(['password' => $password]);
    }

    /**
     * 更新用户信息
     * @param $data
     * @param $admin_id
     * @return bool
     */
    public function updateAdminInfo($data, $admin_id)
    {
        if (empty($data)) {
            return false;
        }
        $oldAvatar = '';
        if ($data['avatar']) {
            $admin = Admin::find($admin_id);
            $oldAvatar = substr($admin->avatar,8);
        }
        $res = Admin::where('id', $admin_id)->update($data);
        if (!$res) {
            return false;
        }
        if ($oldAvatar) {
            Storage::disk('public')->delete($oldAvatar);
        }
        return true;
    }
}