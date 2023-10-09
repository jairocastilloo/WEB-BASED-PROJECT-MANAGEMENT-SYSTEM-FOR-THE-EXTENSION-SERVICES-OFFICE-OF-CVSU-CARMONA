@extends('layouts.app')

@section('content')
@php
$department = Auth::user()->department;
@endphp
<div class="maincontainer border border-start border-end border-bottom">
    <div class="mainnav border-bottom mb-3 shadow-sm">
        <div class="step-wrapper divhover" id="projectdiv" data-value="{{ $projectId }}" data-name="{{ $projectName }}">
            <div class="step">
                <span class="fw-bold">Project: {{ $projectName }}</span>
                <div class="message-box text-white">
                    {{ $projectName }}
                </div>
            </div>


        </div>
        <div class="step-wrapper divhover" id="activitydiv" data-value="{{ $activity->id }}" data-name="{{ $activity->actname }}">
            <div class="step">
                <span class="fw-bold">Activity: {{ $activity['actname'] }}</span>
                <div class="message-box text-white">
                    {{ $activity['actname'] }}
                </div>
            </div>


        </div>
        <div class="step-wrapper selectoutputdiv divhover" data-value="{{ $outputtype }}">
            <div class="step">
                <span class="fw-bold">Output: {{ $outputtype }}</span>
                <div class="message-box text-white">
                    {{ $outputtype }}
                </div>
            </div>


        </div>
        <div class="step-wrapper">
            <div class="steps" style="border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                <span class="fw-bold">Submitting {{ $outputtype }} for {{ $activity['actname'] }}</span>
                <div class="message-box">
                    Submitting {{ $outputtype }} for {{ $activity['actname'] }}
                </div>
            </div>


        </div>
    </div>

    <div class="container">

        <form id="addtooutputform" data-url="{{ route('addto.output') }}">
            @csrf
            <div class="basiccont word-wrap shadow pb-2">
                <div class="border-bottom pt-2 ps-4 pe-4">
                    <h6 class="small" style="color:darkgreen;"><b>Output to be Submitted</b>
                        <span class="text-dark">({{ $outputtype }})</span>
                    </h6>


                    <input type="number" class="d-none" id="outputnumber" name="outputnumber">
                    <input type="number" class="d-none" id="facilitatornumber" name="facilitatornumber">
                    <input type="number" class="d-none" id="output-facilitator-0" name="output-facilitator[0]">
                    @foreach ($currentoutputtype as $currentoutput)
                    <div class="mb-2 ms-4 me-4">
                        <label class="form-label">{{ $currentoutput['output_name'] }}:</label>
                        <input type="number" class="d-none" id="output-id" name="output-id[]" value="{{ $currentoutput['id'] }}">
                        <input type="number" class="form-control" id="output-quantity" name="output-quantity[]" placeholder="Enter the quantity" min="0" step="1">
                    </div>
                    @endforeach

                </div>
                <!--
                <div class="border-bottom pt-2 ps-4 pe-4">
                    <h6 class="small" style="color:darkgreen;">
                        <b>Facilitator Involved</b>

                    </h6>
                    <div class="row p-1 assignees-name">

                    </div>
                    <div class="btn-group ms-3 mb-3 shadow">
                        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="addfacilitator-btn">
                            <b class="small">Add Facilitator</b>
                        </button>
                    </div>

                </div> -->
                <div class="border-bottom pt-2 ps-4 pe-4">
                    <h6 class="small" style="color:darkgreen;">
                        <b>Supporting Documents</b>

                    </h6>

                    <div class="ms-4 me-4">
                        <label class="form-label" for="customFile">Submit Activity Report:</label>
                        <!-- <form method="POST" action="{{ route('upload.file') }}" enctype="multipart/form-data" id="addtooutputform2">
                        @csrf-->
                        <input type="file" class="form-control" id="customFile" accept=".docx" name="outputdocs">
                    </div>
                    <!--  <button type="button" class="btn btn-outline-primary mt-2" id="submitreport2">Submit Report</button> -->

                    <div class="d-grid gap-2 p-4">
                        <button type="button" class="btn btn-primary fw-bold" id="submitreport-btn" data-value="{{ $outputtype }}">Submit Report</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!--
<div class="modal fade" id="addFacilitatorModal" tabindex="-1" aria-labelledby="addFacilitatorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFacilitatorModalLabel">Add Facilitator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>

                    <div class="mb-3">
                        <label for="facilitatorName" class="form-label">Facilitator Name</label>
                        <select class="form-select" id="selectfacilitator" required>
                            <option value="" selected disabled>Select Facilitator</option>

                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmfacilitator-btn">Confirm</button>
            </div>
        </div>
    </div>
</div>

-->
@endsection
@section('scripts')
<script>
    var assignees = <?php echo json_encode($assignees);
                    ?>;
    var url = "";
    var assigneeindex = 0;
    const department = "<?php echo $department; ?>";
    $(document).ready(function() {

        $('.step span').each(function() {
            var $span = $(this);
            if ($span.text().length > 16) { // Adjust the character limit as needed
                $span.text($span.text().substring(0, 16) + '...'); // Truncate and add ellipsis
            }
        });
        $('.steps span').each(function() {
            var $span = $(this);
            if ($span.text().length > 16) { // Adjust the character limit as needed
                $span.text($span.text().substring(0, 16) + '...'); // Truncate and add ellipsis
            }
        });

        $('#navbarDropdown').click(function(event) {
            // Add your function here
            event.preventDefault();
            $('#account .dropdown-menu').toggleClass('shows');
        });

        $('#projectdiv').click(function(event) {
            event.preventDefault();
            var projectid = $(this).attr('data-value');
            var projectname = $(this).attr('data-name');



            var url = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department", "projectname" => ":projectname"]) }}';
            url = url.replace(':projectid', projectid);
            url = url.replace(':department', encodeURIComponent(department));
            url = url.replace(':projectname', encodeURIComponent(projectname));
            window.location.href = url;
        });

        $('#activitydiv').click(function(event) {

            event.preventDefault();
            var actid = $(this).attr('data-value');
            var activityname = $(this).attr('data-name');

            var url = '{{ route("activities.display", ["activityid" => ":activityid", "department" => ":department", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':department', department);
            url = url.replace(':activityname', activityname);
            window.location.href = url;
        });
        $(document).on('click', '.selectoutputdiv', function() {
            var outputtype = $(this).attr('data-value');
            var actid = $('#activitydiv').attr('data-value')

            var url = '{{ route("get.output", ["activityid" => ":activityid", "outputtype" => ":outputtype"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':outputtype', outputtype);
            window.location.href = url;
        });
        /** 
        $('#addfacilitator-btn').click(function(event) {
            $('#selectfacilitator').children().not(':first').remove();
            $.each(assignees, function(index, assignee) {
                if (assignee.middle_name != "") {
                    var middleinitial = assignee.middle_name.charAt(0).toUpperCase() + '.';
                    $('#selectfacilitator').append($('<option>', {
                        value: assignee.id,
                        text: assignee.name + ' ' + middleinitial + ' ' + assignee.last_name
                    }));
                } else {

                    $('#selectfacilitator').append($('<option>', {
                        value: assignee.id,
                        text: assignee.name + ' ' + assignee.last_name
                    }));
                }

            });
            $('#selectfacilitator option:first').prop('selected', true);
            $('#addFacilitatorModal').modal('show');
        });

        $('#confirmfacilitator-btn').click(function(event) {
            var assigneeText = $('#selectfacilitator option:selected').text();
            var assigneediv = `<div class="col-6 divhover p-2">
                            ${assigneeText}
                            <button type="button" class="btn btn-outline-danger btn-sm float-end"> x </button>
                        </div>`

            $('.assignees-name').append(assigneediv);


            var assigneeid = parseInt($('#selectfacilitator').val());

            if (assigneeindex === 0) {
                $(`#output-facilitator-${assigneeindex}`).val(assigneeid);

            } else {
                var outputfacilitatordiv = `<input type="number" class="d-none" id="output-facilitator-${assigneeindex}" name="output-facilitator[${assigneeindex}]">`;
                $('#addtooutputform').append(outputfacilitatordiv);
                $(`#output-facilitator-${assigneeindex}`).val(assigneeid);

            }


            assigneeindex++;
            assignees = assignees.filter(function(assignee) {
                return assignee.id !== assigneeid;
            });




            $('#addFacilitatorModal').modal('hide');
        });
*/
        $('#submitreport-btn').click(function(event) {
            event.preventDefault();
            var outputtype = $(this).attr('data-value');
            var actid = $('#actid').val();

            var url = '{{ route("get.output", ["activityid" => ":activityid", "outputtype" => ":outputtype"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':outputtype', outputtype);

            $("#outputnumber").val($('input[name="output-quantity[]"]').length);
            //$("#facilitatornumber").val($('input[name^="output-facilitator["][name$="]"]').length);
            $('input[name="output-id[]"]').each(function(index) {
                $(this).attr('name', 'output-id[' + index + ']');
            });
            $('input[name="output-quantity[]"]').each(function(index) {
                $(this).attr('name', 'output-quantity[' + index + ']');
            });
            var dataurl = $('#addtooutputform').attr('data-url');
            var formData = new FormData($("#addtooutputform")[0]);
            // Serialize the input data
            /**  
             var data1 = $('#addtooutputform').serialize();
             var formData = new FormData($("#myForm")[0]);*/
            // Create FormData object for file data


            // Append file data to the serialized form data


            // Send data via AJAX


            $.ajax({
                url: dataurl,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);

                    window.location.href = url;
                    // Handle the successful response here
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.error(error);
                    // Handle the error here
                }
            });


        });
    });
</script>
@endsection