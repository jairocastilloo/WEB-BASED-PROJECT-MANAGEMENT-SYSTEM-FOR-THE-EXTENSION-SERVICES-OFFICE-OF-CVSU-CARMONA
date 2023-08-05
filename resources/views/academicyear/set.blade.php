@extends('layouts.app')


@section('content')
<div class="maincontainer">
    &nbsp;
    <div class="basiccont m-4 p-3">

        <form id="acadyearform" data-url="{{ route('acadyear.save') }}">
            @csrf
            <div class="row border-bottom px-4">
                <label for="academic year" class="form-label">Academic Year:</label>
                <div class="col">
                    <div class="form-floating mb-3 mt-3">
                        <input type="date" class="form-control form-control-sm" name="academic-startdate">
                        <label for="email">Academic Start Date</label>
                    </div>

                </div>
                <div class="col">
                    <div class="form-floating mb-3 mt-3">
                        <input type="date" class="form-control" name="academic-enddate">
                        <label for="email">Academic End Date</label>
                    </div>


                </div>
            </div>

            <div class="row border-bottom pt-3 px-4">
                <label for="first semester" class="form-label">Start of First Semester:</label>
                <div class="col">

                    <div class="form-floating mb-3 mt-3">
                        <input type="date" class="form-control form-control-sm" name="firstsem-startdate">
                        <label for="email">First Semester Start Date</label>
                    </div>

                </div>
                <div class="col">

                    <div class="form-floating mb-3 mt-3">
                        <input type="date" class="form-control form-control-sm" name="firstsem-enddate">
                        <label for="email">First Semester End Date</label>
                    </div>


                </div>
            </div>

            <div class="row pt-3 px-4">
                <label for="second semester" class="form-label">Start of Second Semester:</label>
                <div class="col">

                    <div class="form-floating mb-3 mt-3">
                        <input type="date" class="form-control form-control-sm" name="secondsem-startdate">
                        <label for="email">Second Semester Start Date</label>
                    </div>
                </div>
                <div class="col">

                    <div class="form-floating mb-3 mt-3">
                        <input type="date" class="form-control form-control-sm" name="secondsem-enddate">
                        <label for="email">Second Semester End Date</label>
                    </div>

                </div>
            </div>

            <div class="btn-group ms-2 mt-3 mb-2 shadow">
                <button type="button" class="btn rounded border border-1 border-warning btn-gold shadow" id="acadyear-btn">
                    <b>Set an Academic Year</b>
                </button>
            </div>
        </form>
    </div>

    &nbsp;
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {

        $('#acadyear-btn').click(function() {
            var dataurl = $('#acadyearform').attr('data-url');
            var data1 = $('#acadyearform').serialize();


            // send data via AJAX
            $.ajax({
                url: dataurl,
                type: 'POST',
                data: data1,
                success: function(response) {
                    console.log(response);

                    window.location.href = "";

                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.error(error);

                }
            });
        });
    });
</script>
@endsection