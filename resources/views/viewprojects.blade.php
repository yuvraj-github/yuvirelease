@extends('layout')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        crossorigin="anonymous"></script>
    <script src="/asset/js/projects.js"></script>
    @if (Session::has('status'))
        <div class="alert {{ Session::get('alert-class') }} alert-dismissible fade show" role="alert">
            {{ Session::get('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="mt-3">
        <form class="form-inline" action="" method="GET">
            <div class="form-group mx-sm-3 mb-2">
                <input type="text" class="form-control" id="projectName" name="projectName"
                    value="{{ $criteria->projectname }}" placeholder="Enter project name">
            </div>            
            <div class="form-group mx-sm-3 mb-2">
                <select class="custom-select my-1 mr-sm-2" id="publishedStatus" name="publishedStatus">
                    <option value="">Select published</option>
                    <option value="1" {{ $criteria->published == '1' ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ $criteria->published == '0' ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mb-2" id="btnFilter">Filter</button>&nbsp;
            <a href="/viewProjects" class="btn btn-secondary mb-2">clear</a>
        </form>
    </div>
    <h3>View Proje <a href="#" style="float: right; font-size: 20px;" id="addProject" data-token=''>Add
            Project <i class="fa fa-plus" aria-hidden="true"></i></a></h3>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">@sortablelink('projectname', 'Project Name')</th>
                <th scope="col">@sortablelink('published')</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (count($projects) > 0)
                @foreach ($projects as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->projectname }}</td>
                        <td>{{ $item->published == '1' ? 'Yes' : 'No' }}</td>
                        <td>{{ $item->created_at != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($item->created_at)) : '' }}
                        </td>
                        <td>
                            <a href="javascript:void(0)" data-token={{ $item->id }} class="editProject"><i
                                    class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;
                            <a href="javascript:void(0)" data-projectid={{ $item->id }} class="deleteProject"><i
                                    class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <th scope="row">No data found.</th>
                </tr>
            @endif
        </tbody>
    </table>
    <div style="float: right;">{{ $projects->links('pagination::bootstrap-4') }} </div>
    <!-- Modal -->
    <div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="projectModalLabel">Add Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modalContent">

                </div>
            </div>
        </div>
    </div>
@endsection
