<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/4/8
 * @Time: 13:47
 */

namespace App\Transformers;


use App\Models\Article;
use League\Fractal\TransformerAbstract;

class ContentTransformer extends TransformerAbstract
{
    public function transform(Article $article)
    {
        $date = date('Y-m-d H:i', strtotime($article['create_at']));
        return [
            'id'   		=> $article['id'],
            'title' 	=> $article['title'],
            'remark'    => $article['remark'],
            'thumb'     => $article['thumb'],
            'author'    => $article['author'],
            'create_at'=> $date
        ];
    }

}