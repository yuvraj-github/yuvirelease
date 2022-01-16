$(document).ready(function() {
    $("#noteForm").validate({
        ignore: ".note-editor *",
        rules: {
            title: "required",
            project: "required",
            description: "required"
        },
        messages: {
            title: "Title is required",
            project: "Please select project",
            description: "Description is required."
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "project")
            {
                error.insertAfter(".projectError");
            } else if (element.attr("name") == "description") {
                error.insertAfter(".descError");
            }else {
                error.insertAfter(element);
            }          
        }
    });    
});
$(document).on('submit', '#noteForm', function(e) {
    e.preventDefault();
    saveNote(this);
});
function saveNote(that) {
    $.ajax({
        type: "POST",
        url: "/note/save",
        data: $(that).serialize(),
        success: function (response) {
            if(response.type === 'success') {
                window.location.href = '/note';
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
