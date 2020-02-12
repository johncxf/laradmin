<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/2/8
 * @Time: 12:33
 */

namespace App\Stores\Home;


use App\Stores\BaseStore;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Translation\Tests\Writer\BackupDumper;

class ProfileStore extends BaseStore
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 更新用户表
     * @param $data
     * @param $uid
     * @return bool|int
     */
    public function updateUser($data,$uid)
    {
        if (empty($uid)) {
            return false;
        }
        try {
            DB::connection($this->CONN_DB)->table($this->USER_TB)
                ->where('id',$uid)
                ->update($data);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * @param $data
     * @return bool
     */
    public function checkCaptcha($data)
    {
        $create_at = DB::connection($this->CONN_DB)->table($this->VERIFY_TB)
            ->where(['uid' => $data['uid'],'contact' => $data['email'], 'type' => 'mail', 'token' => $data['captcha']])
            ->orderBy('create_at','desc')
            ->value('create_at');
        if ($create_at === null) {
            return false;
        }
        if (strtotime($create_at) + 60*60*24 < time()) {
            return false;
        }
        return true;
    }

    /**
     * @param $data
     * @return int
     */
    public function updateEmail($data)
    {
        return DB::connection($this->CONN_DB)->table($this->USER_TB)
            ->where(['id' => $data['uid']])
            ->update(['email' => $data['email']]);
    }

    /**
     * @param $uid
     * @return array
     */
    public function getStarArticle($uid)
    {
        $stars = DB::connection($this->CONN_DB)->table($this->ARTICLE_STAR_TB)
            ->where(['uid' => $uid])
            ->get()
            ->toArray();
        $articles = DB::connection($this->CONN_DB)->table($this->ARTICLE_TB)
            ->where('status',2)
            ->select(['id','title'])
            ->get()
            ->toArray();
        $new_articles = [];
        foreach ($articles as $key => $val) {
            $new_articles[$val->id] = $val->title;
        }
        foreach ($stars as $k => $star) {
            $stars[$k]->article_title = $new_articles[$star->article_id];
        }
        return $stars;
    }

    public function updateAvatar($uid,$img)
    {
        try {
            DB::connection($this->CONN_DB)->table($this->USER_TB)
                ->where('id',$uid)
                ->update(['avatar' => $img]);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    public function getOldAvatar($uid)
    {
        return DB::connection($this->CONN_DB)->table($this->USER_TB)
            ->where('id',$uid)
            ->value('avatar');
    }
}