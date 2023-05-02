@extends('layouts.app')

@section('content')
<div class="row text-white">
    <div class="col-1"></div>
    <div class="col-10">

        <div><b>{{ __('Monitoring') }}</b></div>

        <h3>
            @if (session('status'))
            <div>
                {{ session('status') }}
            </div>
            @endif

            {{ __('Good day,') }} {{ Auth::user()->role }} {{ __(' ') }} {{ Auth::user()->name }}{{ __('!') }}
        </h3>
        <p>{{ date('l, F jS, Y') }}.</p>

        <div class="table-responsive m-4">
            <table class="table table-bordered table-dark table-hover">
                <thead>
                    <tr>
                        <th class="col-6">Activity Name</th>
                        <th class="col-3">Project Name</th>
                        <th class="col-2">Due Date</th>
                        <th class="col-1">Hours</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activities as $activity)
                    <tr>
                        <td><b>{{ $activity->actname }}</b>
                            <ul class="list-unstyled ms-2 small">
                                <p style="display: inline; margin: 0; color: #3dd18d;">Subtasks List:</p>
                                @foreach ($activity->subtasks->pluck('subtask_name') as $subtaskName)
                                <li class="ms-2">{{ $subtaskName }}</li>
                                @endforeach
                            </ul>

                            </ul>
                        </td>
                        <td>{{ $activity->project->projecttitle }}</td>
                        <td>{{ $activity->actenddate }}</td>
                        <td></td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>


    </div>
    <div class="col-1"></div>
</div>
@endsection