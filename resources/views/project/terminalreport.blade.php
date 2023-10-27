@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-bottom border-top-0">
    <div class="mainnav border-bottom mb-3 shadow-sm">
        <div class="step-wrapper">
            <div class="step highlight">
                <span class="fw-bold">Project: {{ $indexproject['projecttitle'] }}</span>
                <div class="message-box">
                    {{ $indexproject['projecttitle'] }}
                </div>
            </div>


        </div>

    </div>

    <div class="container">

        <div class="row">
            <div class="col-lg-10">

                <div class="basiccont rounded shadow pb-2">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Browse Projects</h6>
                    </div>
                    @if (!$inCurrentYear)
                    <span class="small ms-2"><em>
                            Note: Not the Current Year.
                        </em></span>
                    @endif
                    <div class="form-floating m-3 mb-2 mt-2">

                        <select id="year-select" class="form-select fw-bold" style="border: 1px solid darkgreen; color:darkgreen;" aria-label="Select an fiscal year">

                            @foreach ($fiscalyears as $fiscalyear)
                            <option value="{{ $fiscalyear->id }}" {{ $fiscalyear->id == $currentfiscalyear->id ? 'selected' : '' }}>
                                &nbsp;&nbsp;&nbsp;{{ date('F Y', strtotime($fiscalyear->startdate)) . ' - ' . date('F Y', strtotime($fiscalyear->enddate)) }}
                            </option>
                            @endforeach

                        </select>
                        <label for="year-select" style="color:darkgreen;">
                            <h6><strong>Fiscal Year:</strong></h6>
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

                <div class="basiccont p-3 rounded shadow">

                    <div class="flexmid"><strong>WORK AND FINANCIAL PLAN</strong></div>
                    <div class="flexmid">FY&nbsp;<u>
                            @php
                            $startYearFiscal = date('Y', strtotime($currentfiscalyear['startdate']));
                            $endYearFiscal = date('Y', strtotime($currentfiscalyear['enddate']));
                            @endphp

                            {{ $startYearFiscal === $endYearFiscal ? $startYearFiscal : $startYearFiscal . ' - ' . $endYearFiscal }}
                        </u></div>
                    @if ($indexproject['programtitle'] != "")
                    <div class="flex-container">
                        <strong><em>Program Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
                        <div class="underline-space inline-div ps-2">{{ $indexproject['programtitle'] }}</div>
                    </div>
                    @endif
                    @if ($programleaders->isNotEmpty())
                    <div class="flex-container">
                        <strong><em>Program Leader:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
                        <div class="underline-space inline-div ps-2">

                            @foreach ($programleaders as $programleader)

                            {{ ucfirst($programleader->name) }}

                            @if ($programleader->middle_name)
                            {{ substr(ucfirst($programleader->middle_name), 0, 1) }}.
                            @endif


                            @if (!$loop->last)
                            {{ ucfirst($programleader->last_name) . ', ' }}
                            @else
                            {{ ucfirst($programleader->last_name)}}
                            @endif

                            @endforeach

                        </div>


                    </div>
                    @endif

                    <div class="flex-container">
                        <strong><em>Project Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
                        <div class="underline-space inline-div ps-2">{{ $indexproject['projecttitle'] }}</div>
                    </div>
                    <div class="flex-container">
                        <strong><em>Project Leader:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
                        <div class="underline-space inline-div ps-2">
                            @foreach ($projectleaders as $projectleader)

                            {{ ucfirst($projectleader->name) }}

                            @if ($projectleader->middle_name)
                            {{ substr(ucfirst($projectleader->middle_name), 0, 1) }}.
                            @endif


                            @if (!$loop->last)
                            {{ ucfirst($projectleader->last_name) . ', ' }}
                            @else
                            {{ ucfirst($projectleader->last_name)}}
                            @endif

                            @endforeach

                        </div>
                    </div>
                    <div class="flex-container">
                        <strong><em>Duration:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
                        <div class="underline-space inline-div ps-2">{{ date('F Y', strtotime($indexproject['projectstartdate'])) . '-' . date('F Y', strtotime($indexproject['projectenddate'])) }}</div>
                    </div>

                    <div class="btn-group dropdown mt-3 shadow">
                        <button type="button" class="btn btn-sm dropdown-toggle shadow rounded border border-1 btn-gold border-warning text-body" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <b class="small"> <i class="bi bi-list"></i> Menu</b>
                        </button>
                        <div class="dropdown-menu border-warning">
                            <a class="dropdown-item small bg-warning border-bottom">
                                <b class="small">Table</b>
                            </a>
                            <a class="dropdown-item small hrefnav border-bottom" href="{{ route('projects.members', ['projectid' => $indexproject->id, 'department' => $department ]) }}">
                                <b class="small">Team Members</b>
                            </a>
                            <a class="dropdown-item small hrefnav border-bottom" href="{{ route('projects.activities', ['projectid' => $indexproject->id, 'department' => $department ]) }}">
                                <b class="small">Activities</b>
                            </a>
                            <a class="dropdown-item small hrefnav border-bottom" href="{{ route('projects.calendar', ['projectid' => $indexproject->id, 'department' => $department ]) }}">
                                <b class="small">Calendar</b>
                            </a>
                            <a class="dropdown-item small hrefnav border-bottom" href="{{ route('projects.details', ['projectid' => $indexproject->id, 'department' => $department ]) }}">
                                <b class="small">Edit Details</b>
                            </a>
                            <a class="dropdown-item small hrefnav border-bottom" href="#"><b class="small">Close Project</b></a>
                            <!-- if included
                        <a class="dropdown-item small hrefnav" href="{{ route('projects.objectives', ['projectid' => $indexproject->id, 'department' => Auth::user()->department ]) }}">
                            <b class="small">Edit Objectives</b>
                        </a> -->
                            <!-- <a class="dropdown-item small hrefnav" href="#" id="addactivity" data-bs-toggle="modal" data-bs-target="#newactivity"><b class="small">Add Activity</b></a> -->



                        </div>
                    </div>
                    <!--
                <button type="button" class="btn btn-sm add-assignees-btn mt-2 shadow rounded border border-2 border-warning" style="background-color: gold;" id="addactivity" data-bs-toggle="modal" data-bs-target="#newactivity">
                    <b class="small">Add Activity</b>
                </button>
-->

                </div>
                <div class="basiccont rounded shadow">
                    <div class="border-bottom ps-3 pt-2 bggreen mb-1">
                        <h6 class="fw-bold small" style="color:darkgreen;">Table</h6>
                    </div>
                   

                    
                </div>


            </div>

            <div class="col-lg-2">


                <label class="ms-3 small form-label text-secondary fw-bold">Other Projects</label>
                @livewire('more-projects', ['department' => $department, 'projectid' => $indexproject->id, 'fiscalyearid' => $currentfiscalyear->id, 'x' => 1])
                @livewire('not-started-projects', ['department' => $department, 'projectid' => $indexproject->id, 'fiscalyearid' => $currentfiscalyear->id, 'y' => 1])
                @livewire('past-projects', ['department' => $department, 'projectid' => $indexproject->id, 'fiscalyearid' => $currentfiscalyear->id, 'z' => 0])
            </div>

        </div>
    </div>
</div>

<!-- New Project -->
@if (Auth::user()->role === 'Admin')
<div class="modal fade" id="newproject" tabindex="-1" aria-labelledby="newprojectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newproject">New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true" disabled>Project Details</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false" disabled>Project Objectives</button>
                    </li>

                </ul>
                <div class="tab-content">

                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                        <!-- Form for tab 1 -->
                        <form id="form1" data-url="{{ route('project.store') }}">
                            @csrf
                            <input type="text" class="d-none" name="department" id="department" value="{{ $department }}">
                            <input type="text" class="d-none" name="fiscalyear" id="fiscalyear" value="{{ $currentfiscalyear->id }}">
                            <input type="number" class="d-none" id="memberindex" name="memberindex">
                            <input type="number" class="d-none" id="objectiveindex" name="objectiveindex">
                            <label for="projectdetails" class="form-label mt-2">Input all the details of the project</label>
                            <div class="mb-3">
                                <label for="projecttitle" class="form-label">Project Title</label>
                                <input type="text" class="form-control autocapital" id="projecttitle" name="projecttitle">

                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                            <div class="container mb-3 p-0">
                                <label for="projectleader" class="form-label">Project Leader</label>
                                <select class="selectpicker w-100 border projectleader" name="projectleader[]" id="projectleader" multiple aria-label="Select Project Leaders" data-live-search="true">
                                    <option value="0" disabled>Select Project Leader</option>
                                    @foreach ($members as $member)
                                    @if ($member->role === 'Coordinator' || $member->role === 'Admin')
                                    <option value="{{ $member->id }}">{{ $member->name . ' ' . $member->last_name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="programtitle" class="form-label">Program Title <span class="text-secondary">( if applicable )</span></label>
                                <input type="text" class="form-control autocapital" id="programtitle" name="programtitle">

                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                            <div class="container mb-3 p-0 programleaderdiv" style="display:none;">
                                <label for="programleader" class="form-label">Program Leader</label>
                                <select class="selectpicker w-100 border programleader" name="programleader[]" id="programleader" multiple aria-label="Select Program Leaders" data-live-search="true">
                                    <option value="0" disabled>Select Program Leader</option>
                                    @foreach ($members as $member)
                                    @if ($member->role === 'Coordinator' || $member->role === 'Admin')
                                    <option value="{{ $member->id }}">{{ $member->name . ' ' . $member->last_name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="projectstartdate" class="form-label">Project Start Date</label>

                                <div class="input-group date" id="startDatePicker">
                                    <input type="text" class="form-control" id="projectstartdate" name="projectstartdate" placeholder="mm/dd/yyyy" />
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-light d-block">
                                            <i class="bi bi-calendar-event-fill"></i>
                                        </span>
                                    </span>
                                </div>

                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>

                                <!--<input type="date" class="form-control" id="projectstartdate" name="projectstartdate">-->


                            </div>

                            <div class="mb-3">
                                <label for="projectenddate" class="form-label">Project End Date</label>

                                <div class="input-group date" id="endDatePicker">
                                    <input type="text" class="form-control" id="projectenddate" name="projectenddate" placeholder="mm/dd/yyyy" />
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-light d-block">
                                            <i class="bi bi-calendar-event-fill"></i>
                                        </span>
                                    </span>
                                </div>

                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>

                                <!--<input type="date" class="form-control" id="projectenddate" name="projectenddate">-->


                            </div>
                        </form>


                    </div>


                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                        <!-- Form for tab 2 -->

                        <div class="container-fluid" id="objform">
                            <form id="form2">
                                @csrf
                                <label for="projectobjectives" class="form-label mt-2">List all objectives of the project</label>
                                <div class="container-fluid" id="objectiveset">
                                    <div>
                                        <div class="mb-2 row" id="selectobjectives">
                                            <input type="text" class="col-8 m-1 input-objective autocapital p-2 rounded" id="objective-input" name="projectobjective[]" placeholder="Enter objective">
                                            <input type="number" name="objectivesetid[]" value="0" class="objectivesetid d-none">
                                            <button type="button" class="remove-objective btn btn-sm btn-outline-danger col-3 m-1" id="removeobjective"><b class="small">Remove</b></button>


                                        </div>
                                    </div>
                                    <button type="button" class="add-objective btn btn-sm btn-outline-success" id="addobjective">
                                        <b class="small">Add Objective</b>
                                    </button>
                                    <br>
                                    <span class="small text-danger projectobjective-error">
                                        <strong>Please ensure that there is objective in every input.</strong>
                                    </span>

                                    <hr>
                                </div>
                            </form>
                            <button type="button" class="addset btn btn-outline-secondary w-100" id="addset">
                                <b class="small">Add Objective Set</b>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="text-danger" id="createprojectError">
                    <strong></strong>
                </span>
                <span class="ms-2 small" id="loadingSpan" style="display: none;">Sending Email..</span>
                <button type="button" class="btn shadow rounded border border-1 btn-light" data-bs-dismiss="modal"><b class="small">Close</b></button>
                <button type="button" class="btn shadow rounded btn-outline-primary try" id="prevproject">
                    <b class="small">Previous</b>
                </button>
                <button type="button" class="btn shadow rounded btn-primary" id="nextproject"><b class="small">Next</b></button>
                <button type="button" class="btn shadow rounded btn-primary" id="createproject">
                    <b class="small">Create Project</b>
                </button>

            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
<!--<script src="{{ asset('js/selectize.min.js') }}"></script>-->
<script>
    

</script>
@endsection