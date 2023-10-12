$(document).ready(function(){

    

    $(document).on('change', '#outputtype-select', function(event) {
        var selectedOutputType = $(this).val();

        $('.addmoreoutput-btn').removeClass("d-none");
        // Remove existing elements except the first one
        $('#outputform .outputnamediv:not(:first)').remove();
        $('#outputform .outputinputdiv:not(:first)').remove();
        $('.outputnamediv:first').removeClass('d-none');
        $('.outputinputdiv:first').addClass('d-none');
        if (selectedOutputType === "Capacity Building") {
            var divtoadd = `<div class="row divhover pt-2 pb-1 ps-1 outputnamediv">
        
        <div class="col-9">
            <h6>Number of Training</h6>
        </div>
        <div class="col-3">
            <input type="number" class="shadow numberInput" id="outputneeded" name="outputneeded[]" pattern="\d{5}" title="Please enter exactly 5 digits" maxlength="5" value="0">
        </div>
    </div>
    <div class="row divhover p-2 mt-1 ps-1 outputinputdiv d-none">
        <div class="col-9">
            <input type="text" class="form-control w-100" name="newoutput[]" id="output-input">
        </div>
        <div class="col-3">
            <button type="button" class="btn btn-danger btn-sm removeoutput-btn">Remove</button>
        </div>
    </div>`;

            $('.outputnamediv:first h6').text("Number of trainees");
            $('#outputform').append(divtoadd);
        } else if (selectedOutputType === "IEC Material") {
            var divtoadd = `<div class="row divhover pt-2 pb-1 ps-1 outputnamediv">
        <div class="col-9">
            <h6>Number of IEC Material</h6>
        </div>
        <div class="col-3">
            <input type="number" class="shadow numberInput" id="outputneeded" name="outputneeded[]" pattern="\d{5}" title="Please enter exactly 5 digits" maxlength="5" value="0">
        </div>
         
    </div>
    <div class="row divhover p-2 mt-1 ps-1 outputinputdiv d-none">
        <div class="col-9">
            <input type="text" class="form-control w-100" name="newoutput[]" id="output-input">
        </div>
        <div class="col-3">
            <button type="button" class="btn btn-danger btn-sm" id="removeoutput-btn">Remove</button>
        </div>
    </div>`;

            $('.outputnamediv:first h6').text("Number of Recipients");
            $('#outputform').append(divtoadd);
        } else if (selectedOutputType === "Advisory Services") {
            $('.outputnamediv:first h6').text("Number of Recipients");
        } else if (selectedOutputType === "Others") {
            $('.outputnamediv:first h6').text("Untitled Output");
        }

        $('.outputinputdiv input').each(function() {
            var input = $(this);
            var parentDiv = input.closest('.outputinputdiv');
            var value = parentDiv.prev().find("h6").text();
            input.val(value);
        });
    });

    
    $(document).on('click', '.outputnamediv', function() {
        if (event.target.id === 'outputneeded') {
            return; // Skip the handling for the input field
        }
        $(this).addClass("d-none");
        //$(this).next().find("input").val($(this).find("h6").text());
        $(this).next().removeClass("d-none");
        $(this).next().find("input").focus();
    });

    $(document).on('click', '.removeoutput-btn', function() {
        var parentElement = $(this).parent().parent();
        parentElement.prev().remove();
        parentElement.remove();
    });

    $('.addmoreoutput-btn').click(function(event) {
        event.preventDefault();

        var divtoadd = `<div class="row divhover pt-2 pb-1 ps-1 outputnamediv">
        <div class="col-9">
        <h6>Untitled Output</h6>
    </div>
    <div class="col-3">
        <input type="number" class="shadow numberInput" id="outputneeded" name="outputneeded[]" pattern="\d{5}" title="Please enter exactly 5 digits" maxlength="5" value="0">
    </div>
</div>
<div class="row divhover p-2 mt-1 ps-1 outputinputdiv d-none">
  <div class="col-9">
    <input type="text" class="form-control w-100" name="newoutput[]" id="output-input">
  </div>
  <div class="col-3">
    <button type="button" class="btn btn-danger btn-sm" id="removeoutput-btn">Remove</button>
  </div>
</div>`;

        $('#outputform').append(divtoadd);
        $('#outputform').find('.outputnamediv:last').next('.outputinputdiv').find('input').val($('.outputnamediv:last h6').text());
    });

    $(document).on('keydown', '.outputinputdiv input', function(event) {
        if (event.which === 13) {
            event.preventDefault();
            var $outputDiv = $(this).closest('.outputinputdiv').prev();
            $outputDiv.find("h6").text($(this).val());
            $outputDiv.removeClass("d-none");
            $(this).closest('.outputinputdiv').addClass("d-none");
        }
    });
    $(document).on('focus', '.outputinputdiv input', function(event) {
        var isClicked = false;

        $(document).on('click', function() {
            isClicked = true;
        });

        $(this).on('blur', function() {
            if (!isClicked) {
                event.preventDefault();
                if ($(this).val() === "") {
                    $(this).val("Untitled Output");
                }
                var $outputDiv = $(this).closest('.outputinputdiv').prev();
                $outputDiv.find("h6").text($(this).val());
                $outputDiv.removeClass("d-none");
                $(this).closest('.outputinputdiv').addClass("d-none");
            }
        });
    });
    $(document).on('click select', '.outputinputdiv input', function(event) {
        $(this).focus();
    });

    

    $('.addsubtask-btn').click(function(event) {
        event.preventDefault();
        $('#subtask-modal').modal('show');
    });

    $('.addassignees-btn').click(function(event) {
        event.preventDefault();
        $('#addAssigneeModal').modal('show');
    });
    $('.addoutput-btn').click(function(event) {
        event.preventDefault();
        $('#addoutputmodal').modal('show');
    });

    function subtaskhasError() {

        var hasErrors = false;

        $('.invalid-feedback strong').text('');
        $('.is-invalid').removeClass('is-invalid');

        var subtaskname = $('#subtaskname').val();
        var subtaskduedate = $('#subtaskduedate').val();
        var actsavestartdate = $('#actsavestartdate').val();
        var actsaveenddate = $('#actsaveenddate').val();


        // Validation for Project Title
        if (subtaskname.trim() === '') {
            $('#subtaskname').addClass('is-invalid');
            $('#subtaskname').next('.invalid-feedback').find('strong').text('Activity Name is required.');
            hasErrors = true;
        }

        if (subtaskduedate === '') {
            $('#subtaskduedate').addClass('is-invalid');
            $('#subtaskduedate').next('.invalid-feedback').find('strong').text('Subtask Due Date is required.');
            hasErrors = true;
        }
        // Validation for Project Start Date
        else if (new Date(actsavestartdate) > new Date(subtaskduedate) || new Date(actsaveenddate) < new Date(subtaskduedate)) {
            $('#subtaskduedate').addClass('is-invalid');
            $('#subtaskduedate').next('.invalid-feedback').find('strong').text('Please ensure that the Subtask Due Date falls within the range of ' + new Date(actsavestartdate).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            }) + ' to '
            + new Date(actsaveenddate).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            }));
            hasErrors = true;
        }
        
        return hasErrors;
    }


    $('#createsubtask-btn').click(function(event) {
        event.preventDefault();


        var suberror = subtaskhasError();

        if (!suberror){
        var url = $('#subtaskurl').val();
       
        url = url.replace(':subtaskname', $('#subtaskname').val());

        var dataurl = $('#subtaskform').attr('data-url');
        var data1 = $('#subtaskform').serialize();


        // send data via AJAX
        $.ajax({
            url: dataurl,
            type: 'POST',
            data: data1,
            success: function(response) {
                url = url.replace(':subtaskid', response.lastsubtaskid);
                window.location.href = url;


            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                console.error(error);

            }
        });
        }
    });
    $('#addassignee-btn').click(function(event) {

        event.preventDefault();


        var dataurl = $('#assigneeform').attr('data-url');
        var data1 = $('#assigneeform').serialize();


        // send data via AJAX
        $.ajax({
            url: dataurl,
            type: 'POST',
            data: data1,
            success: function(response) {
                console.log(response);
                window.location.href = url;

            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                console.error(error);

            }
        });

    });

    $('#createoutput-btn').click((event) => {
        event.preventDefault();


        var outputindex = $('input[name="newoutput[]"]').length;

        // Iterate over each select element and set its name attribute



        $('input[name="newoutput[]"]').each(function(index) {
            $(this).attr('name', 'newoutput[' + index + ']');
        });

        $('#outputindex').val(outputindex);

        var dataurl = $('#outputform').attr('data-url');
        var data1 = $('#outputform').serialize();

        // send data via AJAX
        $.ajax({
            url: dataurl,
            type: 'POST',
            data: data1,
            success: function(response) {
                console.log(response);
                window.location.href = url;

            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                console.error(error);

            }
        });

    });
    /*
    $('#unassignassignee-btn').click(function(event) {
        event.preventDefault();

        $('#unassignassigneeid').val(unassignassigneeid);
        var dataurl = $('#unassignassigneeform').attr('data-url');
        var data = $('#unassignassigneeform').serialize();

        $.ajax({
            url: dataurl,
            type: 'POST',
            data: data,
            success: function(response) {
                console.log(response);
                window.location.href = url;
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                console.error(error);
            }
        });
    });
    */

});