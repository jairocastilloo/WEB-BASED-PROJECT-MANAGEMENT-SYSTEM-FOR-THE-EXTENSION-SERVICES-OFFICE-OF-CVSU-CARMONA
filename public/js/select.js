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


$('td.bullet-cell div').on('click', '.show-assignees', function() {
    var td = $(this).closest('td');
    var id = td.data('value');
    var names = []
    if ($('#firstactivityassignees option').length > 0){
        $('#firstactivityassignees option').remove();
    }
    if ($('#activityassigneesform div').length > 1){
        $('#activityassigneesform div:not(:first)').remove();
    }
    
for (var key in activityassignees) {
  if (activityassignees[key].activity_id === id) {
    names.push(activityassignees[key].assignees_name);
    if (names.length === 1){
        var $newOption = $(`<option value="" selected>${names[names.length - 1]}</option>`);
        $('#firstactivityassignees').append($newOption);
        console.log(names[names.length - 1]);
    } else if (names.length > 1){
   var $newSelect = $(`<select class="col-9 m-1" id="activityassignees" name="activityassignees[]" disabled><option value="${names[key]}" selected>${names[key]}</option></select>`);
    var $newButton = $('<button type="button" class="delete-activityassignees btn btn-sm btn-danger col-2 m-1 btn-hover-toggle d-none btn-sm">Delete</button>');
    var $newDiv = $('<div class="mb-2 row">').append($newSelect, $newButton);
    $('#activityassigneesform').append($newDiv);}
  }
}


$('#assigneesModal').modal('show');
   

});

$('[id^="myDropdownButton"]').click(function() {
    // Find the corresponding dropdown menu and toggle its visibility
    $(this).siblings('.dropdown-menu').toggleClass('show');
  });

$('#remove-activityassignees').click((event) => {
    event.preventDefault();
    $('.delete-activityassignees').toggleClass('d-none');
    $('#labeltoselect').text('Select the Assignees you want to remove!');
    $('.btn-confirmremoveactivityassignees').toggleClass('d-none');
    $('.btn-activityassignees').toggleClass('d-none');
});

$('#activityassigneesform').on('click', '.delete-activityassignees', function() {
    if ($(this).text() === "Delete") {
        $(this).parent().addClass('highlight');
        $(this).removeClass('btn-danger').addClass('btn-outline-danger');
        $(this).text("Cancel");
    } else if ($(this).text() === "Cancel") {
        $(this).parent().removeClass('highlight');
        $(this).removeClass('btn-outline-danger').addClass('btn-danger');
        $(this).text("Delete");
    }
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