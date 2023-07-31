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
                <div class="basiccont word-wrap shadow ms-2 mt-4" data-value="{{ $outputtype }}">
                    <div class="border-bottom ps-3 pt-2">
                        <h6 class="fw-bold small" style="color:darkgreen;">Output Submitted</h6>
                    </div>
                    <div class="p-2">

                        <p class="lh-base fw-bold ps-3">{{ $outputtype }}</p>
                        @foreach ($currentoutputtype as $currentoutput)
                        <p class="lh-1 ps-5">{{ $currentoutput['output_name'] . ': ' . $currentoutput['totaloutput_submitted' ]}}</p>
                        @endforeach
                    </div>

                    <div class="btn-group ms-3 mb-3 shadow">
                        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="editoutput-btn">
                            <b class="small">Edit Output</b>
                        </button>
                    </div>

                    <div class="btn-group ms-3 mb-3 shadow">
                        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="submitoutput-btn">
                            <b class="small">Submit Output</b>
                        </button>
                    </div>

                </div>


                <div class="basiccont word-wrap shadow ms-2 mt-4">
                    <div class="border-bottom ps-3 pt-2">
                        <h6 class="fw-bold small" style="color:darkgreen;">Unevaluated Output</h6>
                    </div>
                    <ul class="list-unstyled small pt-2">
                        @foreach ($unique_outputcreated as $outputcreated)

                        <li class="ps-4 pe-2">
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



                            <b>Facilitator:</b>
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
                            <br>
                            <div class="btn-group mt-2 shadow">
                                <form id="acceptoutputform" data-url="{{ route('output.accept') }}">
                                    @csrf

                                    <input type="text" class="d-none" value="{{ $outputcreated }}" name="acceptids" id="acceptids">

                                    <button type="button" class="btn btn-sm rounded border border-1 border-success btn-light shadow acceptoutput-btn">
                                        <b class="small">Approve Output</b>
                                    </button>

                                </form>
                            </div>
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
            var outputtype = $(this).closest('[data-value]').attr('data-value');

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