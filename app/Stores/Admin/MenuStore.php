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
use App\Tools\MenuUtils;
use App\Tools\TreeUtils;
use Illuminate\Support\Facades\DB;

class MenuStore extends BaseStore
{
    protected $objUtilsMenu;

    public function __construct()
    {
        parent::__construct();

        $this->objUtilsMenu = new MenuUtils();
    }


    /**
     * 后台管理树形菜单
     * @return string
     */
    public function getAllMenus()
    {
        // 获取所有需要显示的菜单
        $result = Menu::orderBy('sort', 'asc')
            ->get()
            ->toArray();
        $tree = new TreeUtils();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $newmenus=array();
        foreach ($result as $m){
            $newmenus[$m['id']]=$m;
        }

        foreach ($result as $n=> $r) {
            $result[$n]['menuid'] = $r['id'];
            $result[$n]['level'] = $this->objUtilsMenu->_get_level($r['id'], $newmenus);
            $result[$n]['parentid_node'] = ($r['parentId']) ? ' class="child-of-node-' . $r['parentId'] . '"' : '';
            $result[$n]['type'] = '菜单';
            if ($r['status'] == 0) {
                $result[$n]['status'] = '不显示';
            } else {
                $result[$n]['status'] = '显示';
            }
            if ($r['type'] == 1) {
                $result[$n]['type'] = '权限认证+菜单';
            } else {
                $result[$n]['type'] = '菜单';
            }
            $result[$n]['str_manage'] = '<a href="' . route("menu.create", array("parentid" => $r['id'], "menuid" => $r['id'])) . '">添加子菜单</a> | <a href="' . route("menu.edit", array("menuid" => $r['id'])) . '">编辑</a> | <a class="js-ajax-delete" href="' . route("admin.menu.delete", array("menuid" => $r['id']) ). '">删除</a> ';
        }
        $tree->init($result);
        $str = "<tr id='node-\$menuid' \$parentid_node>
					<td style='padding-left:20px;'><input name='sorts[\$menuid]' type='text' size='1' value='\$sort' class='input input-order'></td>
					<td>\$menuid</td>
                    <td>\$spacer\$name</td>
                    <td>\$url</td>
                    <td>\$type</td>
                    <td>\$status</td>
                    <td>\$remark</td>
                    <td>\$str_manage</td>
				</tr>";
        $menus = $tree->get_tree('0', $str);

        return $menus;
    }

    /**
     * select框menu
     * @param $parentId
     * @return string
     */
    public function selectMenus($parentId=0)
    {
        $tree = new TreeUtils();
        $parentId = intval($parentId);
        $result = Menu::orderBy('sort', 'asc')
            ->get()
            ->toArray();
        foreach ($result as $r) {
            $r['selected'] = $r['id'] == $parentId ? 'selected' : '';
            $array[] = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        foreach ($array as $k => $v) {
            $v['menuid'] = $v['id'];
            $array[$k] = $v;
        }
        $tree->init($array);
        $select_categorys = $tree->get_tree(0, $str);

        return $select_categorys;
    }

    /**
     * 删除菜单
     * @param $menuId
     * @return int
     */
    public function deleteMenu($menuId)
    {
        return DB::connection($this->CONN_DB)->table($this->MENU_TB)
            ->where(['id' => $menuId])
            ->orWhere(['parentId' => $menuId])
            ->delete();
    }

    /**
     * 同步菜单
     * @param $data
     * @return array
     */
    public function synchro($data)
    {
        $errorMenus = [];
        // 清空数据包
        DB::connection($this->CONN_DB)->table($this->MENU_TB)->truncate();
        // 同步配置文件菜单信息
        $this->_import_menu($data, 0,$errorMenus);

        return $errorMenus;
    }

    /**
     * 导入配置文件的菜单
     * @param $menus
     * @param int $parentId
     * @param array $errorMenus
     */
    private function _import_menu($menus,$parentId=0,&$errorMenus=array())
    {
        $parentId2 = false;
        foreach ($menus as $menu){
            $children = isset($menu['children']) ? $menu['children'] : false;
            unset($menu['children']);
            $menu['parentId'] = $parentId;
            $menuId = DB::connection($this->CONN_DB)->table($this->MENU_TB)
                ->insertGetId($menu);
            if ($menuId) {
                $parentId2 = $menuId;
            } else {
                $errorMenus[] = $menu['permission'];
            }
            if ($children && $parentId2 !== false){
                $this->_import_menu($children,$parentId2);
            }
        }
    }

    /**
     * 递归遍历生成菜单
     * @param $menus
     * @param int $parentId
     * @param array $errorMenus
     */
    private function _update_menu($menus,$parentId=0,&$errorMenus=array()){
        $parentId2 = false;
        foreach ($menus as $menu){
            $where = array("permission"=>$menu['permission']);
            $children = isset($menu['children']) ? $menu['children'] : false;
            unset($menu['children']);
            $find_menu = DB::connection($this->CONN_DB)->table($this->MENU_TB)
                ->where($where)
                ->first();
            if ($find_menu) {
                $menu['parentId'] = $parentId;
                $result = DB::connection($this->CONN_DB)->table($this->MENU_TB)
                    ->where($where)
                    ->update($menu);
                if ($result === false) {
                    $errorMenus[] = $menu['permission'];
                } else {
                    $parentId2 =$find_menu->id;
                }
            } else {
                $menu['parentId'] = $parentId;
                $menuId = DB::connection($this->CONN_DB)->table($this->MENU_TB)
                    ->insertGetId($menu);
                if ($menuId) {
                    $parentId2 = $menuId;
                } else {
                    $errorMenus[] = $menu['permission'];
                }
            }
            if ($children && $parentId2 !== false){
                $this->_import_menu($children,$parentId2);
            }
        }
    }

    /**
     * @param $data
     * @return bool
     */
    public function storeMenu($data)
    {
        return DB::connection($this->CONN_DB)->table($this->MENU_TB)->insert($data);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Query\Builder|mixed
     */
    public function getMenuInfo($id)
    {
        return DB::connection($this->CONN_DB)->table($this->MENU_TB)->find($id);
    }

    /**
     * @param $id
     * @param $data
     * @return int
     */
    public function updateMenu($id, $data)
    {
        return DB::connection($this->CONN_DB)->table($this->MENU_TB)->where(['id' => $id])->update($data);
    }
}