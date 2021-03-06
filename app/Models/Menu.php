<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    // 数据库连接
    protected $connection = 'mysql_laradmin';
    // 数据表
    protected $table = 'menu';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
//    protected $fillable = ['parentId'];
}
