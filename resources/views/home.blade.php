@extends('layout')

@section('content')
    <h3>Home</h3>
    <div class="row">
        <div class="col-3">
            <div id="accordion">
                @foreach ($notes as $projectName => $allNotes)
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse"
                                    data-target="#collapse_{{ $loop->iteration }}" aria-expanded="true"
                                    aria-controls="collapse_{{ $loop->iteration }}">
                                    {{ $projectName }}
                                </button>
                            </h5>
                        </div>
                        <div id="collapse_{{ $loop->iteration }}" class="collapse" aria-labelledby="headingOne"
                            data-parent="#accordion">
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @foreach ($allNotes as $key => $val)
                                        <li class="list-group-item">{{ $val->title }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-9">

        </div>
    </div>
@endsection
