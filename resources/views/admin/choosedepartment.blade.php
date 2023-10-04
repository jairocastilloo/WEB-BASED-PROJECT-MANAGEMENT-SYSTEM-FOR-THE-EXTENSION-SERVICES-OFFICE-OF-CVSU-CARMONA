@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end">
    <div class="container mt-3">
        <div class="basiccont word-wrap shadow">
            <div class="border-bottom ps-3 pt-2 bggreen">
                <h5 class="fw-bold" style="color:darkgreen;">Choose Department</h5>
            </div>
            <div class="container p-4 text-center">
                <div>
                    <a href="{{ route('admin.index', ['department' => 'Department of Management']) }}" class="btn btn-success btn-lg btn-block mb-3 p-4">Department of Management</a>

                </div>
                <div>
                    <a href="{{ route('admin.index', ['department' => 'Department of Industrial and Information Technology']) }}" class="btn btn-success btn-lg btn-block mb-3 p-4">Department of Industrial and Information Technology</a>


                </div>


                <div>
                    <a href="{{ route('admin.index', ['department' => 'Department of Teacher Education']) }}" class="btn btn-success btn-lg btn-block mb-3 p-4">Department of Teacher Education</a>

                </div>
                <div>
                    <a href="{{ route('admin.index', ['department' => 'Department of Arts and Science']) }}" class="btn btn-success btn-lg btn-block mb-3 p-4">Department of Arts and Science</a>

                </div>

            </div>
        </div>
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