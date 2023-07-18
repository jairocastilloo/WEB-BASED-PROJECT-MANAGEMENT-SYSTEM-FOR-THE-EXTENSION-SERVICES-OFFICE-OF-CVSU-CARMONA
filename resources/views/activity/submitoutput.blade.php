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
                <div class="basiccont p-2">
                    <div class="border-bottom ps-1 mb-2">
                        <h6 class="small"><b>Output to be Submitted - </b>{{ $outputtype }}</h6>
                    </div>
                    @foreach ($currentoutputtype as $currentoutput)
                    <div class="mb-3">
                        <label class="form-label">{{ $currentoutput['output_name'] }}:</label>
                        <input type="number" class="form-control" id="hours-rendered-input" placeholder="Enter the quantity" min="0" step="1">
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
                    <input type="file" class="form-control" id="customFile" accept=".docx" />
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-outline-primary mt-2" id="submitreport-btn">Submit Report</button>
                    </div>
                </div>
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
            console.log(assignees);
            assignees = assignees.filter(function(assignee) {
                return assignee.id !== assigneeid;
            });




            $('#addFacilitatorModal').modal('hide');
        });
    });
</script>
@endsection