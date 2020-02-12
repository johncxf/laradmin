<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2019/12/5
 * @Time: 9:56
 */

namespace App\Stores\Admin;

use App\Models\Menu;
use App\Stores\BaseStore;
use App\Tools\TreeUtils;
use Illuminate\Support\Facades\DB;

class RoleStore extends BaseStore
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 查询所有角色
     * @return array|bool
     */
    public function getAllRole($orderRow='listorder', $orderWhere='asc')
    {
        $roles = DB::connection($this->CONN_DB)->table($this->ROLE_TB)
            ->orderBy($orderRow, $orderWhere)
            ->get()
            ->toArray();
        if (empty($roles)) {
            return false;
        }
        return $roles;
    }

    /**
     * 获取权限菜单
     * @param $role_id
     * @return bool|string
     */
    public function getPermissionMenus($role_id)
    {
        //角色ID
        if (!$role_id) {
            return false;
        }
        $menu = new TreeUtils();
        $menu->icon = array('│ ', '├─ ', '└─ ');
        $menu->nbsp = '&nbsp;&nbsp;&nbsp;';
        $result = $this->getMenus();
        $newmenus = array();
        $priv_data = DB::connection($this->CONN_DB)->table($this->AUTH_ACCESS_TB)
            ->where(['role_id' => $role_id])
            ->pluck('rule_name')
            ->toArray();
        foreach ($result as $m){
            $newmenus[$m['id']] = $m;
        }
        foreach ($result as $n => $t) {
            $permission = $t['permission'];
            $result[$n]['menuid'] = $t['id'];
            $result[$n]['checked'] = ($this->_is_checked($permission, $priv_data)) ? ' checked' : '';
            $result[$n]['level'] = $this->_get_level($t['id'], $newmenus);
            $result[$n]['parentid_node'] = ($t['parentId']) ? ' class="child-of-node-' . $t['parentId'] . '"' : '';
        }

        $str = "<tr id='node-\$id' \$parentid_node>
                       <td style='padding-left:30px;'>\$spacer<input class='' type='checkbox' name='menuid[]' value='\$id' level='\$level' \$checked onclick='javascript:checknode(this);'> \$name</td>
	    			</tr>";
        $menu->init($result);
        $categorys = $menu->get_tree(0, $str);

        return $categorys;
    }

    /**
     * 添加角色
     * @param $data
     * @return bool
     */
    public function addRole($data)
    {
        return DB::connection($this->CONN_DB)->table($this->ROLE_TB)
            ->insert($data);
    }

    /**
     * 清除权限规则
     * @param $role_id
     * @return int
     */
    public function deleteAuth($role_id)
    {
        return DB::connection($this->CONN_DB)->table($this->ACCESS_TB)
            ->where(['role_id' => $role_id])->delete();
    }

    /**
     * 获取单个菜单信息
     * @param $menu_id
     * @return mixed
     */
    public function getMenu($menu_id)
    {
        return Menu::find($menu_id);
    }

    /**
     * 插入权限
     * @param $data
     * @return bool
     */
    public function addAccess($data)
    {
        return DB::connection($this->CONN_DB)->table($this->ACCESS_TB)->insert($data);
    }

    /**
     * 获取所有权限菜单
     * @return mixed
     */
    protected function getMenus()
    {
        $result = Menu::where('type', 1)
            ->orderBy('sort', 'asc')
            ->get()
            ->toArray();
        return $result;
    }

    /**
     * 删除角色
     * @param $role_id
     * @return int
     */
    public function deleteRole($role_id)
    {
        $delete_role = DB::connection($this->CONN_DB)->table($this->ROLE_TB)
            ->where(['id' => $role_id])
            ->delete();
        if (!$delete_role) {
            return false;
        }
        DB::connection($this->CONN_DB)->table($this->ACCESS_TB)
            ->where(['role_id' => $role_id])
            ->delete();
        return true;
    }

    /**
     * 检查指定菜单是否有权限
     * @param $permission
     * @param $priv_data
     * @return bool
     */
    private function _is_checked($permission, $priv_data) {
        if($priv_data){
            if (in_array($permission, $priv_data)) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }

    }

    /**
     * 获取菜单深度
     * @param $id
     * @param $array
     * @param $i
     * @return
     */
    protected function _get_level($id, $array = array(), $i = 0) {

        if ($array[$id]['parentId']==0 || empty($array[$array[$id]['parentId']]) || $array[$id]['parentId']==$id){
            return  $i;
        }else{
            $i++;
            return $this->_get_level($array[$id]['parentId'],$array,$i);
        }

    }
}