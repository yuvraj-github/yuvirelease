@extends('layout')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/asset/js/note.js"></script>
    @if (Session::has('status'))
        <div class="alert {{ Session::get('alert-class') }} alert-dismissible fade show" role="alert">
            {{ Session::get('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <h3>Add Note</h3>
    <form id="noteForm" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="{{ $noteDetails->title }}">
                <input type="hidden" name="token" value="{{ $noteDetails->id }}">
            </div>
            <div class="form-group col-md-6">
                <label for="project">Select Project</label>
                <select class="form-control" id="project" name="project">
                    <option value="">Select project</option>
                    @foreach ($projects as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $noteDetails->projectid ? 'selected' : '' }}>{{ $item->projectname }}</option>
                    @endforeach
                </select>
                <span class="projectError"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ $noteDetails->description }}</textarea>
            <span class="descError"></span>
        </div>
        <div class="form-group">
            <label>Published</label><br />
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="published" id="publishedYes" value="1" checked="checked" {{ $noteDetails->published == '1' ? 'checked' : '' }}>
                <label class="form-check-label" for="publishedYes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="published" id="publishedNo" value="0" {{ $noteDetails->published == '0' ? 'checked' : '' }}>
                <label class="form-check-label" for="publishedNo">No</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ $btn }}</button>
        <a href="/note" class="btn btn-secondary">Cancel</a>
    </form>
    <script>
        $(document).ready(function() {
            $('#project').select2();
            $('#description').summernote({
                height: 400,
                placeholder: 'Description',
            });
        });
    </script>
@endsection
