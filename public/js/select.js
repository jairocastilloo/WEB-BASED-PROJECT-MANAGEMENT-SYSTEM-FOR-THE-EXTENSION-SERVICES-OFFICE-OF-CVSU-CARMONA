$(document).ready(function() {
$('#addassignees').click((event) => {
    event.preventDefault();
    var $newSelect = $(`<select class="col-9 m-1" id="assignees-select" name="assignees[]"><option value="" disable selected>Select a Assignees</option></select>`);
    var $newButton = $('<button type="button" class="remove-assignees btn btn-danger col-2 m-1" id="removeassignees">Remove</button>');
    var $newDiv = $('<div class="mb-2 row" id="selectassignees">').append($newSelect, $newButton);
    $('#assigneesform form').append($newDiv);
    $.each(assignees, function(index, assignee) {
        $('#assigneesform form div:last #assignees-select').append($('<option>', {
            value: assignee.id,
            text: assignee.name
        }));
    });

});

$('#memberform form').on('click', '.remove-member', function() {
    $(this).parent().remove();
});
});