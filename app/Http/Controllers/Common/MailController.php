<?php

namespace App\Http\Controllers\Common;

use App\Mail\CaptchaMail;
use App\Stores\Common\MailStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MailController extends Controller
{
    protected $objStoreMail;
    public function __construct()
    {
        $this->objStoreMail = new MailStore();
    }

    // 发送邮件验证码
    public function sendCaptcha(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
        ],[
            'email.required' => '请填写邮箱地址',
            'email.email' => '邮箱格式错误'
        ]);
        if (auth()->user()['email'] == $request['email']) {
            return ['status' => 'fail','msg' => '新邮箱不能和旧邮箱相同'];
        }
        if ($this->objStoreMail->pass(auth()->id(),60) === false) {
            return ['status' => 'fail','msg' => '不能连续发送'];
        }
        $captcha = Str::random(5);
        $data = [
            'uid' => auth()->id(),
            'contact' => $request['email'],
            'token' => $captcha,
            'type' => 'mail',
            'create_at' => date('Y-m-d H:i:s',time())
        ];
        if ($this->objStoreMail->saveVerify($data)) {
            Mail::to($request['email'])->send(new CaptchaMail(['captcha' => $captcha]));
            return ['status' => 'success','msg' => '发送成功'];
        } else {
            return ['status' => 'fail','msg' => '发送失败'];
        }
    }

}
