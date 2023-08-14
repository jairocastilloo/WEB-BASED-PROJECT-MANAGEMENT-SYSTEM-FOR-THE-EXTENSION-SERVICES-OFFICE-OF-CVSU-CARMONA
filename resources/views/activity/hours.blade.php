@extends('layouts.app')

@section('content')

<div class="maincontainer">
    <div class="mainnav mb-2 shadow">
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="projectdiv" data-value="{{ $projectId }}" data-name="{{ $projectName }}">
            <input class="d-none" type="text" id="department" value="{{ Auth::user()->department }}">
            <h6><b>Project: {{ $projectName }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="activitydiv" data-name="{{ $activity['actname'] }}" data-value="{{ $activity['id'] }}">
            <h6><b>Activity: {{ $activity['actname'] }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center position-triangle">
            <h6><b>Participation Hours </b></h6>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="basiccont word-wrap shadow ms-2 mt-4">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Participation Hours</h6>
                    </div>

                    <div class="p-2 pb-0 ps-5 border-bottom">
                        <p class="lh-1">Activity Name: {{ $activity->actname }}</p>
                        <p class="lh-1">Activity Date: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $activity->actstartdate)->format('F d') . ' to ' . \Carbon\Carbon::createFromFormat('Y-m-d', $activity->actenddate)->format('F d') }}</p>
                        <p class="lh-1">Hours Rendered: {{ $activity->totalhours_rendered }}</p>
                    </div>

                    <div class="btn-group ms-3 mb-3 mt-2 shadow">
                        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow submithours-btn">
                            <b class="small">Submit Hours</b>
                        </button>
                    </div>

                </div>
            </div>
            <div class="col-4">
                <div class="basiccont word-wrap shadow me-2 mt-4">
                    @if($unapprovedhours)
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Unevaluated Hours</h6>
                    </div>
                    <div class="p-2 ps-4 pb-0 border-bottom">

                        <p class="lh-1"> Hours Rendered: {{ $unapprovedhours->hours_rendered }}</p>
                        <p class="lh-1"> Date: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $unapprovedhours->startdate)->format('F d') . ' to ' 
                            . \Carbon\Carbon::createFromFormat('Y-m-d', $unapprovedhours->enddate)->format('F d') 
                            . ', ' . \Carbon\Carbon::createFromFormat('Y-m-d', $unapprovedhours->enddate)->format('Y')}}</p>
                        <p class="lh-1">Participants:
                            @foreach($contributors as $contributor)
                            {{ $contributor->name . ' ' . $contributor->last_name . ' | ' }}
                            @endforeach
                        </p>

                    </div>
                    <div class="btn-group ms-3 mb-3 mt-2 shadow">
                        <form id="acceptacthoursform" data-url="{{ route('acthours.accept') }}">
                            @csrf
                            <input type="text" class="d-none" value="{{ $unapprovedhours->id }}" name="acceptids" id="acceptids">
                            <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow acceptacthours-btn">
                                <b class="small">Accept</b>
                            </button>
                        </form>

                    </div>
                    @elseif($approvedhours)
                    <div class="border-bottom ps-3 pt-2 pe-2" style="background-color:lightgray;">
                        <h6 class="fw-bold small" style="color:darkgreen;">Approved Hours</h6>
                    </div>
                    <div class="p-2 ps-4" style="background-color:lightgray;">

                        <p class="lh-1"> Hours Rendered: {{ $approvedhours->hours_rendered }}</p>
                        <p class="lh-1"> Date: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $approvedhours->startdate)->format('F d') . ' to ' 
                            . \Carbon\Carbon::createFromFormat('Y-m-d', $approvedhours->enddate)->format('F d') 
                            . ', ' . \Carbon\Carbon::createFromFormat('Y-m-d', $approvedhours->enddate)->format('Y')}}</p>
                        <p class="lh-1">Participants:
                            @foreach($contributors as $contributor)
                            {{ $contributor->name . ' ' . $contributor->last_name . ' | ' }}
                            @endforeach
                        </p>
                    </div>
                    @elseif($approvedhours == null && $unapprovedhours == null)
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Submitted Hours</h6>
                    </div>
                    <div class="p-2 ps-4 pb-0 border-bottom">
                        <h5><em>No Submitted Hours Yet.</em></h5>

                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    var url = "";
    $(document).ready(function() {

        $(document).on('click', '.submithours-btn', function() {
            var activityid = $('#activitydiv').attr("data-value");
            var activityname = $('#activitydiv').attr("data-name");
            var department = $('#department').val();

            var url = '{{ route("comply.activity", ["activityid" => ":activityid", "activityname" => ":activityname", "department" => ":department"]) }}';
            url = url.replace(':activityid', activityid);
            url = url.replace(':activityname', activityname);
            url = url.replace(':department', department);

            window.location.href = url;
        });


        $('.acceptacthours-btn').click(function(event) {
            event.preventDefault();
            var dataurl = $(this).parent().attr('data-url');
            // Create a data object with the value you want to send
            var data1 = $(this).parent().serialize();

            $.ajax({
                url: dataurl, // Replace with your actual AJAX endpoint URL
                type: 'POST',
                data: data1,
                success: function(response) {

                    console.log(response);
                    window.location.href = url;
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    console.log(xhr.responseText);
                    console.error(error);
                }
            });
        });
    });
</script>

@endsection