<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/1/28
 * @Time: 20:57
 */

namespace App\Stores\Admin;


use App\Models\Category;
use App\Models\Item;
use App\Models\Tag;
use App\Stores\BaseStore;
use App\Tools\TreeUtils;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ArticleStore extends BaseStore
{
    /**
     * ArticleStore constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取所有文章
     * @param array $where
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllArticles($where=array(), $limit=15)
    {
        $articles = DB::connection($this->CONN_DB)->table($this->ARTICLE_TB)
            ->where($where)
            ->paginate($limit);
        foreach ($articles as $article) {
            $article->create_user = DB::connection($this->CONN_DB)->table($this->ADMIN_TB)
                ->where(['id' => $article->uid])
                ->value('username');
            $article->cate = DB::connection($this->CONN_DB)->table('category')
                ->where(['id' => $article->cid])
                ->value('name');
        }
        return $articles;
    }

    /**
     * 查询所有分类
     * @return array
     */
    public function getAllItems()
    {
        return Item::whereIn('type',['common','article'])->get()->toArray();
    }

    /**
     * 生成树形结构分类
     * @param null $aid
     * @return string
     */
    public function getCheckItems($aid=null)
    {
        $item = new TreeUtils();
        $item->icon = array('│ ', '├─ ', '└─ ');
        $item->nbsp = '&nbsp;&nbsp;&nbsp;';
        $result = $this->getAllItems();
        $new_items = array();
        foreach ($result as $k => $m){
            $new_items[$m['id']] = $m;
        }
        $priv_data = [];
        if ($aid) {
            $priv_data = $this->articleItemIds($aid);
        }
        foreach ($result as $n => $t) {
            $result[$n]['parentId'] = $t['pid'];
            $result[$n]['menuid'] = $t['id'];
            $result[$n]['checked'] = ($this->_is_checked($t['id'], $priv_data)) ? ' checked' : '';
            $result[$n]['level'] = $this->_get_level($t['id'], $new_items);
            $result[$n]['parentid_node'] = ($t['pid']) ? ' class="child-of-node-' . $t['pid'] . '"' : '';
        }

        $str = "<tr id='node-\$id' \$parentid_node>
                       <td style='padding-left:30px;'>\$spacer<input class='' type='checkbox' name='item_id[]' value='\$id' level='\$level' \$checked onclick='javascript:checknode(this);'> \$name</td>
	    			</tr>";
        $item->init($result);
        $items = $item->get_tree(0, $str);
        return $items;
    }

    /**
     * 保存文章
     * @param $data_article
     * @param $item_ids
     * @param $tag_ids
     * @param null $aid
     * @return bool
     */
    public function createArticle($data_article, $item_ids, $tag_ids, $aid=null)
    {
        if ($aid !== null) {// 修改文章
            if (!DB::connection($this->CONN_DB)->table($this->ARTICLE_TB)->find($aid)) {
                return false;
            }
        }
        DB::connection($this->CONN_DB)->beginTransaction();
        try {
            if ($aid !== null) {
                // 清除记录
                DB::connection($this->CONN_DB)->table($this->ARTICLE_ITEM_TB)
                    ->where(['article_id' => $aid])->delete();
                DB::connection($this->CONN_DB)->table($this->ARTICLE_TAG_TB)
                    ->where(['article_id' => $aid])->delete();
                // 修改
                DB::connection($this->CONN_DB)->table($this->ARTICLE_TB)
                    ->where(['id' => $aid])
                    ->update($data_article);
            } else {// 新增
                $aid = DB::connection($this->CONN_DB)->table($this->ARTICLE_TB)
                    ->insertGetId($data_article);
            }
            if (!empty($item_ids)) {
                $article_item = [];
                foreach ($item_ids as $item_id) {
                    $article_item[] = [
                        'article_id' => $aid,
                        'item_id' => $item_id
                    ];
                }
                DB::connection($this->CONN_DB)->table($this->ARTICLE_ITEM_TB)->insert($article_item);
            }
            if (!empty($tag_ids)) {
                $article_tag = [];
                foreach ($tag_ids as $tag_id) {
                    $article_tag[] = [
                        'article_id' => $aid,
                        'tag_id' => $tag_id
                    ];
                }
                DB::connection($this->CONN_DB)->table($this->ARTICLE_TAG_TB)->insert($article_tag);
            }
            DB::connection($this->CONN_DB)->commit();
        } catch (\Exception $exception) {
            DB::connection($this->CONN_DB)->rollBack();
            return false;
        }
        return $aid;
    }

    /**
     * 获取所有标签
     * @return mixed
     */
    public function getAllTags()
    {
        return Tag::whereIn('type',['common','article'])->get()->toArray();
    }

    /**
     * 获取文章所属tagId
     * @param $aid
     * @return array
     */
    public function articleTagIds($aid)
    {
        $res = [];
        $tagIds = DB::connection($this->CONN_DB)->table($this->ARTICLE_TAG_TB)
            ->where(['article_id' => $aid])
            ->pluck('tag_id');
        foreach ($tagIds as $tagId) {
            $res[] = $tagId;
        }
        return $res;
    }

    /**
     * 获取文章所属ItemId
     * @param $aid
     * @return array
     */
    public function articleItemIds($aid)
    {
        $res = [];
        $itemIds = DB::connection($this->CONN_DB)->table($this->ARTICLE_ITEM_TB)
            ->where(['article_id' => $aid])
            ->pluck('item_id');
        foreach ($itemIds as $itemId) {
            $res[] = $itemId;
        }
        return $res;
    }

    /**
     * 删除文章
     * @param $aid
     * @return bool
     */
    public function deleteArticle($aid)
    {
        DB::connection($this->CONN_DB)->beginTransaction();//开启事务
        try {
            DB::connection($this->CONN_DB)->table($this->ARTICLE_TB)
                ->where(['id' => $aid])->delete();
            DB::connection($this->CONN_DB)->table($this->ARTICLE_ITEM_TB)
                ->where(['article_id' => $aid])->delete();
            DB::connection($this->CONN_DB)->table($this->ARTICLE_TAG_TB)
                ->where(['article_id' => $aid])->delete();
            DB::connection($this->CONN_DB)->commit();
        } catch (QueryException $e) {
            DB::connection($this->CONN_DB)->rollBack();
            return false;
        }
        return true;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCateById($id)
    {
        return Category::where('id', $id)->get()->toArray();
    }

    /**
     * 修改文章发布状态
     * @param $aid
     * @param $status
     * @return int
     */
    public function changeStatus($aid, $status)
    {
        return DB::connection($this->CONN_DB)->table($this->ARTICLE_TB)
            ->where(['id' => $aid])
            ->update(['status' => $status]);
    }

    /**
     * 查询文章
     * @param $aid
     * @return \Illuminate\Database\Query\Builder|mixed
     */
    public function getArticleById($aid) {
        return DB::connection($this->CONN_DB)->table($this->ARTICLE_TB)->find($aid);
    }

    /**
     * @param $aid
     * @return mixed
     */
    public function getArticleImg($aid)
    {
        return DB::connection($this->CONN_DB)->table($this->ARTICLE_TB)
            ->where('id',$aid)
            ->value('thumb');
    }

    /**
     * 是否选中
     * @param $element
     * @param $data
     * @return bool
     */
    private function _is_checked($element, $data) {
        if($data){
            if (in_array($element, $data)) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }

    }

    /**
     * 获取深度
     * @param $id
     * @param $array
     * @param $i
     * @return
     */
    protected function _get_level($id, $array = array(), $i = 0) {

        if ($array[$id]['pid']==0 || empty($array[$array[$id]['pid']]) || $array[$id]['pid']==$id){
            return  $i;
        }else{
            $i++;
            return $this->_get_level($array[$id]['pid'],$array,$i);
        }

    }
}