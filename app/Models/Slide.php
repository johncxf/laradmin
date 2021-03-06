<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
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
    protected $table = 'slide';

    /**
     * @var bool
     */
    public $timestamps = false;

    public function getAll($type=null)
    {
        if ($type !== null) {
            return $this->where('type',$type)->orderBy('sort','asc')->get()->toArray();
        }
        return $this->orderBy('sort','asc')->get()->toArray();
    }
}
