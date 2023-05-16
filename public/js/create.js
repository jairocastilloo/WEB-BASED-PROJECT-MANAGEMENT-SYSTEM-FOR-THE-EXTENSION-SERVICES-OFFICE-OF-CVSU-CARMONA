

$(document).ready(function() {
    var currentstep = 0;
    $('#addmember').hide();
    // CREATE PROJECT
    users.sort(function(a, b) {
        var nameA = a.name.toUpperCase(); // Convert name to uppercase to compare
        var nameB = b.name.toUpperCase(); // Convert name to uppercase to compare
        if (nameA < nameB) {
          return -1;
        }
        if (nameA > nameB) {
          return 1;
        }
        return 0; // Names are equal
      });
    $.each(users, function(index, user) {
        
        $('#member-select').append($('<option>', {
            value: user.id,
            text: user.name
        }));
    });
    
    function updateButtons(){
      if (currentstep == 0){
        $('#prevproject').hide();
        $('#nextproject').show();
        $('#createproject').hide();
        $('#tab1-tab').tab('show');
      } 
      else if (currentstep == 1){
        $('#prevproject').show();
        $('#nextproject').show();
        $('#createproject').hide();
        $('#tab2-tab').tab('show');
      }
      else if (currentstep == 2){
        $('#prevproject').show();
        $('#nextproject').hide();
        $('#createproject').show();
        $('#tab3-tab').tab('show');
      }

    }
   
    $('#nextproject').click((event) => {

      event.preventDefault();
      currentstep++;
      console.log(currentstep);
      updateButtons();

    });
    $('#prevproject').click((event) => {

      event.preventDefault();
      currentstep--;
      console.log(currentstep);
      updateButtons();
    });

    $('#addproj').click((event) => {

      event.preventDefault();
      console.log(currentstep);
      updateButtons();
    });

    $('#addmember').click((event) => {
        event.preventDefault();
        var $newSelect = $(`<select class="member-select col-7 m-1" id="member-select" name="projectmember[]"><option value="" selected disabled>Select a Member</option></select>`);
        var $newButton = $('<button type="button" class="remove-member btn btn-danger col-2 m-1 float-end" id="removemember">Remove</button>');
        var $newDiv = $('<div class="mb-2 row bg-info" id="selectmember">').append($newSelect, $newButton);
        $('#memberform form').append($newDiv);

        users.sort(function(a, b) {
            var nameA = a.name.toUpperCase(); // Convert name to uppercase to compare
            var nameB = b.name.toUpperCase(); // Convert name to uppercase to compare
            if (nameA < nameB) {
              return -1;
            }
            if (nameA > nameB) {
              return 1;
            }
            return 0; // Names are equal
          });

        $.each(users, function(index, user) {
            $('#memberform form div:last #member-select').append($('<option>', {
                value: user.id,
                text: user.name
            }));
        });
        $('#addmember').hide();
      });
    
      $(document).on('change', '.member-select', function() {
       
        var selectedMember = $(this).find(':selected');
        var memberId = selectedMember.val();
        let index = users.findIndex(user => user.id === parseInt(memberId));
        users.splice(index, 1);
        $(this).prop('disabled', true);
        $(this).after('<button type="button" class="edit-member btn btn-success col-2 m-1 float-end" id="editmember">Edit</button>');
        $('#form2 div .edit-member').show();
        $('#addmember').show();
       
        if (jQuery.isEmptyObject(users)){
            $('#addmember').hide();
        }
        $(this).parent().removeClass('bg-info');
        
    });
   

      $(document).on('click', '.edit-member', function() {
        if (!$('#memberform form div:last #member-select').val() && $('#memberform form div').length > 1){
            $('#memberform form div:last').remove();
        }

        var prevSelect = $(this).prev('select');

       
    
        var prevValue = parseInt(prevSelect.val());
        var prevText = prevSelect.find(':selected').text();
        
        let newUser = { id: prevValue, name: prevText };
        users.push(newUser);

        prevSelect.find('option:not(:first)').remove();
        $('#mySelect option[value="optionValue"]').prop('selected', true);
        prevSelect.find('option:first').prop('selected', true);

        prevSelect.parent().addClass('bg-info');
      
        prevSelect.prop('disabled', false);
        users.sort(function(a, b) {
            var nameA = a.name.toUpperCase(); // Convert name to uppercase to compare
            var nameB = b.name.toUpperCase(); // Convert name to uppercase to compare
            if (nameA < nameB) {
              return -1;
            }
            if (nameA > nameB) {
              return 1;
            }
            return 0; // Names are equal
          });
        $.each(users, function(index, user) {
            $(prevSelect).append($('<option>', {
                value: user.id,
                text: user.name
            }));
        });

      
        $(this).remove();
        $('#form2 div .edit-member').hide();
     
    });

    $('#memberform form').on('click', '.remove-member', function() {
        var prevSelect = $(this).parent().find('select');
        if (prevSelect.val() != null){
        var prevValue = parseInt(prevSelect.val());
        
        var prevText = prevSelect.find(':selected').text();
        
        let newUser = { id: prevValue, name: prevText };
        users.push(newUser);
       
        
        }
        if (Object.keys(users).length > 0) {
            $('#addmember').show();
          }
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