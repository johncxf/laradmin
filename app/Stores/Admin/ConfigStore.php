<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/1/3
 * @Time: 20:02
 */

namespace App\Stores\Admin;


use App\Stores\BaseStore;
use Illuminate\Support\Facades\DB;

class ConfigStore extends BaseStore
{
    /**
     * ConfigStore constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取config表数据
     * @param $name
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getConfigByName($name)
    {
        return DB::connection($this->CONN_DB)->table($this->CONFIG_TB)
            ->where(['name' => $name])
            ->first();
    }

    /**
     * 更新config表
     * @param $name
     * @param $value
     * @return int
     */
    public function updateConfigByName($name, $value)
    {
        return DB::connection($this->CONN_DB)->table($this->CONFIG_TB)
            ->where(['name' => $name])
            ->update(['value' => $value]);
    }
}