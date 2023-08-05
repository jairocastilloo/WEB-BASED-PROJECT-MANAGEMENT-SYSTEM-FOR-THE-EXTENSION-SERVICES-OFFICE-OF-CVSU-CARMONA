@extends('layouts.app')


@section('content')
<div class="maincontainer">
    &nbsp;
    <div class="basiccont m-4 p-3">


        <div class="row border-bottom px-4">
            <label for="academic year" class="form-label">Academic Year:</label>
            <div class="col">
                <div class="form-floating mb-3 mt-3">
                    <input type="date" class="form-control form-control-sm" name="email">
                    <label for="email">Academic Start Date</label>
                </div>

            </div>
            <div class="col">
                <div class="form-floating mb-3 mt-3">
                    <input type="date" class="form-control" name="email">
                    <label for="email">Academic End Date</label>
                </div>


            </div>
        </div>

        <div class="row border-bottom pt-3 px-4">
            <label for="first semester" class="form-label">Start of First Semester:</label>
            <div class="col">

                <div class="form-floating mb-3 mt-3">
                    <input type="date" class="form-control form-control-sm" name="email">
                    <label for="email">First Semester Start Date</label>
                </div>

            </div>
            <div class="col">

                <div class="form-floating mb-3 mt-3">
                    <input type="date" class="form-control form-control-sm" name="email">
                    <label for="email">First Semester End Date</label>
                </div>


            </div>
        </div>

        <div class="row pt-3 px-4">
            <label for="second semester" class="form-label">Start of Second Semester:</label>
            <div class="col">

                <div class="form-floating mb-3 mt-3">
                    <input type="date" class="form-control form-control-sm" name="email">
                    <label for="email">Second Semester Start Date</label>
                </div>
            </div>
            <div class="col">

                <div class="form-floating mb-3 mt-3">
                    <input type="date" class="form-control form-control-sm" name="email">
                    <label for="email">Second Semester End Date</label>
                </div>

            </div>
        </div>

        <div class="btn-group mt-3 mb-2 shadow">
            <button type="button" class="btn rounded border border-1 border-warning btn-gold shadow">
                <b>Set an Academic Year</b>
            </button>
        </div>
    </div>

    &nbsp;
</div>

@endsection
@section('scripts')
<script>

</script>
@endsection