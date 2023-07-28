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
            <h6><b>Output <span class="small">>></span> {{ $outputtype }}</b></h6>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-1">


            </div>
            <div class="col-10">
                <form id="addtooutputform" data-url="{{ route('addto.output') }}">
                    <div class="basiccont p-2">
                        <div class="border-bottom ps-1 mb-2">
                            <h6 class="small"><b>Output to be Submitted - </b>{{ $outputtype }}</h6>
                        </div>

                        @csrf
                        <input type="number" class="d-none" id="outputnumber" name="outputnumber">
                        <input type="number" class="d-none" id="facilitatornumber" name="facilitatornumber">
                        <input type="number" class="d-none" id="output-facilitator-0" name="output-facilitator[0]">
                        @foreach ($currentoutputtype as $currentoutput)
                        <div class="mb-3">
                            <label class="form-label">{{ $currentoutput['output_name'] }}:</label>
                            <input type="number" class="d-none" id="output-id" name="output-id[]" value="{{ $currentoutput['id'] }}">
                            <input type="number" class="form-control" id="output-quantity" name="output-quantity[]" placeholder="Enter the quantity" min="0" step="1">
                        </div>
                        @endforeach

                    </div>
                    <div class="basiccont p-2">
                        <div class="border-bottom ps-1">
                            <h6 class="fw-bold small">Facilitator Involved</h6>
                        </div>
                        <div class="row p-1 assignees-name">

                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="addfacilitator-btn">Add Facilitator</button>
                    </div>
                    <div class="basiccont p-2">
                        <div class="border-bottom ps-1 mb-2">
                            <h6 class="fw-bold small">Supporting documents</h6>
                        </div>

                        <label class="form-label" for="customFile">Submit Activity Report:</label>
                        <!-- <form method="POST" action="{{ route('upload.file') }}" enctype="multipart/form-data" id="addtooutputform2">
                        @csrf-->
                        <input type="file" class="form-control" id="customFile" accept=".docx" name="outputdocs">

                        <!--  <button type="button" class="btn btn-outline-primary mt-2" id="submitreport2">Submit Report</button> -->
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-outline-primary mt-2" id="submitreport-btn" data-value="{{ $outputtype }}">Submit Report</button>
                        </div>
                </form>
            </div>
            <div class="col-1">

            </div>
        </div>

    </div>
</div>




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
@endsection
@section('scripts')
<script>
    var assignees = <?php echo json_encode($assignees);
                    ?>;
    var url = "";
    var assigneeindex = 0;
    $(document).ready(function() {

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

        $('#submitreport-btn').click(function(event) {
            event.preventDefault();
            var outputtype = $(this).attr('data-value');
            var actid = $('#actid').val();

            var url = '{{ route("get.output", ["id" => Auth::user()->id, "activityid" => ":activityid", "outputtype" => ":outputtype"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':outputtype', outputtype);

            $("#outputnumber").val($('input[name="output-quantity[]"]').length);
            $("#facilitatornumber").val($('input[name^="output-facilitator["][name$="]"]').length);
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