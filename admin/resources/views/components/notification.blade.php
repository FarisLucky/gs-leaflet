{{-- {{ dd(session()->all()) }} --}}
@if (session()->has('status'))
    @if (session()->get('status') == 'ok')
        <div class="alert alert-success" role="alert">
            {{ session()->get('msg') }}
        </div>
    @elseif (session()->get('status') == 'fail')
        <div class="alert alert-danger" role="alert">
            {{ session()->get('msg') }}
        </div>
    @endif
@endif
