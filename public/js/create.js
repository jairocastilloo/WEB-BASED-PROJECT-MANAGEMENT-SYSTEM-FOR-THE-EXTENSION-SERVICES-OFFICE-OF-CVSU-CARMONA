
$(document).ready(function() {
    

    // CREATE PROJECT
    $.each(users, function(index, user) {
        $('#member-select').append($('<option>', {
            value: user.id,
            text: user.name
        }));
    });
    
    $('#addmember').click((event) => {
        event.preventDefault();
        var $newSelect = $(`<select class="col-9 m-1" id="member-select" name="projectmember[]"><option value="" disable selected>Select a Member</option></select>`);
        var $newButton = $('<button type="button" class="remove-member btn btn-danger col-2 m-1" id="removemember">Remove</button>');
        var $newDiv = $('<div class="mb-2 row" id="selectmember">').append($newSelect, $newButton);
        $('#memberform form').append($newDiv);
        $.each(users, function(index, user) {
            $('#memberform form div:last #member-select').append($('<option>', {
                value: user.id,
                text: user.name
            }));
        });
        
      });

    $('#memberform form').on('click', '.remove-member', function() {
        $(this).parent().remove();
    });

    $('#addobjective').click((event) => {
        event.preventDefault();
        var $newInput = $('<input type="text" class="col-7 m-1 input-objective" id="objective-input" name="projectobjective[]" placeholder="Enter objective">');
        var $newButton1 = $('<button type="button" class="edit-objective btn btn-success col-2 m-1" id="editobjective">Edit</button>');
        var $newButton2 = $('<button type="button" class="remove-objective btn btn-danger col-2 m-1" id="removeobjective">Remove</button>');
        var $newDiv = $('<div class="mb-2 row" id="#selectobjectives">').append($newInput, $newButton1, $newButton2);
        $('#objectiveform form').append($newDiv);
        
    });

    $('#objectiveform form').on('click', '.remove-objective', function() {
        $(this).parent().remove();
    });
    $('#objectiveform form').on('click', '.edit-objective', function() {
        $(this).prev().focus();
    });
    $('#objectiveform form').on('keydown', '.input-objective', function() {
        if (event.keyCode === 13) { 
          event.preventDefault(); 
          
          $(this).blur();
         
        }
    });

    $('#createproject').click((event) => {
        event.preventDefault();
        
        var memberindex = $('select[name="projectmember[]"]').length;
        var objectiveindex = $('input[name="projectobjective[]"]').length;

// Iterate over each select element and set its name attribute
        $('input[name="projectobjective[]"]').each(function(index) {
        $(this).attr('name', 'projectobjective[' + index + ']');
        });
        $('select[name="projectmember[]"]').each(function(index) {
            $(this).attr('name', 'projectmember[' + index + ']');
            });
        
        $('#memberindex').val(memberindex);
        $('#objectiveindex').val(objectiveindex);
        var dataurl = $('#form1').attr('data-url');
        var data1 = $('#form1').serialize();
        var data2 = $('#form2').serialize();
        var data3 = $('#form3').serialize();
        
        // concatenate serialized data into a single string
        var formData = data1 + '&' + data2 + '&' + data3;
        
        // send data via AJAX
        $.ajax({
        url: dataurl,
        type: 'POST',
        data: formData,
        success: function(response) {
            console.log(response);
            $('#newproject').modal('toggle');
            window.location.href = url;
            
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            console.error(error);
            
        }
        });
        
    });

});