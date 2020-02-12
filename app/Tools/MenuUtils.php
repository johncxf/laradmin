<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2019/12/21
 * @Time: 10:57
 */

namespace App\Tools;


class MenuUtils
{
    /**
     * 获取菜单深度
     * @param $id
     * @param array $array
     * @param int $i
     * @return int
     */
    public function _get_level($id, $array = array(), $i = 0) {
        if ($array[$id]['parentId']==0 || empty($array[$array[$id]['parentId']]) || $array[$id]['parentId']==$id){
            return  $i;
        } else {
            $i++;
            return $this->_get_level($array[$id]['parentId'],$array,$i);
        }

    }

    /**
     * 菜单无限极分类
     * @param $list
     * @param string $pk
     * @param string $pid
     * @param string $child
     * @param int $root
     * @return array
     */
    public function generateTree($list, $pk = 'id', $pid = 'parentId', $child = '_child', $root = 0)
    {
        $tree     = array();
        $packData = array();
        foreach ($list as $data) {
            $packData[$data[$pk]] = $data;
        }
        foreach ($packData as $key => $val) {
            if ($val[$pid] == $root) {
                $tree[] = &$packData[$key];
            } else {
                $packData[$val[$pid]][$child][] = &$packData[$key];
            }
        }
        return $tree;
    }
}