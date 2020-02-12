<?php

namespace App\Http\Middleware;

use App\Exceptions\PermissionException;
use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class Permission
{
    protected $CONN_DB, $ROLE_USER_TB, $AUTH_ACCESS_TB;

    public function __construct()
    {
        $this->CONN_DB = 'mysql_laradmin';
        $this->ROLE_USER_TB = 'role_user';
        $this->AUTH_ACCESS_TB = 'auth_access';
    }

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws PermissionException
     */
    public function handle($request, Closure $next)
    {
        $role_ids = $this->getRoleIds($this->getAdminId());
        if (empty($role_ids)) {
            // 没有任何权限角色
            throw new PermissionException(PermissionException::NOT_RULE);
        }
        if (in_array(1, $role_ids)) { // 超级管理员，拥有所有权限
            return $next($request);
        }
        // 当前角色所有权限路由
        $permission = $this->getPermission($role_ids);
        // 当前操作路由规则
        $rule = $request->route()->getActionName();
        $rule = $this->dealRule($rule);
        if (!in_array($rule, $permission)) {
            throw new PermissionException(PermissionException::NOT_RULE);
        }
        return $next($request);
    }

    /**
     * 获取当前用户id
     * @return mixed
     */
    protected function getAdminId()
    {
        return auth('admin')->id();
    }

    /**
     * 所属所有角色ID
     * @param $admin_id
     * @return array
     */
     protected function getRoleIds($admin_id)
     {
         return DB::connection($this->CONN_DB)->table($this->ROLE_USER_TB)
             ->where(['user_id' => $admin_id, 'type' => 'admin'])
             ->distinct()
             ->pluck('role_id')
             ->toArray();
     }

    /**
     * @param $roleIds
     * @return array
     */
     protected function getPermission($roleIds)
     {
         $role_names = DB::connection($this->CONN_DB)->table($this->AUTH_ACCESS_TB)
             ->whereIn('role_id', $roleIds)
             ->pluck('rule_name')
             ->toArray();
         foreach ($role_names as $key => $role_name) {
             if (strpos($role_name, '@') === false) {
                 unset($role_names[$key]);
             }
         }
         $result = [];
         foreach ($role_names as $role_name) {
             $arr = explode('/', $role_name);
             $result[] = Arr::last($arr);
         }
         return $result;
     }

    /**
     * 处理路由
     * @param $rule
     * @return mixed
     */
    public function dealRule($rule)
    {
        $arr = explode('\\', $rule);
        return Arr::last($arr);
    }
}
