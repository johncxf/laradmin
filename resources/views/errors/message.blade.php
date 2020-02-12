@foreach(['success', 'danger', 'warning'] as $t)
    @if(session()->has($t))
        <div class="alert alert-{{$t}} alert-dismissible fade show" role="alert">
            {{session()->get($t)}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@endforeach