$(document).on('click', '.deleteNote', function(e) {
    e.preventDefault();
    var noteID = $(this).data('noteid');
    if(confirm('Are you sure ?')) {
        $.ajax({
            type: 'GET',
            url: '/note/delete',
            data: {noteID:noteID},
            success: function (response) {
                if(response.type === 'success' ) {
                    window.location.href = '/note';
                } else {
                    console.log(response.message);
                }
            },
            error: function (err) {
                console.log(err);
            }
        });
    }
});