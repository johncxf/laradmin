<?php

namespace App\Models;

use App\Tools\ArrUtils;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
    protected $table = 'category';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['name', 'alias', 'icon', 'url', 'pid', 'status','sort'];

    /**
     * 获取栏目数据，tree类型返回
     * @param null $cate
     * @return array
     */
    public function getAll($cate = null)
    {
        $Arr = new ArrUtils();
        $data = $this->orderBy('sort','asc')->get()->toArray();
        if (!is_null($cate)) {
            foreach ($data as $k => $d) {
                $data[$k]['_selected'] = $cate['pid'] == $d['id'];
                $data[$k]['_disabled'] = $cate['id'] == $d['id'] || $Arr->isChild($data, $d['id'], $cate['id'], 'id');
            }
        }
        $data = $Arr->tree($data, 'name', 'id');
        return $data;
    }

    /**
     * 判断该栏目是否有子栏目
     * @return bool
     */
    public function hasChild()
    {
        $data = $this->get()->toArray();
        return (new ArrUtils())->hasChild($data, $this->id);
    }
}
