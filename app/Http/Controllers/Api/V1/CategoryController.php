<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;

class CategoryController extends BaseApiController
{
    //
    public function index()
    {
        $categories = Category::where('status',1)->get();
        return $this->response->collection($categories, new CategoryTransformer());
    }
}
