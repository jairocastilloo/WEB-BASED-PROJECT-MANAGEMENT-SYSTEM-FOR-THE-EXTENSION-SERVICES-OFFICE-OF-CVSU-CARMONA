

$(document).ready(function() {


  
    var currentstep = 0;
    var setcount = 0;

    $('#addmember').hide();

    $('.noselectmember-error strong').hide();
    $('.nomember-error strong').hide();

    $('#navbarDropdown').click(function() {
      // Add your function here
      $('#account .dropdown-menu').toggleClass('shows');
  });

  $(document).on('input', '.autocapital', function() {
    var inputValue = $(this).val();
    if (inputValue.length > 0) {
        $(this).val(inputValue.charAt(0).toUpperCase() + inputValue.slice(1));
    }
});


  users.sort(function(a, b) {
    var lastNameA = a.last_name.toUpperCase();
    var lastNameB = b.last_name.toUpperCase();
    if (lastNameA < lastNameB) {
      return -1;
    }
    if (lastNameA > lastNameB) {
      return 1;
    }
    return 0;
  });

  // Populate the select options
var select = $("#projectleader");

$.each(users, function(index, user) {
  if (user.middle_name) {
    user.middle_name = user.middle_name.charAt(0).toUpperCase() + '.';
  }
  var optionText = user.last_name + ', ' + user.name + ' ' + (user.middle_name || '');
  var optionValue = user.id;
  var option = $('<option>').text(optionText).val(optionValue);
  select.append(option);
});

// CREATE PROJECT
var select1 = $("#member-select");
var select2 = $("#programleader");
$.each(users, function(index, user) {
  if (user.middle_name) {
    user.middle_name = user.middle_name.charAt(0).toUpperCase() + '.';
  }
  var optionText = user.last_name + ', ' + user.name + ' ' + (user.middle_name || '');
  var optionValue = user.id;
  var option = $('<option>').text(optionText).val(optionValue);
  select1.append(option);
  
});

$.each(users, function(index, user) {
  if (user.middle_name) {
    user.middle_name = user.middle_name.charAt(0).toUpperCase() + '.';
  }
  var optionText = user.last_name + ', ' + user.name + ' ' + (user.middle_name || '');
  var optionValue = user.id;
  var option = $('<option>').text(optionText).val(optionValue);
  select2.append(option);
  
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
      
   
      var hasError = handleError();

      if (!hasError) {
        currentstep++;
        updateButtons();
          } 
      

    });
    $('#prevproject').click((event) => {

      event.preventDefault();

      
        currentstep--;
        updateButtons();
          
      
    });

    $('#addproj').click((event) => {

      event.preventDefault();
      
      updateButtons();
      $('#newproject').modal('show');
    });
    /*
    $('#tab1-tab').click((event) => {

      event.preventDefault();
      currentstep = 0;

      updateButtons();
    });
    $('#tab2-tab').click((event) => {

      event.preventDefault();
      currentstep = 1;
    
      updateButtons();
    });
    $('#tab3-tab').click((event) => {

      event.preventDefault();
      
      currentstep = 2;
      updateButtons();
        
    });
*/
    function handleError(){

        if(currentstep === 0){

          var hasErrors = false;

          $('.invalid-feedback strong').text('');
          $('.is-invalid').removeClass('is-invalid');
  
          var projectTitle = $('#projecttitle').val();

          var selectprojlead = $('#projectleader').find(':selected');
          var projectLeader = selectprojlead.val();
          var programTitle = $('#programtitle').val();

          var selectproglead = $('#programleader').find(':selected');
          var programLeader = selectproglead.val();

          var projectStartDate = new Date($('#projectstartdate').val());
          var projectEndDate = new Date($('#projectenddate').val());
  
          var targetYear = parseInt($('#currentyear').val(), 10);

          // Validation for Project Title
          if (projectTitle.trim() === '') {
              $('#projecttitle').addClass('is-invalid');
              $('#projecttitle').next('.invalid-feedback').find('strong').text('Project Title is required.');
              hasErrors = true;
            }
  
          // Validation for Project Leader
          if (projectLeader == 0) {
              $('#projectleader').addClass('is-invalid');
              $('#projectleader').next('.invalid-feedback').find('strong').text('Project Leader is required.');
              hasErrors = true;
            }
  
          // Validation for Program Title
          if (programTitle.trim() === '') {
              $('#programtitle').addClass('is-invalid');
              $('#programtitle').next('.invalid-feedback').find('strong').text('Program Title is required.');
              hasErrors = true;
            }
  
          // Validation for Program Leader
          if (programLeader == 0) {
              $('#programleader').addClass('is-invalid');
              $('#programleader').next('.invalid-feedback').find('strong').text('Program Leader is required.');
              hasErrors = true;
            }
  
          // Validation for Project Start Date
          if (projectStartDate.getFullYear() !== targetYear) {
              $('#projectstartdate').addClass('is-invalid');
              $('#projectstartdate').next('.invalid-feedback').find('strong').text('Project Start Date must be in ' + targetYear + '.');
              hasErrors = true;
            }
  
          // Validation for Project End Date
          if (projectEndDate.getFullYear() !== targetYear || projectEndDate <= projectStartDate) {
              $('#projectenddate').addClass('is-invalid');
              $('#projectenddate').next('.invalid-feedback').find('strong').text('Project End Date must be in ' + targetYear + ' and after the Start Date.');
              hasErrors = true;
            }

            return hasErrors;
    
        } else if(currentstep === 1){

          var hasErrors = false;

          $('.noselectmember-error strong').hide();
          $('.nomember-error strong').hide();

          var memberindex = $('select[name="projectmember[]"]').length;
          
          if (memberindex == 0) {
           $('.nomember-error strong').show();
            hasErrors = true;
          }

          $('select[name="projectmember[]"]').each(function(index, element) {
            var selectedValue = $(element).find(':selected');
            if (selectedValue.val() == 0) {
                $('.noselectmember-error strong').show();
                hasErrors = true;
            }
  
            
          });
          
          return hasErrors;
        }

        else if(currentstep === 2){


        }
        
    }

      
    $('#objectiveset').on('click', '.add-objective', function() {
      var setid = $(this).prev().find('div:first .objectivesetid').val();
       
        var $newInput = $('<input type="text" class="col-8 m-1 input-objective autocapital p-2 rounded" id="objective-input" name="projectobjective[]" placeholder="Enter objective">');
        var $newInput1 = $('<input type="number" id="objectivesetid" name="objectivesetid[]" value="' + setid + '" class="objectivesetid d-none">');
       
        var $newButton2 = $('<button type="button" class="remove-objective btn btn-sm btn-outline-danger col-3 m-1" id="removeobjective"><b class="small">Remove</b></button>');
        var $newDiv = $('<div class="mb-2 row" id="selectobjectives">').append($newInput, $newInput1, $newButton2);
        $(this).prev().append($newDiv);
        
  });
    $('#objform form').on('click', '.remove-objective', function() {
        $(this).parent().remove();
    });
    $('#objform form').on('click', '.edit-objective', function() {
        $(this).prev().focus();
    });
    $('#objform form').on('keydown', '.input-objective', function() {
        if (event.keyCode === 13) { 
          event.preventDefault(); 
          
          $(this).blur();
         
        }
    });



    $('#addset').click((event) => {
      event.preventDefault();
      setcount++;
      var $newInput = $('<input type="text" class="col-8 m-1 input-objective p-2 rounded autocapital" id="objective-input" name="projectobjective[]" placeholder="Enter objective">');
      var $newInput1 = $('<input type="number" id="objectivesetid" name="objectivesetid[]" value="' + setcount + '" class="objectivesetid d-none">');
        var $newButton2 = $('<button type="button" class="remove-objective btn btn-sm btn-outline-danger col-3 m-1" id="removeobjective"><b class="small">Remove</b></button>');
        var $newDiv = $('<div class="mb-2 row" id="selectobjectives">').append($newInput, $newInput1, $newButton2);
        var $newDiv1 = $('<div>').append($newDiv);
        var $newButton3 = $('<button type="button" class="add-objective btn btn-sm btn-outline-success" id="addobjective"><b class="small">Add Objective</b></button><hr>');
        $('#objectiveset').append($newDiv1, $newButton3);
        
  });


    $('#createproject').click((event) => {
        event.preventDefault();
       
       
        var department = $('#department').val();
        var projectname = $('#projecttitle').val();
    
        var projecturl = $('#projecturl').attr('data-url');
        
        projecturl = projecturl.replace(':department', department);
        projecturl = projecturl.replace(':projectname', projectname);


        var memberindex = $('select[name="projectmember[]"]').length;
        var objectiveindex = $('input[name="projectobjective[]"]').length;

// Iterate over each select element and set its name attribute
        $('input[name="projectobjective[]"]').each(function(index) {
        $(this).attr('name', 'projectobjective[' + index + ']');
       
        });
        $('input[name="objectivesetid[]"]').each(function(index) {
          $(this).attr('name', 'objectivesetid[' + index + ']');
     
          });
          $('select[name="projectmember[]"]').each(function(index) {
            
            $(this).attr('name', 'projectmember[' + index + ']');
          });
        
        
        $('#objectiveindex').val(objectiveindex);
        $('#memberindex').val(memberindex);
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
          if (response.errors) {
            $.each(response.errors, function (field, errors) {
                var input = $('#' + field);
                input.addClass('is-invalid');
                input.closest('.mb-3').find('.invalid-feedback strong').text(errors.join(' '));
            });
        } else {
          console.log(response);
          var projectId = response.projectid;
          projecturl = projecturl.replace(':projectid', projectId);
          window.location.href = projecturl;
        }
            
            
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            console.log(status);
            console.log(error);
        }
        });
        
    });
    

    
    


    $('#addmember').click((event) => {
        event.preventDefault();
        var $newSelect = $(`<select class="member-select col-7 m-1 p-2 rounded" id="member-select" name="projectmember[]"><option value="0" selected disabled>Select a Member</option></select>`);
        var $newButton = $('<button type="button" class="remove-member btn btn-sm btn-outline-danger col-2 m-1 float-end" id="removemember"><b class="small">Remove</b></button>');
        var $newDiv = $('<div class="mb-2 row bg-info rounded" id="selectmember">').append($newSelect, $newButton);
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
        if (user.middle_name) {
          user.middle_name = user.middle_name.charAt(0).toUpperCase() + '.';
        }
          if (user.last_name){
            $('#memberform form div:last #member-select').append($('<option>', {
                value: user.id,
                text: user.last_name + ', ' + user.name + ' ' + user.middle_name
            }));
          }  else {
            $('#memberform form div:last #member-select').append($('<option>', {
              value: user.id,
              text: user.name
          }));

          }
          
        });
        
        $('#form2 div .edit-member').hide();
        $('#addmember').hide();
      });
    
      $(document).on('change', '.member-select', function() {
       
        var selectedMember = $(this).find(':selected');
        var memberId = selectedMember.val();
        let index = users.findIndex(user => user.id === parseInt(memberId));
        users.splice(index, 1);
        $(this).prop('disabled', true);
        $(this).after('<button type="button" class="edit-member btn btn-sm btn-outline-success col-2 m-1 float-end" id="editmember"><b class="small">Edit</b></button>');
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
          if (user.last_name){
            $(prevSelect).append($('<option>', {
                
                  value: user.id,
                  text: user.name + ' ' + user.last_name,
                
            }));
          } else {
            $(prevSelect).append($('<option>', {
                
              value: user.id,
              text: user.name,
            
        }));

          }
        });
      
        $(this).remove();
        $('#form2 div .edit-member').hide();
        $('#addmember').hide();
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

    


});