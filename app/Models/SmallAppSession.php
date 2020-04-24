<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmallAppSession extends Model
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
    protected $table = 'app_smallapp_session';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['uid', 'openid', 'unionid', 'session_key', 'token', 'expire_at'];

}
