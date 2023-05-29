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
    
    for (let i = 1; i < assigneesindex; i++) {
        $('#act1').append(`<input type="text" class="d-none" id="assigneesname" name="assigneesname[${i}]">`);
      }

// Iterate over each select element and set its name attribute
    
   
        $('select[name="assignees[]"]').each(function(index) {
            let assigneesnameInput = $(`input[name="assigneesname[${index}]"]`);
            $(this).attr('name', 'assignees[' + index + ']');
            
            assigneesnameInput.val($(this).find('option:selected').text());
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


$(document).on('click', '.add-subtask-btn', function() {
    $('#subtaskname').val('');
    var select = $('#subtaskassignee');
    select.children().not(':first').remove();
    var unordered = $(this).prev();
    var lis = unordered.find('li');

    var activityindex = $(this).closest('td').data('activity');

    $('#activitynumber').val(activityindex);

    lis.each(function() {
        var liText = $(this).text();

        var option = $('<option>', {
            value: liText,
            text: liText
        });
        select.append(option);
    });
    $('#new-subtask-modal').modal('show');

});

$('#createsubtask').click((event) => {
    event.preventDefault();


    var dataurl = $('#subtaskform').attr('data-url');
    var data1 = $('#subtaskform').serialize();


    // send data via AJAX
    $.ajax({
        url: dataurl,
        type: 'POST',
        data: data1,
        success: function(response) {
            console.log(response);
            $('#new-subtask-modal').modal('toggle');
            window.location.href = url;

        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            console.error(error);

        }
    });

});

});