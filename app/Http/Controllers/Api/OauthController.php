<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\OauthService;

class OauthController extends BaseApiController
{
    /**
     * @var OauthService
     */
    protected $OauthService;

    /**
     * OauthController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->OauthService = new OauthService($this->app_info);

    }

    /**
     * 小程序登录
     * @app_id 应用id
     * @code 小程序code
     * @Post("/")
     * @Versions({"v1"})
     * @Request("", contentType="application/x-www-form-urlencoded")
     */
    public function login()
    {
        $code = request('code');

        $ret = $this->OauthService->login($code);

        return response()->json($ret);
    }

    /**
     * 小程序授权
     * @app_id 应用id
     * @iv 加密算法的初始向量
     * @encryptedData 包括敏感数据在内的完整用户信息的加密数据
     * @Post("/")
     * @Versions({"v1"})
     * @Request("", contentType="application/x-www-form-urlencoded")
     */
    public function oauth()
    {
        $params = request(['token', 'iv', 'encryptedData']);

        $ret = $this->OauthService->oauth($params);

        return response()->json($ret);
    }

    public function token()
    {
        $token = request('token');

        $ret = $this->OauthService->verifyToken($token);

        return response()->json($ret);
    }
}
