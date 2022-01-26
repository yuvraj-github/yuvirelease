$(document).on('click', '.releaseNote', function(e) {
    e.preventDefault();
    var noteID = $(this).data('noteid');
    alert(noteID);
});