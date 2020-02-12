<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2019/12/20
 * @Time: 21:37
 */

namespace App\Tools;

class UserUtils
{
    /**
     *  获取用户登录信息
     * @param string $guard
     * @return int|string|null
     */
    public function getUserId($guard='')
    {
        if ($guard) {
            return auth($guard)->id();
        }
        return auth()->id();
    }

}