@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-8">
            <div class="basiccont">
                <h4><b> {{ $activity['actname'] }} </b></h4>
                Expected Output: {{ $activity['actoutput'] }} </br>
                Start Date: {{ $activity['actstartdate'] }} </br>
                End Date: {{ $activity['actenddate'] }} </br>
                Budget: {{ $activity['actbudget'] }} </br>
                Source: {{ $activity['actsource'] }} </br>
            </div>
            <div class="basiccont">

            </div>
        </div>
        <div class="col-4 basiccont">
            <b>Assignees: </b>
            <ul class="list-unstyled">

                @foreach ($assignees as $assignee)
                <li>{{ $assignee->name . ' ' . $assignee->last_name }}</li>

                @endforeach
            </ul>
        </div>

    </div>

</div>

@endsection