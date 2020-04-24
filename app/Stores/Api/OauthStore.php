<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/4/16
 * @Time: 14:39
 */

namespace App\Stores\Api;


use App\Stores\BaseStore;
use Illuminate\Support\Facades\DB;

class OauthStore extends BaseStore
{
    /**
     * OauthStore constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $app_id
     * @param $openid
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getSmallAppSessionByOpenid($app_id,$openid)
    {
        return DB::connection($this->CONN_DB)->table($this->APP_SMALLAPP_SESSION)
            ->where(['openid' => $openid, 'app_id' => $app_id])
            ->first();
    }

    /**
     * @param $uid
     * @return \Illuminate\Database\Query\Builder|mixed
     */
    public function getUser($uid)
    {
        return DB::connection($this->CONN_DB)->table($this->USER_TB)->find($uid);
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getOauthUser($where=[])
    {
        return DB::connection($this->CONN_DB)->table($this->OAUTH_USER)
            ->where($where)
            ->first();
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     */
    public function refreshOauth($id,$data)
    {
        try {
            DB::connection($this->CONN_DB)->table($this->OAUTH_USER)
                ->where(['id' => $id])
                ->update($data);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * @param $session_id
     * @param $data
     * @return bool
     */
    public function updateToken($session_id,$data)
    {
        try {
            DB::connection($this->CONN_DB)->table($this->APP_SMALLAPP_SESSION)
                ->where(['session_id' => $session_id])
                ->update($data);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * @param $data
     * @return int
     */
    public function addToken($data)
    {
        $id = 0;
        try {
            $id = DB::connection($this->CONN_DB)->table($this->APP_SMALLAPP_SESSION)
                ->insertGetId($data);
        } catch (\Exception $exception) {
            return $id;
        }
        return $id;
    }

    /**
     * @param $app_id
     * @param $token
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getSmallAppSessionByToken($app_id,$token)
    {
        return DB::connection($this->CONN_DB)->table($this->APP_SMALLAPP_SESSION)
            ->where(['token' => $token, 'app_id' => $app_id])
            ->first();
    }

    /**
     * @param $session_id
     * @return bool
     */
    public function deleteToken($session_id)
    {
        try {
            DB::connection($this->CONN_DB)->table($this->APP_SMALLAPP_SESSION)
                ->delete($session_id);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * @param $data
     * @return int
     */
    public function addUser($data)
    {
        try {
            return DB::connection($this->CONN_DB)->table($this->USER_TB)
                ->insertGetId($data);
        } catch (\Exception $exception) {
            return 0;
        }
    }

    /**
     * @param $username
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getUserByName($username)
    {
        return DB::connection($this->CONN_DB)->table($this->USER_TB)
            ->where(['username' => $username])
            ->first();
    }

    /**
     * @param $data
     * @return int
     */
    public function addOauthUser($data)
    {
        try {
            return DB::connection($this->CONN_DB)->table($this->OAUTH_USER)
                ->insertGetId($data);
        } catch (\Exception $exception) {
            return 0;
        }
    }

    /**
     * @param $uid
     * @return bool
     */
    public function deleteUser($uid)
    {
        try {
            DB::connection($this->CONN_DB)->table($this->USER_TB)
                ->delete($uid);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }
}