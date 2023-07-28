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
            <h6><b>Output: {{ $outputtype }} </b></h6>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="basiccont p-2" data-value="{{ $outputtype }}">
                    <div class="border-bottom ps-1">
                        <h6 class="fw-bold small">Output Submitted</h6>
                    </div>
                    <h5>{{ $outputtype }}</h5>
                    @foreach ($currentoutputtype as $currentoutput)
                    {{ $currentoutput['output_name'] . ': ' . $currentoutput['totaloutput_submitted' ]}}</br>
                    @endforeach
                    @if( Auth::user()-> role === "Admin")
                    <button type="button" class="btn btn-outline-secondary" id="editoutput-btn">Edit</button>
                    @endif
                    <button type="button" class="btn btn-outline-secondary" id="submitoutput-btn">Submit Output</button>
                </div>

                <div class="basiccont p-2">
                    <div class="border-bottom ps-1">
                        <h6 class="fw-bold small">Unevaluated Output</h6>
                    </div>
                    <ul class="list-unstyled small">
                        @foreach ($unique_outputcreated as $outputcreated)

                        <li>
                            @foreach($unapprovedoutputdata as $unapprovedoutput)
                            @if ($outputcreated == $unapprovedoutput['created_at'])
                            @php
                            $output = \App\Models\Output::find($unapprovedoutput['output_id']);
                            @endphp
                            @if ($output)
                            <b>{{ $output->output_name  }}:</b>
                            @endif
                            {{ $unapprovedoutput['output_submitted']  }}<br>
                            @endif
                            @endforeach



                            Facilitator:
                            @foreach($usersWithSameCreatedAt as $usersame)
                            @if ($usersame['created_at'] == $outputcreated)
                            @php
                            $userIds = explode(',', $usersame->user_ids);
                            @endphp
                            @foreach ($userIds as $userId)
                            @php
                            $user = \App\Models\User::find($userId);
                            @endphp
                            @if ($user)
                            {{ $user->name . ' ' . $user->last_name}}
                            @if (!$loop->last) {{-- Check if it's not the last user in the loop --}}
                            {{ ' | ' }}
                            @endif
                            @endif

                            @endforeach



                            @endif
                            @endforeach

                            <form id="acceptoutputform" data-url="{{ route('output.accept') }}">
                                @csrf

                                <input type="text" value="{{ $outputcreated }}" name="acceptids" id="acceptids">
                                <button type="button" class="btn btn-sm btn-outline-success acceptoutput-btn">Accept</button>
                            </form>
                        </li>
                        <hr>
                        @endforeach




                    </ul>

                </div>

            </div>
            <div class="col-4">
                <div class="basiccont">
                    <div class="border-bottom ps-2 pt-2">
                        <h6 class="fw-bold small">Other Outputs</h6>
                    </div>

                    @foreach ($alloutputtypes as $index => $alloutputtype)
                    @if ($index % 2 == 0)
                    <div class="sidecont1 divhover selectoutputdiv p-2" data-value="{{ $alloutputtype }}">{{ $alloutputtype }}</div>
                    @else
                    <div class="sidecont2 divhover selectoutputdiv p-2" data-value="{{ $alloutputtype }}">{{ $alloutputtype }}</div>
                    @endif
                    @endforeach


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

        $('#projectdiv').click(function(event) {
            event.preventDefault();
            var projectid = $(this).attr('data-value');

            url = '{{ route("get.objectives", ["id" => Auth::user()->id, "projectid" => ":projectid"]) }}';
            url = url.replace(':projectid', projectid);
            window.location.href = url;
        });

        $(document).on('click', '.selectoutputdiv', function() {
            var outputtype = $(this).attr('data-value');
            var actid = $('#actid').val();

            var url = '{{ route("get.output", ["id" => Auth::user()->id, "activityid" => ":activityid", "outputtype" => ":outputtype"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':outputtype', outputtype);
            window.location.href = url;
        });
        $('#submitoutput-btn').click(function(event) {
            event.preventDefault();
            var outputtype = $(this).parent().attr('data-value');
            var actid = $('#actid').val();

            var url = '{{ route("comply.output", ["id" => Auth::user()->id, "activityid" => ":activityid", "outputtype" => ":outputtype"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':outputtype', outputtype);
            window.location.href = url;
        });
        $('#activitydiv').click(function(event) {

            event.preventDefault();

            var activityid = $('#actid').val();

            var url = '{{ route("get.activity", ["id" => Auth::user()->id, "activityid" => ":activityid"]) }}';
            url = url.replace(':activityid', activityid);
            window.location.href = url;
        });
        $(document).on('click', '.acceptoutput-btn', function() {
            var acceptIdsValue = $(this).prev().val();
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