<div>
    <div class="basiccont m-4 me-0 p-3 rounded shadow">
        <div class="flexmid"><strong>WORK AND FINANCIAL PLAN</strong></div>
        <div class="flexmid">CY&nbsp;<u>{{ date('Y', strtotime($indexproject['projectenddate'])) }}</u></div>
        <div class="flex-container">
            <strong><em>Program Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
            <div class="underline-space inline-div ps-2">{{ $indexproject['programtitle'] }}</div>
        </div>
        <div class="flex-container">
            <strong><em>Program Leader:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
            <div class="underline-space inline-div ps-2">
                @php
                use App\Models\User;
                $programleader = User::where('id', $indexproject['programleader'])->first(['name', 'middle_name', 'last_name']);
                $projectleader = User::where('id', $indexproject['projectleader'])->first(['name', 'middle_name', 'last_name']);
                @endphp

                @if ($programleader)
                {{ $programleader->name }}
                @if ($programleader->middle_name)
                {{ substr(ucfirst($programleader->middle_name), 0, 1) }}.
                @endif
                {{ ucfirst($programleader->last_name) }}
                @endif
            </div>


        </div>
        <div class="flex-container">
            <strong><em>Project Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
            <div class="underline-space inline-div ps-2">{{ $indexproject['projecttitle'] }}</div>
        </div>
        <div class="flex-container">
            <strong><em>Project Leader:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
            <div class="underline-space inline-div ps-2">

                @if ($projectleader)
                {{ $projectleader->name }}
                @if ($projectleader->middle_name)
                {{ substr(ucfirst($projectleader->middle_name), 0, 1) }}.
                @endif
                {{ ucfirst($projectleader->last_name) }}
                @endif
            </div>
        </div>
        <div class="flex-container">
            <strong><em>Duration:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
            <div class="underline-space inline-div ps-2">{{ date('F Y', strtotime($indexproject['projectstartdate'])) . '-' . date('F Y', strtotime($indexproject['projectenddate'])) }}</div>
        </div>

        <div class="btn-group dropdown mt-3 shadow">
            <button type="button" class="btn btn-sm dropdown-toggle shadow rounded border border-1 btn-gold border-warning text-body" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <b class="small">Menu</b>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item small hrefnav" href="{{ route('projects.details', ['projectid' => $projectid, 'department' => Auth::user()->department ]) }}">
                    <b class="small">Edit Details</b>
                </a>
                <a class="dropdown-item small hrefnav" href="#"><b class="small">Edit Objectives</b></a>
                <a class="dropdown-item small hrefnav" href="#" id="addactivity" data-bs-toggle="modal" data-bs-target="#newactivity"><b class="small">Add Activity</b></a>
                <a class="dropdown-item small hrefnav" href="{{ route('projects.calendar', ['projectid' => $projectid, 'department' => Auth::user()->department ]) }}">
                    <b class="small">View Activity Calendar</b>
                </a>
                <a class="dropdown-item small hrefnav" href="#"><b class="small">Close Project</b></a>
                <a class="dropdown-item small hrefnav" href="{{ route('projects.members', ['projectid' => $projectid, 'department' => Auth::user()->department ]) }}">
                    <b class="small">Team Members</b>
                </a>

            </div>
        </div>
    </div>

    <div class="basiccont m-4 me-0 p-3 rounded shadow">

        <div class="form-group inputlg">
            <div class="offset-1 col-lg-10">
                <label class="bold-label fw-bold py-3" for="Username1">Program Title:</label>
                <input placeholder="Enter Username" id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group inputlg">
            <div class="offset-1 col-lg-10">
                <label class="bold-label fw-bold py-3" for="Firstname1">Program Leader:</label>

                <input placeholder="Enter First Name" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
        </div>

        <div class="form-group inputlg">
            <div class="offset-1 col-lg-10">
                <label class="bold-label fw-bold py-3" for="Middelname1">Project Title:</label>
                <input placeholder="Enter Middle Name" id="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name') }}" required autocomplete="name" autofocus>

                @error('middle_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group inputlg">
            <div class="offset-1 col-lg-10">
                <label class="bold-label fw-bold py-3" for="Lastname1">Project Leader:</label>
                <input placeholder="Enter Last Name" id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="name" autofocus>

                @error('last_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group inputlg">
            <div class="offset-1 col-lg-10">
                <label class="bold-label fw-bold py-3" for="Emailaddress1">Project Start Date:</label>
                <input placeholder="Enter Email Address" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group inputlg">
            <div class="offset-1 col-lg-10">
                <label class="bold-label fw-bold py-3" for="Password1">Project End Date</label>
                <input placeholder="Enter Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

    </div>
</div>