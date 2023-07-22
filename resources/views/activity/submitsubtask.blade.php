@extends('layouts.app')

@section('content')
<div class="maincontainer">
    <div class="mainnav mb-2">
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="projectdiv" data-value="{{ $projectId }}">
            <h6><b>Project: {{ $projectName }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="activitydiv">
            <input type="number" class="d-none" id="actid" value="{{ $activity['id'] }}">
            <h6><b>Activity: {{ $activity['actname'] }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center position-triangle">
            <h6><b>Subtask <span class="small">>></span> {{ $subtask['subtask_name'] }}</b></h6>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-1">


            </div>
            <div class="col-10">
                <form id="addtosubtaskform" data-url="{{ route('addto.subtask') }}">
                    <div class="basiccont p-2">
                        <div class="border-bottom ps-1 mb-2">
                            <h6 class="small"><b>Hours rendered </b></h6>
                        </div>

                        @csrf

                        <input type="number" class="d-none" id="contributornumber" name="contributornumber">
                        <input type="number" class="d-none" id="subtask-contributor-0" name="subtask-contributor[0]">

                        <div class="mb-3">
                            <label class="form-label">Hours rendered</label>
                            <input type="number" class="d-none" id="subtask-id" name="subtask-id" value="{{ $subtask['id'] }}">
                            <input type="number" class="form-control" id="hours-rendered" name="hours-rendered" placeholder="Enter hours rendered" min="0" step="1">
                        </div>


                    </div>
                    <div class="basiccont p-2">
                        <div class="border-bottom ps-1">
                            <h6 class="fw-bold small">Contributor</h6>
                        </div>
                        <div class="row p-1 contributor-name">

                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="addcontributor-btn">Add Contributor</button>
                    </div>
                    <div class="basiccont p-2">
                        <div class="border-bottom ps-1 mb-2">
                            <h6 class="fw-bold small">Supporting documents</h6>
                        </div>

                        <label class="form-label" for="customFile">Submit Subtask Report:</label>

                        <input type="file" class="form-control" id="customFile" accept=".docx" name="subtaskdocs">


                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-outline-primary mt-2" id="submitreport-btn">Submit Report</button>
                        </div>
                </form>
            </div>
            <div class="col-1">

            </div>
        </div>


    </div>

</div>

<div class="modal fade" id="contributorModal" tabindex="-1" aria-labelledby="contributorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contributorModalLabel">Add Contributor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="contributorSelect" class="form-label">Contributor for the task</label>
                    <select class="form-select" id="contributorselect" name="contributorname" required>
                        <option value="" selected disabled>Select Contributor</option>

                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="addcontributor-confirm">Confirm</button>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')

<script>
    var currentassignees = <?php echo json_encode($currentassignees);
                            ?>;
    var contributorindex = 0;
    var url = "";
    $(document).ready(function() {
        $('#addcontributor-btn').click(function() {
            event.preventDefault();
            $('#contributorselect').find("option:not(:first-child)").remove();
            $.each(currentassignees, function(index, item) {

                $('#contributorselect').append($('<option>', {
                    value: item.id,
                    text: item.name + ' ' + item.last_name,
                }));

            });
            $('#contributorselect').val($('#contributorselect').find("option:first").val());
            $('#contributorModal').modal('show');
        });

        $('#addcontributor-confirm').click(function(event) {
            event.preventDefault();
            var contributorname = $('#contributorselect option:selected').text();
            var contributordiv = `<div class="col-6 divhover p-2">
                            ${contributorname}
                            <button type="button" class="btn btn-outline-danger btn-sm float-end"> x </button>
                        </div>`

            $('.contributor-name').append(contributordiv);

            var contributorid = parseInt($('#contributorselect').val());

            if (contributorindex === 0) {
                $(`#subtask-contributor-${contributorindex}`).val(contributorid);

            } else {
                var subtaskcontributordiv = `<input type="number" class="d-none" id="subtask-contributor-${contributorindex}" name="subtask-contributor[${contributorindex}]">`;
                $('#addtosubtaskform').append(subtaskcontributordiv);
                $(`#subtask-contributor-${contributorindex}`).val(contributorid);

            }


            contributorindex++;

            currentassignees = currentassignees.filter(function(assignee) {
                return assignee.id !== parseInt($('#contributorselect').val());
            });
            $('#contributorModal').modal('hide');
        });

        $('#submitreport-btn').click(function(event) {
            event.preventDefault();


            $("#contributornumber").val($('input[name^="subtask-contributor["][name$="]"]').length);

            var dataurl = $('#addtosubtaskform').attr('data-url');
            var formData = new FormData($("#addtosubtaskform")[0]);
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