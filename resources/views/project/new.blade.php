@extends('layouts.app')

@section('content')
<div class="maincontainer">
    &nbsp;
    <div class="basiccont m-4 p-3">




        <div class="form-floating">
            <select id="project-select" class="form-select" aria-label="Select an option" style="border: 1px solid darkgreen;">
                <option value="" selected disabled>Select Project</option>
                @foreach($projects as $project)
                <option value="{{ $project->id }}">
                    {{ $project->projecttitle }}
                </option>
                @endforeach

            </select>

            <label for="project-select" style="color:darkgreen;"><strong>Select Project:</strong></label>
        </div>




        <button type="button" class="btn btn-sm mt-3 shadow rounded border border-2 border-warning text-body" style="background-color: gold;" data-bs-toggle="modal" data-bs-target="#departmentModal"><b class="small">Create New Project</b></button>

    </div>
    &nbsp;
</div>

@endsection
@section('scripts')
<script>

</script>
@endsection