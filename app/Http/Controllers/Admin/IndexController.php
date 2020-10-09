<?php
/**
 * Description：IndexController.php
 * Created by Phpstorm
 * User: chenxinfang
 * Date: 2019/11/18
 * Time: 20:30
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\OauthUser;
use App\Models\SmallAppSession;
use App\Models\User;

class IndexController extends Controller
{
    // 后台首页
    public function index()
    {
        $user_num = User::count();
        $admin_num = Admin::count();
        $oauth_num = OauthUser::where('uid','>',0)->count();
        $small_app_num = SmallAppSession::count();
        $nums = [
            'user_num' => $user_num,
            'admin_num' => $admin_num,
            'oauth_num' => $oauth_num,
            'sm_num' => $small_app_num
        ];
        return view('admin.index',compact('nums'));
    }

}
