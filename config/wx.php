<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/4/16
 * @Time: 12:27
 */
return [
    // 微信使用code换取用户openid及session_key的url地址
    'small_app_login_url' => "https://api.weixin.qq.com/sns/jscode2session?".
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
];