<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Stores\Home\ArticleStore;
use App\Stores\Home\HomeStore;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{
    public function index($alias)
    {
        $category = (new HomeStore())->getCategory($alias);
        $articles = (new ArticleStore())->getArticleByCid($category['id']);
        $template = 'index';
        if (View::exists('home.category.'.$alias)) {
            $template = $alias;
        }
        return view('home.category.'.$template, compact('category','articles'));
    }
}
