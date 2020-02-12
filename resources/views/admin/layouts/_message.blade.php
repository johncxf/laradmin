@foreach(['success', 'danger', 'warning'] as $t)
    @if(session()->has($t))
        <input type="hidden" id="input-message-{{$t}}" value="{{session()->get($t)}}">
    @endif
@endforeach