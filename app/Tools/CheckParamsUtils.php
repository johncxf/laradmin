<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2019/12/16
 * @Time: 21:24
 */

namespace App\Tools;


class CheckParamsUtils
{
    /**
     * 是否是int
     * @param $param
     * @return bool
     */
    public function isInteger($param)
    {
        if (!isset($param) && !is_int($param)) {
            return false;
        }
        return true;
    }
}