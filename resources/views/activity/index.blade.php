@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
            <div class="basiccont">
                <h5><b>{{ $activity['actname'] }}</b></h5>
                Expected Output: {{ $activity['actoutput'] }} <br>
                Start Date: {{ $activity['actstartdate'] }} <br>
                End Date: {{ $activity['actenddate'] }} <br>
                Budget: {{ $activity['actbudget'] }} <br>
                Source: {{ $activity['actsource'] }} <br>
                Assignees: @foreach ($assignees as $key => $assignee)
                {{ $assignee->name . ' ' . $assignee->last_name }}
                @if (!$loop->last)
                ,
                @endif
                @endforeach
            </div>

            <div class="basiccont">
                @foreach ($outputTypes as $outputType)
                <h4>{{ $outputType }}:</h4>
                @foreach ($outputs as $output)
                @if ($output->output_type === $outputType)
                <p>{{ $output->output_name }}</p>
                @endif
                @endforeach
                @endforeach

            </div>
        </div>
        <div class="col-4">
            <div class="basiccont">
                <h5 class="border-bottom p-2"><b>Subtasks:</b></h5>
                <ul class="list-unstyled" id="subtask">
                    @foreach ($subtasks as $subtask)
                    <li class="p-2 border-bottom">{{ $subtask->subtask_name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>

</div>

@endsection

@section('scripts')

<script>



</script>

@endsection