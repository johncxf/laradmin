<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Stores\Admin\UserStore;

class UserController extends Controller
{
    protected $objStoreUser;

    public function __construct()
    {
        $this->objStoreUser = new UserStore();
    }

    //
    public function index()
    {
        $users = $this->objStoreUser->getAllUsers();

        return view('admin.user.index', compact('users'));
    }
}
