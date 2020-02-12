<?php

namespace App\Models;

use App\Tools\ArrUtils;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
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
    protected $table = 'item';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['name', 'remark','pid','type'];

    /**
     * 获取栏目数据，tree类型返回
     * @param null $item
     * @param string $type
     * @return array
     */
    public function getAll($item = null,$type=null)
    {
        $Arr = new ArrUtils();
        if ($type) {
            $data = $this->where('type',$type)->get()->toArray();
        } else {
            $data = $this->get()->toArray();
        }
        if (!is_null($item)) {
            foreach ($data as $k => $d) {
                $data[$k]['_selected'] = $item['pid'] == $d['id'];
                $data[$k]['_disabled'] = $item['id'] == $d['id'] || $Arr->isChild($data, $d['id'], $item['id'], 'id');
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
