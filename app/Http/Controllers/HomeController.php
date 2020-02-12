<?php

namespace App\Http\Controllers;

use App\Stores\Home\HomeStore;

class HomeController extends Controller
{
    protected $objStoreHome;

    public function __construct()
    {
//        $this->middleware('auth');
        $this->objStoreHome = new HomeStore();
    }

    public function index()
    {
        $articles = $this->objStoreHome->getArticles(10);
        return view('home', compact('articles'));
    }
}
