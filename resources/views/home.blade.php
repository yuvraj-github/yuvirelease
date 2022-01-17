@extends('layout')

@section('content')
    <h3>Home</h3>
    <div class="row">
        <div class="col-3">
            @foreach ($notes as $key => $val)
                <p>{{ $key }}</p>
                @foreach ($val as $k => $v)
                    <p>---> {{ $v->title }}</p>
                @endforeach
            @endforeach
        </div>
        <div class="col-9">

        </div>
    </div>
@endsection
