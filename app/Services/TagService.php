<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/2/4
 * @Time: 17:16
 */

namespace App\Services;

use Illuminate\Support\Facades\Blade;

class TagService
{
    public function make()
    {
        $this->category();
        $this->link();
        $this->list();
        $this->slide();
    }

    /**
     * 栏目
     */
    public function category()
    {
        Blade::directive('category',function ($expression){
            $expression = $expression?$expression:'[]';
            $php = <<<php
            <?php
                \$params = $expression;
                \$db = \App\Models\Category::where('status',1)->get()->toArray();
                \$cates = (new \App\Tools\MenuUtils)->generateTree(\$db, 'id', 'pid', '_child');
                foreach(\$cates as \$cate):
            ?>
php;
            return $php;
        });
        Blade::directive('endCategory',function(){
            return "<?php endforeach; ?>";
        });
    }

    /**
     * 友情链接
     */
    public function link()
    {
        Blade::directive('link', function ($expression) {
            $expression = $expression?$expression:'[]';
            $php=<<<php
                <ul class="list-group mt-2">
                    <li class="list-group-item active">友情链接</li>
                    <?php
                        \$params = $expression;
                        \$limit = 5;
                        \$type = 'friend';
                        if(isset(\$params['limit'])){
                            \$limit = \$params['limit'];
                        }
                        if(isset(\$params['type'])){
                            \$type = \$params['type'];
                        }
                        \$data = \App\Models\Link::where('type',\$type)->limit(\$limit)->get();
                        foreach(\$data as \$field):
                            echo '<li class="list-group-item"><a href="'.\$field->url.'" class="text-decoration-none" target="_blank">'.\$field->name.'</a></li>';
                        endforeach;
                    ?>
                </ul>
php;
return $php;
        });
    }

    /**
     * 文章标签
     */
    public function list()
    {
        Blade::directive('list',function ($expression){
            $expression = $expression?$expression:'[]';
            $php = <<<php
            <?php
                \$params = $expression;
                \$db = \App\Models\Article::where('status',2);
                if(isset(\$params['is_hot'])){
                    \$db->orderBy('pv','desc');
                }
                if(isset(\$params['is_top'])){
                    \$db->where('is_top',1);
                }
                if(isset(\$params['is_new'])){
                    \$db->orderBy('create_at','desc');
                }
                if(isset(\$params['limit'])){
                    \$db->limit(\$params['limit']);
                }
                foreach(\$db->get() as \$field):
            ?>
php;
return $php;
        });
        Blade::directive('endList',function(){
            return "<?php endforeach; ?>";
        });
    }

    /**
     * 幻灯片
     */
    public function slide()
    {
        Blade::directive('slide',function ($expression){
            $expression = $expression?$expression:'[]';
            $php = <<<php
            <?php
                \$params = $expression;
                \$type = 'home';
                \$limit = 3;
                if(isset(\$params['type'])){
                    \$type = \$params['type'];
                }
                if(isset(\$params['limit'])){
                    \$limit = \$params['limit'];
                }
                \$data = \App\Models\Slide::where('status',1)->where('type',\$type)
                ->orderBy('sort','asc')
                ->limit(\$limit)
                ->get()
                ->toArray();
                foreach(\$data as \$field):
            ?>
php;
            return $php;
        });
        Blade::directive('endSlide',function(){
            return "<?php endforeach; ?>";
        });
    }

}