<?php

namespace App\Http\Controllers\Home;

use App\Stores\Home\SearchStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    protected $objStoreSearch;

    public function __construct()
    {
        $this->objStoreSearch = new SearchStore();
    }

    // 搜索
    public function make(Request $request)
    {
        $keyword = $request->keyword;
        $resources = $this->objStoreSearch->getSearchResult($keyword);

        return view('home.search', compact('resources','keyword'));
    }
}
