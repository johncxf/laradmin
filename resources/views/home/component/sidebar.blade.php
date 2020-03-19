<div class="card text-center">
    <div class="card-header">
        <ul class="nav nav-pills card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#" data-target="#tab1" data-toggle="tab">热门文章</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-target="#tab2" href="#" data-toggle="tab">最新发布</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-target="#tab3" data-toggle="tab">下载排行</a>
            </li>
        </ul>
    </div>
    <div class="card-body tab-content">
        <div class="tab-pane active" id="tab1">
            @list(['is_hot'=>1,'limit'=>5])
                <p class="text-left"><a href="/article/{{$field['id']}}.html" class="text-decoration-none">{{$field['title']}}</a><hr /></p>
            @endList
        </div>
        <div class="tab-pane" id="tab2" >
            @list(['is_new'=>1,'limit'=>5])
                <p class="text-left"><a href="/article/{{$field['id']}}.html" class="text-decoration-none">{{$field['title']}}</a><hr /></p>
            @endList
        </div>
        <div class="tab-pane" id="tab3">
            @download(['type'=>'download','limit'=>5])
            <p class="text-left"><a href="/download/detail/{{$field->id}}.html" class="text-decoration-none">{{$field->title}}</a><hr /></p>
            @endDownload
        </div>
    </div>
</div>