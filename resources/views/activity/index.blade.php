@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-8">
            <div class="basiccont">
                {{ $activity['actname'] }} </br>
                {{ $activity['actoutput'] }} </br>
                {{ $activity['actstartdate'] }} </br>
                {{ $activity['actenddate'] }}
            </div>
            <div class="basiccont">
                as
            </div>
        </div>
        <div class="col-4 basiccont">
            zxc
        </div>

    </div>

</div>

@endsection