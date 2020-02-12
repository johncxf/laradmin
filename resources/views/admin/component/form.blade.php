<form action="{{$url}}" method="POST" class="form-horizontal">
    @csrf
    @isset($method)
        @method($method)
    @endisset
    <div class="card-body">
        {{$form_body}}
    </div>
    <div class="card-footer">
        {{$form_footer}}
    </div>
</form>