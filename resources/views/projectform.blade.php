    <form method="POST" action="" id="projectForm">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="projectName">Project Name <span style="color:red;">*</span></label>
                <input type="text" class="form-control col-md-8" id="projectName" name="projectName"
                    placeholder="Enter Project Name" value="{{ $projectDetail->projectname }}">
                <input type="hidden" value="{{ $projectDetail->id }}" name="token">
            </div>
            <div class="form-group">
                <label>Published</label><br />
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="published" id="publishedYes" value="1"
                        checked="checked" {{ $projectDetail->published == '1' ? 'checked' : ''; }}>
                    <label class="form-check-label" for="publishedYes">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="published" id="publishedNo" value="0" {{ $projectDetail->published == '0' ? 'checked' : ''; }}>
                    <label class="form-check-label" for="publishedNo">No</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">{{ $btn }}</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#projectForm").validate({
                rules: {
                    projectName: "required",
                },
                messages: {
                    projectName: "Project name is required",
                },
            });
        });
    </script>
