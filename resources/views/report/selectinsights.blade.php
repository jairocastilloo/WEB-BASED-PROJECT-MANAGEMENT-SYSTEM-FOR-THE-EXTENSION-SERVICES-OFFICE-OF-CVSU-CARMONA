@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end">
    <input type="text" class="d-none" name="department" id="department" value="{{ Auth::user()->department }}">
    <div class="container pt-3">
        <div class="row">
            <div class="col-lg-10">

                <div class="basiccont rounded shadow pb-2">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Browse Reports</h6>
                    </div>
                    @if (!$inCurrentYear)
                    <span class="small ms-2"><em>
                            Note: Not the Current Year.
                        </em></span>
                    @endif
                    <div class="form-floating m-3 mb-2 mt-2">

                        <select id="year-select" class="form-select fw-bold" style="border: 1px solid darkgreen; color:darkgreen; font-size: 19px;" aria-label="Select an calendar year">

                            @foreach ($calendaryears as $calendaryear)
                            <option value="{{ $calendaryear }}" {{ $calendaryear == $currentyear ? 'selected' : '' }}>
                                &nbsp;&nbsp;&nbsp;{{ $calendaryear }}
                            </option>
                            @endforeach

                        </select>
                        <label for="year-select" style="color:darkgreen;">
                            <h5><strong>Calendar Year:</strong></h5>
                        </label>
                    </div>
                    @if (Auth::user()->role === 'Admin')
                    <div class="btn-group mt-1 ms-3 mb-2 shadow">
                        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="addproj">
                            <b class="small">Create Project</b>
                        </button>
                    </div>
                    @endif
                </div>

                @php

                $sortedProjects= $currentproject->sortBy('projectstartdate');

                @endphp
                <label class="ms-2 small form-label text-secondary fw-bold">Upcoming and Ongoing Projects</label>
                @if($currentproject->isEmpty())
                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                        <h6 class="fw-bold small" style="color:darkgreen;">
                            Projects
                            <span class="badge bggold text-dark">
                                {{ count($currentproject) }}
                            </span>
                            <i class="bi bi-caret-down-fill text-end"></i>
                        </h6>

                    </div>
                    <div class="toggle-container subtoggle" style="display: none;">
                        <div class="text-center p-4">
                            <h4><em>No Projects Yet.</em></h4>
                        </div>
                    </div>
                </div>
                @else

                @livewire('other-reports', ['currentproject' => $sortedProjects])
                @endif



            </div>

            <div class="col-lg-2">

                @php

                $pastProjects= $pastproject->sortBy('projectstartdate');

                @endphp
                <label class="ms-2 small form-label text-secondary fw-bold">Past Projects</label>
                @if($pastproject->isEmpty())
                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                        <h6 class="fw-bold small" style="color:darkgreen;">
                            Projects
                            <span class="badge bggold text-dark">
                                {{ count($pastproject) }}
                            </span>
                            <i class="bi bi-caret-down-fill text-end"></i>
                        </h6>

                    </div>
                    <div class="toggle-container subtoggle" style="display: none;">
                        <div class="text-center p-4">
                            <h4><em>No Projects Yet.</em></h4>
                        </div>
                    </div>
                </div>
                @else

                @livewire('other-reports', ['currentproject' => $pastProjects])
                @endif


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

        $('#navbarDropdown').click(function() {
            // Add your function here
            $('#account .dropdown-menu').toggleClass('shows');
        });

        // Add an event listener to the select element
        selectElement.change(function() {
            var selectedOption = $(this).find(':selected');
            var currentyear = selectedOption.val();

            var department = $('#department').val();

            var baseUrl = "{{ route('yearinsights.show', ['department' => ':department', 'currentyear' => ':currentyear']) }}";
            var url = baseUrl.replace(':department', department)
                .replace(':currentyear', currentyear);

            window.location.href = url;
        });



    });
</script>
@endsection