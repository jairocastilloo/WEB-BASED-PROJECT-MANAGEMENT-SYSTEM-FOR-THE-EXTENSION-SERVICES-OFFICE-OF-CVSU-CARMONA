@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end">
    <div class="container mt-3">
        <div class="basiccont word-wrap shadow">
            <div class="border-bottom ps-3 pt-2 bggreen">
                <h6 class="fw-bold small" style="color:darkgreen;">Choose Department</h6>
            </div>
            <div class="container mt-2 text-center">
                <div>
                    <button class="btn btn-success btn-lg btn-block mb-3 w-50">Department of Management</button>
                </div>
                <div>
                    <button class="btn btn-success btn-lg btn-block mb-3 w-50">Department of Industrial and Information Technology</button>
                </div>


                <div>
                    <button class="btn btn-success btn-lg btn-block mb-3 w-50">Department of Teacher Education</button>
                </div>
                <div>
                    <button class="btn btn-success btn-lg btn-block mb-3 w-50">Department of Arts and Science</button>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection