<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/2/3
 * @Time: 20:20
 */

namespace App\Stores\Home;


use App\Stores\BaseStore;
use Illuminate\Support\Facades\DB;

class ArticleStore extends BaseStore
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $aid
     * @param $uid
     * @return bool|\Illuminate\Database\Query\Builder|mixed
     */
    public function getArticleById($aid,$uid)
    {
        if (empty($aid)) {
            return false;
        }
        $article = DB::connection($this->CONN_DB)->table($this->ARTICLE_TB)
            ->find($aid);
        $is_praise = 0;
        $is_star = 0;
        if ($this->is_praise($aid,$uid)) {
            $is_praise = 1;
        }
        if ($this->is_star($aid,$uid)) {
            $is_star = 1;
        }
        $article->is_praise = $is_praise;
        $article->is_star = $is_star;
        $article->praise = $this->getPraiseCounts($article->id);
        $article->star = $this->getStarCounts($article->id);
        $article->comments = $this->getCommentCounts($article->id);
        return $article;
    }

    /**
     * @param $cid
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getArticleByCid($cid,$limit=10)
    {
        return DB::connection($this->CONN_DB)->table($this->ARTICLE_TB)
            ->where(['status' => 2,'cid' => $cid])
            ->orderBy('create_at', 'desc')
            ->paginate($limit);
    }

    /**
     * @param $aid
     * @param int $uid
     * @return bool
     */
    public function readLog($aid,$uid=0)
    {
        if (empty($aid)) {
            return false;
        }
        DB::connection($this->CONN_DB)->table($this->ARTICLE_TB)
            ->where(['id' => $aid])
            ->increment('pv');
        return true;
    }

    /**
     * @param $aid
     * @return array|bool
     */
    public function getComment($aid)
    {
        if (!$aid) {
            return false;
        }
        $comments = DB::connection($this->CONN_DB)->table($this->ARTICLE_COMMENT_TB)
            ->where('status',1)
            ->where('article_id',$aid)
            ->orderBy('create_at', 'asc')
            ->orderBy('id','desc')
            ->get()
            ->toArray();
        $users = $this->getValueKeyFromUser('id','nickname');
        $avatars = $this->getValueKeyFromUser('id','avatar');
        $new_comments = [];
        foreach ($comments as $key => $comment) {
            $new_comments[$comment->id] = (array)$comment;
        }
        foreach ($new_comments as $key => $comment) {
            $new_comments[$key]['cname'] = $users[$comment['uid']];
            $new_comments[$key]['cavatar'] = $avatars[$comment['uid']];
            if ($comment['target_id']) {
                $new_comments[$key]['tname'] = $users[$comment['target_id']];
            }
            if ($comment['pid'] == 0) {
                $new_comments[$key]['_pid'] = 0;
            } else {
                $new_comments[$key]['_pid'] = $this->get_first_pid($comment['id'],$new_comments);
            }
        }
        $comments = $this->del_comment($new_comments);
        return $comments;
    }

    /**
     * 评论操作数据库
     * @param $data
     * @return bool
     */
    public function reply($data)
    {
        return DB::connection($this->CONN_DB)->table($this->ARTICLE_COMMENT_TB)->insert($data);
    }

    /**
     * 点赞
     * @param $aid
     * @param $uid
     * @return bool
     */
    public function praise($aid,$uid)
    {
        $data = [
            'uid' => $uid,
            'article_id' => $aid,
            'create_at' => date('Y-m-d H:i:s',time())
        ];
        try {
            DB::connection($this->CONN_DB)->table($this->ARTICLE_PRAISE_TB)->insert($data);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * 取消点赞
     * @param $aid
     * @param $uid
     * @return bool
     */
    public function unPraise($aid,$uid)
    {
        try {
            DB::connection($this->CONN_DB)->table($this->ARTICLE_PRAISE_TB)
                ->where(['uid' => $uid,'article_id' => $aid])
                ->delete();
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * 收藏
     * @param $aid
     * @param $uid
     * @return bool
     */
    public function like($aid,$uid)
    {
        $data = [
            'uid' => $uid,
            'article_id' => $aid,
            'create_at' => date('Y-m-d H:i:s',time())
        ];
        try {
            DB::connection($this->CONN_DB)->table($this->ARTICLE_STAR_TB)->insert($data);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * 取消收藏
     * @param $aid
     * @param $uid
     * @return bool
     */
    public function unlike($aid,$uid)
    {
        try {
            DB::connection($this->CONN_DB)->table($this->ARTICLE_STAR_TB)
                ->where(['uid' => $uid,'article_id' => $aid])
                ->delete();
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * 处理留言
     * @param $list
     * @param string $pk
     * @param string $pid
     * @param string $child
     * @param int $root
     * @return array
     */
    private function del_comment($list,$pk = 'id', $pid = '_pid', $child = '_child', $root = 0)
    {
        $tree     = array();
        $packData = array();
        foreach ($list as $data) {
            $packData[$data[$pk]] = $data;
        }
        foreach ($packData as $key => $val) {
            if ($val[$pid] == $root) {
                $tree[] = &$packData[$key];
            } else {
                $packData[$val[$pid]][$child][] = &$packData[$key];
            }
        }
        return $tree;
    }

    /**
     * 获取顶级pid
     * @param $id
     * @param array $array
     * @return mixed
     */
    private function get_first_pid($id, $array = array()) {
        if ($array[$id]['pid']==0 || empty($array[$array[$id]['pid']]) || $array[$id]['pid']==$id){
            return  $id;
        } else {
            return $this->get_first_pid($array[$id]['pid'],$array);
        }

    }

    /**
     * @param $key
     * @param $value
     * @return array
     */
    private function getValueKeyFromUser($key,$value)
    {
        // 获取所有用户数据
        $all_users = DB::connection($this->CONN_DB)->table($this->USER_TB)
            ->where(['user_status' => 1])
            ->select([$key,$value])
            ->get()
            ->toArray();
        $users = [];
        foreach ($all_users as $user){
            $users[$user->$key] = $user->$value;
        }
        return $users;
    }

    /**
     * 是否点赞
     * @param $aid
     * @param $uid
     * @return bool
     */
    public function is_praise($aid,$uid)
    {
        if (DB::connection($this->CONN_DB)->table($this->ARTICLE_PRAISE_TB)
            ->where(['uid' => $uid, 'article_id' => $aid])->first()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 是否收藏
     * @param $aid
     * @param $uid
     * @return bool
     */
    public function is_star($aid,$uid)
    {
        if (DB::connection($this->CONN_DB)->table($this->ARTICLE_STAR_TB)
            ->where(['uid' => $uid, 'article_id' => $aid])->first()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取收藏数
     * @param $aid
     * @return int
     */
    private function getStarCounts($aid)
    {
        return DB::connection($this->CONN_DB)->table($this->ARTICLE_STAR_TB)
            ->where('article_id',$aid)
            ->count();
    }

    /**
     * 获取点赞数
     * @param $aid
     * @return int
     */
    private function getPraiseCounts($aid)
    {
        return DB::connection($this->CONN_DB)->table($this->ARTICLE_PRAISE_TB)
            ->where('article_id',$aid)
            ->count();
    }

    /**
     * 获取评论数
     * @param $aid
     * @return int
     */
    private function getCommentCounts($aid)
    {
        return DB::connection($this->CONN_DB)->table($this->ARTICLE_COMMENT_TB)
            ->where('article_id',$aid)
            ->count();
    }
}