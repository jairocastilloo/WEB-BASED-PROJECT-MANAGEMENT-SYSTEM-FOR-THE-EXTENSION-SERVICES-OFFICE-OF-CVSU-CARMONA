$(document).ready(function() {
    
    var selectproject = $('#project-select').find(':selected');
    $('#projectindex').val(selectproject.val());
   

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

$('#confirmactivity').click((event) => {
    event.preventDefault();
    
    var assigneesindex = $('select[name="assignees[]"]').length;


// Iterate over each select element and set its name attribute
    
    $('select[name="assignees[]"]').each(function(index) {
        $(this).attr('name', 'assignees[' + index + ']');
        });
    
    $('#assigneesindex').val(assigneesindex);

    var dataurl = $('#act1').attr('data-url');
    var data1 = $('#act1').serialize();
    var data2 = $('#act2').serialize();
   
    
    // concatenate serialized data into a single string
    var formData = data1 + '&' + data2;
    
    // send data via AJAX
    $.ajax({
    url: dataurl,
    type: 'POST',
    data: formData,
    success: function(response) {
        console.log(response);
        $('#newactivity').modal('toggle');
        window.location.href = url;
        
    },
    error: function(xhr, status, error) {
        console.log(xhr.responseText);
        console.error(error);
        
    }
    });
    
});

});