@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end">
    <div class="container mt-3">
        @if(Auth::user()->role === 'Admin')
        <div class="basiccont word-wrap shadow">
            <div class="border-bottom ps-3 pt-2 bggreen">
                <h5 class="fw-bold" style="color:darkgreen;">Select Department for Report Viewing</h5>
            </div>
            <div class="container p-4 text-center">
                <div>
                    <a href="{{ route('insights.show', ['department' => 'Department of Management']) }}" class="btn btn-outline-success btn-lg btn-block mb-3 p-4"><i class="bi bi-bar-chart-line-fill fs-2"></i> Department of Management</a>

                </div>
                <div>
                    <a href="{{ route('insights.show', ['department' => 'Department of Industrial and Information Technology']) }}" class="btn btn-outline-success btn-lg btn-block mb-3 p-4"><i class="bi bi-bar-chart-line-fill fs-2"></i> Department of Industrial and Information Technology</a>


                </div>

                <div>
                    <a href="{{ route('insights.show', ['department' => 'Department of Teacher Education']) }}" class="btn btn-outline-success btn-lg btn-block mb-3 p-4"><i class="bi bi-bar-chart-line-fill fs-2"></i> Department of Teacher Education</a>

                </div>
                <div>
                    <a href="{{ route('insights.show', ['department' => 'Department of Arts and Science']) }}" class="btn btn-outline-success btn-lg btn-block mb-3 p-4"><i class="bi bi-bar-chart-line-fill fs-2"></i> Department of Arts and Science</a>

                </div>

            </div>
        </div>
        @else
        <div class="container p-4 text-center">
            <h1>Sorry, this is exclusive for admin. <a href="{{ route('tasks.show', ['username' => Auth::user()->username]) }}">Go back</a></h1>
        </div>
        @endif
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#navbarDropdown').click(function() {
            // Add your function here
            $('#account .dropdown-menu').toggleClass('shows');
        });
    });
</script>
@endsection