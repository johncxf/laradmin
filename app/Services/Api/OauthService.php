<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/4/18
 * @Time: 15:10
 */

namespace App\Services\Api;


use App\Stores\Api\OauthStore;
use App\Tools\SmallApp\WXBizDataCrypt;
use Illuminate\Support\Facades\Hash;

class OauthService extends BaseService
{
    protected $objStoreOauth;

    public function __construct($appInfo)
    {
        parent::__construct($appInfo);

        $this->objStoreOauth = new OauthStore();
    }

    /**
     * 小程序登录
     * @param $code
     * @return array
     */
    public function login($code)
    {
        // 微信登录地址
        $wxLoginUrl = sprintf(
            config('wx.small_app_login_url'), $this->app_info['small_app_id'], $this->app_info['small_app_secret'], $code);
        // 请求微信接口
        $result = curl_get($wxLoginUrl);
        /**
         * 注意json_decode的第一个参数true
         * 这将使字符串被转化为数组而非对象
         */
        $wxResult = \GuzzleHttp\json_decode($result, true);
        // $wxResult = [
        //     'session_key' => 'U7t5PUNJtPaXOPYtj1zlOg==',
        //     'openid' => 'ol5qq5SmxSsLyRNebQ26WTG1u53o'
        // ];
        if (empty($wxResult)) {
            /**
             * 为什么以empty判断是否错误，这是根据微信返回
             * 这种情况通常是由于传入不合法的code
             */
            $this->result['code'] = '10001';
            $this->result['msg'] = '获取session_key及openID时异常，微信内部错误';
        } else {
            /**
             * 建议用明确的变量来表示是否成功
             * 微信服务器并不会将错误标记为400，无论成功还是失败都标记成200
             * 这样非常不好判断，只能使用errcode是否存在来判断
             */
            if (array_key_exists('errcode', $wxResult)) {
                $this->result['code'] = $wxResult['errcode'];
                $this->result['msg'] = $wxResult['errmsg'];
            } else {
                return $this->login_handle($wxResult);
            }
        }
        return $this->result;
    }

    /**
     * 小程序注册授权
     * @param array $params
     * @return array
     */
    public function oauth($params=array()) {
        $_user_token = $params['token'];

        $small_app_session = $this->objStoreOauth->getSmallAppSessionByToken($this->app_id,$_user_token);
        if(!$small_app_session) {
            $this->result['code'] = 8520;
            $this->result['msg'] = '请先微信登录小程序!';
        } else {
            $iv = $params['iv'];
            $encryptedData = $params['encryptedData'];
            $data = '';
            $wxCrypt = new WXBizDataCrypt($this->app_info['small_app_id'], $small_app_session->session_key);
            $errCode = $wxCrypt->decryptData($encryptedData, $iv, $data);
            if($errCode == 0) {
                $oauth_info = \GuzzleHttp\json_decode($data, true);

                if($oauth_info['openId'] == $small_app_session->openid) {
                    if($small_app_session->uid > 0) {//用户已注册过
                        $user = $this->objStoreOauth->getUser($small_app_session->uid);
                        if($user) {
                            $this->result['data'] = array(
                                'nickname' => $user->nickname,
                                'avatar' => $oauth_info['avatarUrl'],
                                'mobile' => $user->mobile,
                            );
                        } else {//用户不存在
                            $this->objStoreOauth->deleteToken($small_app_session['session_id']);
                            $this->result['code'] = 8527;
                            $this->result['msg'] = '用户SESSION数据不一致, 请重新登录授权[1]!';
                        }
                    } else {//首次注册
                        $unionid = '';
                        $oauth_user = array();
                        if(isset($oauth_info['unionId']) && $oauth_info['unionId']) {
                            $oauth_user = $this->objStoreOauth->getOauthUser(array("from" => 'wechat', "unionid" => $oauth_info['unionId'], 'status' => 1));
                            $unionid = $oauth_info['unionId'];
                        }
                        if($oauth_user) {//微信公众号已经注册过
                            $user = $this->objStoreOauth->getUser($oauth_user->uid);
                            if($user) {
                                $this->_oauth_user_register($oauth_user->uid, $small_app_session, $oauth_info);
                                $this->objStoreOauth->updateToken($small_app_session->session_id,[
                                    'unionid' => $unionid,
                                    'uid' => $oauth_user->uid
                                ]);
                                $this->result['data'] = array(
                                    'nickname' => $user->nickname,
                                    'avatar' => $oauth_info['avatarUrl'],
                                    'mobile' => $user->mobile,
                                );
                            } else {
                                $this->objStoreOauth->deleteToken($small_app_session['session_id']);
                                $this->result['code'] = 8527;
                                $this->result['msg'] = '用户SESSION数据不一致, 请重新登录授权[2]!';
                            }
                        } else {
                            $ip = $this->ip;
                            $datetime = date("Y-m-d H:i:s", time());
                            $nickName = mb_substr($oauth_info['nickName'], 0, 12, 'UTF-8');
                            while($this->objStoreOauth->getUserByName($nickName)) {
                                $nickName .= random_string(1);
                            }
                            $uid = $this->objStoreOauth->addUser([
                                'username' => $nickName,
                                'password' => Hash::make('123456'),
                                'nickname' => $oauth_info['nickName'],
                                'avatar' => $oauth_info['avatarUrl'],
                                'last_login_time' => $datetime,
                                'last_login_ip' => $ip,
                                'create_time' => $datetime,
                            ]);
                            if($uid > 0) {
                                $this->_oauth_user_register($uid, $small_app_session, $oauth_info);
                                if($this->objStoreOauth->updateToken($small_app_session->session_id,[
                                    'unionid' => $unionid,
                                    'uid' => $uid,
                                    'update_at' => date('Y-m-d H:i:s', time())
                                ])) {
                                    $this->result['data'] = array(
                                        'nickname' => $oauth_info['nickName'],
                                        'avatar' => $oauth_info['avatarUrl'],
                                        'mobile' => '',
                                    );
                                } else {
                                    $this->result['code'] = 8525;
                                    $this->result['msg'] = 'update session uid failed!';
                                }
                            } else {//新增用户失败
                                // 删除注册的用户
                                $this->objStoreOauth->deleteUser($uid);
                                $this->result['code'] = 8526;
                                $this->result['msg'] = '用户注册失败!';
                            }
                        }
                    }
                } else {
                    $this->objStoreOauth->deleteToken($small_app_session->session_id);
                    $this->result['code'] = 8527;
                    $this->result['msg'] = '用户SESSION数据不一致, 请重新登录授权[3]!';
                }
            } else {//解密失败
                $this->result['code'] = 8524;
                $this->result['msg'] = '授权数据解密失败[code:'.$errCode.']!';
            }
        }
        return $this->result;
    }

    /**
     * @param $wxResult
     * @return array
     */
    private function login_handle($wxResult)
    {
        $openid = $wxResult['openid'];
        $session_key = $wxResult['session_key'];

        $token = md5($this->app_id.time().$openid.$session_key.rand(10000, 99999));

        // 用户授权信息
        $small_app_session = $this->objStoreOauth->getSmallAppSessionByOpenid($this->app_id,$openid);

        if ($small_app_session) {
            $data = [
                'session_key' => $session_key,
                'token' => $token,
                'expire_at' => time() + 7 * 86400,
                'update_at' => date('Y-m-d H:i:s', time())
            ];
            if ($this->objStoreOauth->updateToken($small_app_session->session_id,$data)) {
                $this->result['data']['token'] = $token;
                if ($small_app_session->uid > 0) {
                    $user = $this->objStoreOauth->getUser($small_app_session->uid);
                    if ($user) {
                        $small_app_oauth = $this->objStoreOauth->getOauthUser(array("from" => 'smallapp', "openid" => $openid, 'status' => 1));
                        if ($small_app_oauth) {
                            $this->_oauth_user_refresh($small_app_oauth->id);
                        }
                        $this->result['data']['oauthed'] = true;
                        $this->result['data']['user'] = array(
                            'nickname' => $user->nickname,
                            'avatar' => $user->avatar,
                            'mobile' => $user->mobile,
                        );
                    } else {
                        $this->result['data']['oauthed'] = false;
                    }
                } else {
                    $this->result['data']['oauthed'] = false;
                }
            } else {
                $this->result['code'] = 10003;
                $this->result['msg'] = 'GET Token failed[1]';
            }
        } else {
            $small_app_oauth = $this->objStoreOauth->getOauthUser(array("from" => 'smallapp', "openid" => $openid, 'status' => 1));
            $uid = 0;
            $unionid = '';
            if($small_app_oauth) {
                $user = $this->objStoreOauth->getUser($uid);
                if ($user) {
                    $uid = $small_app_oauth->uid;
                    $unionid = $small_app_oauth->unionid;
                }
            }
            $data = array(
                'app_id' => $this->app_id,
                'uid' => $uid,
                'openid' => $openid,
                'unionid' => $unionid,
                'session_key' => $session_key,
                'token' => $token,
                'expire_at' => time() + 7 * 86400,
                'create_at' => date('Y-m-d H:i:s', time())
            );

            $session_id = $this->objStoreOauth->addToken($data);

            if($session_id > 0) {
                $this->result['data']['token'] = $token;
                if($uid > 0) {
                    $this->_oauth_user_refresh($small_app_oauth->id);
                    $this->result['data']['oauthed'] = true;
                    $this->result['data']['user'] = array(
                        'nickname' => $user->nickname,
                        'avatar' => $user->avatar,
                        'mobile' => $user->mobile,
                    );
                } else {
                    $this->result['data']['oauthed'] = false;
                }
            } else {
                $this->result['code'] = 8505;
                $this->result['msg'] = 'GET Token failed![2]';
            }
        }
        return $this->result;
    }

    /**
     * 检查登录状态
     * @param $token
     * @return array
     */
    public function verifyToken($token)
    {
        $small_app_session = $this->objStoreOauth->getSmallAppSessionByToken($this->app_id,$token);
        if (!empty($small_app_session) && $small_app_session->expire_at > time() && $small_app_session->uid > 0) {
            $user = $this->objStoreOauth->getUser($small_app_session->uid);
            if ($user) {
                if($user->user_status == 2) {
                    $this->result['code'] = 10001;
                    $this->result['msg'] = '账号未激活, 请先激活账号';
                } else if($user->user_status == 0) {
                    $this->result['code'] = 10002;
                    $this->result['msg'] = '账号已被禁用, 请联系管理员';
                }
            } else {
                $this->result['code'] = 8508;
                $this->result['msg'] = '用户不存在!';
            }
        } else {
            $this->result['code'] = 8506;
            $this->result['msg'] = '认证失败，请先登录';
        }
        return $this->result;
    }

    /**
     * 第三方oauth用户授权注册
     * @param $uid
     * @param $small_app_session
     * @param $oauth_info
     * @return int
     */
    private function _oauth_user_register($uid, $small_app_session, $oauth_info) {
        $datetime = date("Y-m-d H:i:s", time());
        $data = [
            'from' => 'smallapp',
            'name' => $oauth_info['nickName'],
            'head_img' => $oauth_info['avatarUrl'],
            'uid' => $uid,
            'create_at' => $datetime,
            'last_login_time' => $datetime,
            'last_login_ip' => $this->ip,
            'status' => 1,
            'access_token' => $small_app_session->token,
            'expire_at' => $small_app_session->expire_at,
            'openid' => $small_app_session->openid,
            'unionid' => isset($oauth_info->unionId) ? $oauth_info['unionId'] : ''
        ];
        return $this->objStoreOauth->addOauthUser($data);
    }

    /**
     * 第三方oauth用户授权更新
     * @param $oauth_id
     * @return bool
     */
    private function _oauth_user_refresh($oauth_id) {
        $data = [
            'last_login_time' => date("Y-m-d H:i:s", time()),
            'last_login_ip' => $this->ip,
        ];
        return $this->objStoreOauth->refreshOauth($oauth_id,$data);
    }
}