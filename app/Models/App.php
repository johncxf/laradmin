<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql_laradmin';

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'app';

    protected $primaryKey = 'app_id';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['name', 'type', 'introduce', 'small_app_id', 'small_app_secret', 'url', 'status'];
}
