@if(@count($errors) > 0)
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>  
                {{$error}}
            </li>
        @endforeach
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif

{{-- @if(session('error'))
    <div class="alert alert-alert">
        {{session('error')}}
    </div>
@endif --}}