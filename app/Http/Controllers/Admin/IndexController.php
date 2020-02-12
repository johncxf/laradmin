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

class IndexController extends Controller
{
    // 后台首页
    public function index()
    {
        return view('admin.index');
    }

}
