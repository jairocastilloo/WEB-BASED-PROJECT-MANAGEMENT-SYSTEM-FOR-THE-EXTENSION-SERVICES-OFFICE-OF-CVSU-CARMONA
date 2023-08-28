@extends('layouts.app')

@section('content')
<div class="maincontainer">
    <div class="mainnav mb-2">
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="projectdiv" data-value="{{ $projectId }}" data-name="{{ $projectName }}">
            <input class="d-none" type="text" id="department" value="{{ Auth::user()->department }}">
            <h6><b>Project: {{ $projectName }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="activitydiv" data-name="{{ $activity['actname'] }}">
            <input type="number" class="d-none" id="actid" value="{{ $activity['id'] }}">
            <h6><b>Activity: {{ $activity['actname'] }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center">
            <h6><b>Subtask: {{ $subtask['subtask_name'] }}</b></h6>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="basiccont word-wrap shadow ms-2 mt-4" data-id="{{ $contribution->id }}" data-approval="{{ $contribution->approval }}">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">{{ $nameofsubmission }}</h6>
                    </div>

                    <div class="p-2 pb-1">
                        <p class="ps-4 lh-1 pt-2"><b>Subtask Name: {{ $subtask['subtask_name'] }}</b></p>
                        <p class="lh-1 ps-5"> Submitted Hours Rendered: {{ $contribution->hours_rendered }}</p>
                        <p class="lh-1 ps-5"> Rendered Date: {{ \Carbon\Carbon::parse($contribution->date)->format('F d, Y') }} </p>
                        <p class="lh-1 ps-5"> Submitted in: {{ \Carbon\Carbon::parse($contribution->created_at)->format('F d, Y') }} </p>
                        <div class="card ms-5 m-3">
                            <div class="card-body">
                                <p class="card-title">Submission Attachment</p>

                                <ul class="list-unstyled ms-3">
                                    <button type="button" class="btn btn-sm btn-outline-primary shadow rounded" href="{{ route('download.file', ['contributionid' => $contribution->id, 'filename' => basename($uploadedFiles[0])]) }}">
                                        <b>{{ basename($uploadedFiles[0]) }} </b><strong class="bi bi-download"></strong>
                                    </button>

                                </ul>

                            </div>
                        </div>
                        @if( $contribution['approval'] != 1)
                        <div class="btn-group dropdown ms-3 mb-3 mt-2 shadow">
                            <button type="button" class="btn btn-sm dropdown-toggle shadow rounded border border-1 btn-gold border-warning text-body" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <b class="small">Evaluate Submission</b>
                            </button>
                            <div class="dropdown-menu">
                                <form id="accepthoursform" data-url="{{ route('hours.accept') }}">
                                    @csrf
                                    <input type="text" class="d-none" value="{{ $contribution->id }}" name="acceptids" id="acceptids">
                                    <input type="hidden" name="isApprove" id="isApprove">
                                    <a class="dropdown-item small hrefnav accept-link" href="#"><b class="small">Accept</b></a>
                                    <a class="dropdown-item small hrefnav reject-link" href="#"><b class="small">Reject</b></a>
                                </form>

                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
            <div class="col-4">


            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    $(document).ready(function() {

        $('.accept-link').on('click', function(event) {
            event.preventDefault();
            $('#isApprove').val('true'); // Set the value for "isApprove" input
            submitForm();
        });

        // Event listener for the "Reject" link
        $('.reject-link').on('click', function(event) {
            event.preventDefault();
            $('#isApprove').val('false'); // Set the value for "isApprove" input
            submitForm();
        });

        function submitForm() {
            var formData = $('#accepthoursform').serialize(); // Serialize form data
            var dataurl = $('#accepthoursform').data('url'); // Get the form data-url attribute

            $.ajax({
                type: 'POST',
                url: dataurl,
                data: formData,
                success: function(response) {
                    window.location.href = url;
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error('Error:', error);
                }
            });
        }

    });
</script>
@endsection