{{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

{{-- @if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
    <b>Please fill all the required filled below.</b>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif --}}

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
        {{   session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
    {{session('error')}}
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
     </button>
</div>
@endif
