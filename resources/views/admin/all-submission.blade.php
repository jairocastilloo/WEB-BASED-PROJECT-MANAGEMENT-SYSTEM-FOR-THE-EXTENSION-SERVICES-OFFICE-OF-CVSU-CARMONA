@extends('layouts.app')

@section('content')
<div class="maincontainer border border-start border-end border-bottom border-top-0">

    @if(Auth::user()->role === 'Admin')
    <div class="container mt-3">

        <input type="text" class="d-none" id="username" value="{{ Auth::user()->username }}">
        <div class="row">
            <div class="col-lg-4">
                <label class="ms-3 small form-label text-secondary fw-bold">
                   Projects Submitted Reports
                </label>
                @livewire('projects-submission')

            </div>
            <div class="col-lg-4">
                <label class="ms-3 small form-label text-secondary fw-bold">
                    Activities Submitted Reports
                </label>
                @livewire('activities-submission')

            </div>
            <div class="col-lg-4">
                <label class="ms-3 small form-label text-secondary fw-bold">
                   Subtasks Submitted Reports
                </label>
                @livewire('subtasks-submission')


            </div>





        </div>

    </div>


    @else

    <h1>Sorry, this is exclusive for admin. <a href="{{ route('tasks.show', ['username' => Auth::user()->username]) }}">Go back</a></h1>

    @endif
</div>
@endsection
@section('scripts')

<script>
    $(document).ready(function() {

        $(document).on('click', '.projsubmission-div', function() {
            event.preventDefault();

            var projsubmissionid = $(this).attr("data-id");
            var projapproval = $(this).attr("data-approval");
            var projsubmission;

            if (projapproval === "") {
                projsubmission = "For Evaluation";
            } else if (projapproval == 0) {
                projsubmission = "For Revision";
            } else if (projapproval == 1) {
                projsubmission = "Accepted";
            }


            var url =
                '{{ route("projsubmission.display", ["projsubmissionid" => ":projsubmissionid", "projsubmissionname" => ":projsubmissionname"]) }}';
            url = url.replace(':projsubmissionid', projsubmissionid);
            url = url.replace(':projsubmissionname', projsubmission);
            window.location.href = url;
        });

        $(document).on('click', '.actsubmission-div', function() {
            event.preventDefault();

            var actsubmissionid = $(this).attr("data-id");
            var actapproval = $(this).attr("data-approval");
            var actsubmission;

            if (actapproval === "") {
                actsubmission = "For Evaluation";
            } else if (actapproval == 0) {
                actsubmission = "For Revision";
            } else if (actapproval == 1) {
                actsubmission = "Accepted";
            }


            var url =
                '{{ route("actsubmission.display", ["actsubmissionid" => ":actsubmissionid", "actsubmissionname" => ":actsubmissionname"]) }}';
            url = url.replace(':actsubmissionid', actsubmissionid);
            url = url.replace(':actsubmissionname', actsubmission);
            window.location.href = url;
        });

        $(document).on('click', '.submission-div', function() {
            event.preventDefault();

            var submissionid = $(this).attr("data-id");
            var approval = $(this).attr("data-approval");
            var submission;
            console.log(approval);
            if (approval === "") {
                submission = "For Evaluation";
            } else if (approval == 0) {
                submission = "For Revision";
            } else if (approval == 1) {
                submission = "Accepted";
            }


            var url =
                '{{ route("submission.display", ["submissionid" => ":submissionid", "submissionname" => ":submissionname"]) }}';
            url = url.replace(':submissionid', submissionid);
            url = url.replace(':submissionname', submission);
            window.location.href = url;
        });

    });
</script>


@endsection
