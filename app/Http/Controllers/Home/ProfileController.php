<?php

namespace App\Http\Controllers\Home;

use App\Stores\Common\UploadStore;
use App\Stores\Home\ProfileStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * @var ProfileStore
     */
    protected $objStoreProfile;

    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->objStoreProfile = new ProfileStore();
    }

    //个人中心
    public function index()
    {
        return view('home.profile.index');
    }
    // 账号设置
    public function site()
    {
        return view('home.profile.site');
    }
    //修改邮箱
    public function resetEmail(Request $request)
    {
        $data = [
            'uid' => auth()->id(),
            'email' => $request['email'],
            'captcha' => $request['captcha']
        ];
        if ($this->objStoreProfile->checkCaptcha($data) === false) {
            return back()->with('danger','验证码无效');
        }
        if ($this->objStoreProfile->updateEmail($data)) {
            return back()->with('success','修改成功');
        } else {
            return back()->with('danger','修改失败');
        }
    }
    // 消息
    public function message()
    {
        return view('home.profile.message');
    }
    // 基本资料
    public function info()
    {
        return view('home.profile.info');
    }
    // 更新基本资料
    public function updateInfo(Request $request)
    {
        $this->validate($request,[
            'nickname' => 'required|between:1,20',
            'sex' => 'required',
            'signature' => 'required|between:1,30',
            'mobile' => 'required|regex:/^1[345678][0-9]{9}$/|unique:la_user,mobile,'.auth()->id()
        ],[
            'nickname.required' => '请填写用户昵称',
            'nickname.between:1,20' => '用户昵称不能多于20个字',
            'sex.required' => '请选择性别',
            'signature.required' => '请填写用户简介',
            'signature.between:1,30' => '用户简介需要少于30字',
            'mobile.required' => '请填写手机号码',
            'mobile.regex' => '手机号码格式错误',
            'mobile.unique' => '手机号码已经存在'
        ]);
        $data = [
            'nickname' => $request['nickname'],
            'sex' => $request['sex'],
            'signature' => $request['signature'],
            'mobile' => $request['mobile']
        ];
        if ($this->objStoreProfile->updateUser($data,auth()->id())) {
            return back()->with('success','用户资料修改成功');
        } else {
            return back()->with('danger','用户资料修改失败');
        }
    }
    // 动态
    public function moment()
    {
        return view('home.profile.moment');
    }
    // 我的收藏
    public function star()
    {
        $article_stars = $this->objStoreProfile->getStarArticle(auth()->id());
        return view('home.profile.star', compact('article_stars'));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function uploadAvatar(Request $request)
    {
        $ret = (new UploadStore())->putImg($request->getContent(),'uploads/avatars/');
        if (empty($ret)) {
            return ['status' => 'error', '上传失败'];
        }
        $url = $ret['save_path'].'/'.$ret['file_name'];
        $oldImg = $this->objStoreProfile->getOldAvatar(auth()->id());
        if ($this->objStoreProfile->updateAvatar(auth()->id(),$url)) {
            if (substr($oldImg,0,3) != 'img') {
                if (file_exists($oldImg)) {
                    unlink($oldImg);
                }
            }
            return ['status' => 'success', '更新成功'];
        } else {
            if (file_exists($url)) {
                unlink($url);
            }
            return ['status' => 'error', '更新失败'];
        }
    }
}
