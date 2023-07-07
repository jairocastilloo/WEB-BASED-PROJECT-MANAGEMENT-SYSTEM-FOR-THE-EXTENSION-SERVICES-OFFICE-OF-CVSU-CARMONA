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
    var dropdownMenu = $(this).siblings('.dropdown-menu');
    $('.dropdown-menu').not(dropdownMenu).removeClass('show').addClass('hide');
    dropdownMenu.toggleClass('show hide');

  });

  $('[id^="myDropdownSubtask"]').click(function() {
    // Find the corresponding dropdown menu and toggle its visibility
    var dropdownMenu = $(this).siblings('.dropdown-menu');
    $('.dropdown-menu').not(dropdownMenu).removeClass('show').addClass('hide');
    dropdownMenu.toggleClass('show hide');

  });

$('#remove-activityassignees').click((event) => {
    event.preventDefault();
    $('.delete-activityassignees').toggleClass('d-none');
    $('#labeltoselect').text('Select the Assignees you want to remove!');
    $('.btn-confirmremoveactivityassignees').toggleClass('d-none');
    $('.btn-activityassignees').toggleClass('d-none');
});

$('.addoutput-button').click((event) => {
    event.preventDefault();
    var outputElement = `
          <div class="mb-2 row" id="selectoutput">
            <select class="col-9 m-1" id="output-select" name="output[]">
              <option value="" selected disabled>Select Output Type</option>
              <option value="Capacity building">Capacity building</option>
              <option value="IEC Material">IEC Material</option>
              <option value="Advisory services">Advisory services</option>
              <option value="Others">Others</option>
            </select>
            <button type="button" class="remove-output btn btn-danger col-2 m-1" id="removeoutput">Remove</button>
          </div>
        `;
        $('#act3').append(outputElement);
});

$('#act3').on('click', '.remove-output', function() {
    $(this).parent().remove();
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
    var outputindex = $('select[name="output[]"]').length;
   
    
    for (let i = 1; i < assigneesindex; i++) {
        $('#act1').append(`<input type="text" class="d-none" id="assigneesname" name="assigneesname[${i}]">`);
      }
    
      

// Iterate over each select element and set its name attribute
    
   
        $('select[name="assignees[]"]').each(function(index) {
            let assigneesnameInput = $(`input[name="assigneesname[${index}]"]`);
            $(this).attr('name', 'assignees[' + index + ']');
            
            assigneesnameInput.val($(this).find('option:selected').text());
          });
          $('select[name="output[]"]').each(function(index) {
            $(this).attr('name', 'output[' + index + ']');
          });
          
        
    
    $('#assigneesindex').val(assigneesindex);
    $('#outputindex').val(outputindex);

    var dataurl = $('#act1').attr('data-url');
    var data1 = $('#act1').serialize();
    var data2 = $('#act2').serialize();
    var data3 = $('#act3').serialize();
   
    
    // concatenate serialized data into a single string
    var formData = data1 + '&' + data2 + '&' + data3;
    
    
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

$(document).on('click', '.subtask-link', function(){
    $('#new-subtask-modal').modal('show');
});
$(document).on('click', '.output-link', function() {

    $('.output-container').remove();


    var $this = $(this); // Store reference to 'this'
    $('#outputmodallabel').text($this.parent().data('actname'));
    
    var filteredOutputs = $.grep(outputs, function(output) {
        return output.output_type === $this.text() && output.activity_id === $this.parent().val();
    });
    
    // Access the output_names of the filtered outputs
    var outputNames = filteredOutputs.map(function(output) {
        return output.output_name;
    });
    var outputTypes = filteredOutputs.map(function(output) {
        return output.output_type;
    });
    
    $('#firstoutput-container label').text(outputNames[0]);
    $('#firstoutput-container .firstoutput-name').val(outputNames[0]);
    $('#firstoutput-container .firstoutput-type').val(outputTypes[0]);
    
    for (var i = 1; i < outputNames.length; i++) {
        var outputContainer = $('<div class="mb-2 row output-container"></div>');
        outputContainer.append(`<label class="col-7 m-1 output-label">${outputNames[i]}</label>`);
        outputContainer.append('<input type="number" class="col-4 m-1" name="output-number[' + i + ']">');
        outputContainer.append(`<input type="text" class="d-none" name="out-name[` + i + `]" value="${outputNames[i]}">`);
        outputContainer.append(`<input type="text" class="d-none" name="out-type[` + i + `]" value="${outputTypes[i]}">`);
        $('#outputformdiv form').append(outputContainer);
    }   
    $('#submitoutputindex').val(outputNames.length);

    $('#output-modal').modal('show');
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


$('#submitoutput').click((event) => {
    event.preventDefault();
    
    

    var dataurl = $('#outputformsubmit').attr('data-url');
    var data1 = $('#outputformsubmit').serialize();

    // send data via AJAX
    $.ajax({
        url: dataurl,
        type: 'POST',
        data: data1,
        success: function(response) {
            console.log(response);
            $('#output-modal').modal('toggle');
            window.location.href = url;

        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            console.error(error);

        }
    });

});

});