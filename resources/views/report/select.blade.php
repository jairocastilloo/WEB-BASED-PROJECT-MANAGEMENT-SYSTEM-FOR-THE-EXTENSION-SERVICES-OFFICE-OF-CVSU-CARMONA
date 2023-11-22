@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-top-0">

    <div class="container pt-3">
        <div class="row">
            <div class="col-lg-10">

                <div class="basiccont rounded shadow pb-2">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Browse Reports</h6>
                    </div>

                    <div class="form-floating m-3 mb-2 mt-2">

                        <select id="year-select" class="form-select fw-bold" style="border: 1px solid darkgreen; color:darkgreen;" aria-label="Select a Department">

                            @foreach ($alldepartments as $alldepartment)
                            <option class="p-2" value="{{ $alldepartment }}" {{ $alldepartment == $department ? 'selected' : '' }}>
                                {{ $alldepartment }}
                            </option>
                            @endforeach

                        </select>
                        <label for="year-select" style="color:darkgreen;">
                            <h6><strong>Department Reports for:</strong></h6>
                        </label>
                    </div>

                </div>
                @livewire('more-projects', ['department' => $department, 'projectid' => null, 'x' => 1])


            </div>

            <div class="col-lg-2">

                @livewire('not-started-projects', ['department' => $department, 'projectid' => null, 'y' => 1])
                @livewire('past-projects', ['department' => $department, 'projectid' => null, 'z' => 0])
                @livewire('completed-projects', ['department' => $department, 'projectid' => null, 'xCompletedProjects' => 0])

            </div>

        </div>
    </div>
</div>



@endsection
@section('scripts')
<!--<script src="{{ asset('js/selectize.min.js') }}"></script>-->
<script>
    var selectElement = $('#year-select');
    var url = "";


    $(document).ready(function() {

        // Add an event listener to the select element
        selectElement.change(function() {
            var selectedOption = $(this).find(':selected');
            var department = selectedOption.val();

            var baseUrl = "{{ route('reports.show', ['department' => ':department']) }}";
            var url = baseUrl.replace(':department', encodeURIComponent(department))

            window.location.href = url;
        });
        $(document).on('click', '.reportdiv', function(event) {
            event.preventDefault();
            var department = $(this).attr('data-dept');
            var projectid = $(this).attr('data-value');


            var url = '{{ route("reports.display", ["projectid" => ":projectid", "department" => ":department" ]) }}';
            url = url.replace(':projectid', projectid);
            url = url.replace(':department', encodeURIComponent(department));

            window.location.href = url;
        });

    });
</script>
@endsection