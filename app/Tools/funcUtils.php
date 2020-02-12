<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/1/11
 * @Time: 13:25
 */

namespace App\Tools;

class funcUtils
{
    /**
     * 判断是否在几天前的时间戳范围内
     * @param int $time 时间戳
     * @param int $day 天数
     * @return bool
     */
    public function isSomeday($time, $day = 0) {
        $t = time();
        $last_start_time = mktime(0,0,0,date("m",$t),date("d",$t) - $day,date("Y",$t));
        $last_end_time = mktime(23,59,59,date("m",$t),date("d",$t) - $day,date("Y",$t));
        if ($last_start_time < $time && $time < $last_end_time) {
            return true;
        }
        return false;
    }
}