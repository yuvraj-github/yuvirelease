$(document).on("submit", "#projectForm", function (e) {
    e.preventDefault();
    saveProject(this);    
});
function saveProject(that) {
    $.ajax({
        type: "POST",
        url: "/project/save",
        data: $(that).serialize(),
        success: function (response) {
            if(response.type === 'success') {
                window.location.href = '/viewProjects';
            } else {
                alertify.error(response.message);
               console.log(response.message);
            }
        },
        error: function (err) {
            console.log(err)
        }
    });
}
$(document).on('click', '#addProject', function(e) {
    var token = $(this).data('token');   
    getProjectForm(token);    
});
$(document).on('click', '.editProject', function(e) {
    var token = $(this).data('token');
    getProjectForm(token); 
});

function getProjectForm(token='') {
    $.ajax({
        type: "GET",
        url: "/project/getProjectForm",
        data: {token:token},
        success: function (response) {
            $('#projectModal').modal('show');
            $('#modalContent').html(response);
        },
        error: function (err) {
            console.log(err)
        }
    });
}
$(document).on('click', '.deleteProject', function(e) {
    var projectID = $(this).data('projectid');
    if (confirm('Are you sure ?')) {
        $.ajax({
            type: "GET",
            url: "/project/deleteProject",
            data: {projectID:projectID},
            success: function (response) {
                if(response.type === 'success') {
                    window.location.href = '/viewProjects';
                } else {
                   console.log(response.message);
                }
            },
            error: function (err) {
                console.log(err)
            }
        });
    }
});
