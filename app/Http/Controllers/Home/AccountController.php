<?php

namespace App\Http\Controllers\Home;

use App\Stores\Home\AccountStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    protected $objStoreAccount;
    public function __construct()
    {
        $this->objStoreAccount = new AccountStore();
    }

    public function gold()
    {
        $gold_logs = $this->objStoreAccount->getGoldLogs(auth()->id(),8);
        $gold_info = $this->objStoreAccount->getGoldInfo(auth()->id());
        return view('home.account.gold',compact('gold_logs','gold_info'));
    }
}
