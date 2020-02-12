@if(count($errors)>0)
    @foreach($errors->all() as $error)
        <input type="hidden" value="{{$error}}" id="input-errors">
    @endforeach
@endif