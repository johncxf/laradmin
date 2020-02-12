<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5 class="m-0 text-dark">{{$webSiteInfo->getHeaderPage()['title']}}</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @if($webSiteInfo->getHeaderPage()['home'])
                        <li class="breadcrumb-item"><a href="/admin/index">控制台</a></li>
                    @endif
                    @if(empty($webSiteInfo->getHeaderPage()['link']))
                        <li class="breadcrumb-item active">default</li>
                    @else
                        @foreach($webSiteInfo->getHeaderPage()['link'] as $link)
                            <li class="breadcrumb-item active">{{$link}}</li>
                        @endforeach
                    @endif
                </ol>
            </div>
        </div>
    </div>
</div>