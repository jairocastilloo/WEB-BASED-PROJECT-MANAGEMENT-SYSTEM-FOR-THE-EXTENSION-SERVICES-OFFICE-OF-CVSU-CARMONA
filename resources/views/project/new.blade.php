@extends('layouts.app')

@section('content')
<div class="maincontainer">
    &nbsp;
    <div class="basiccont m-4 p-3">
        <div class="border-bottom ps-3">
            <h6 class="fw-bold small text-secondary">Program Details</h6>
        </div>
        <div class="form-floating mb-3 mt-3">
            <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
            <label for="email">Program Title</label>
        </div>
        <div class="form-floating mb-3 mt-3">
            <select class="form-select" id="sel1" name="sellist">
                <option selected disabled>Program Leader</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
            </select>
            <label for="sel1" class="form-label">Assign one</label>
        </div>
        <div class="border-bottom ps-3">
            <h6 class="fw-bold small text-secondary">Project Details</h6>
        </div>
        <div class="form-floating mb-3 mt-3">
            <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
            <label for="email">Project Title</label>
        </div>
        <div class="form-floating mb-3 mt-3">
            <select class="form-select" id="sel1" name="sellist">
                <option selected>Project Leader</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
            </select>
            <label for="sel1" class="form-label">Assign one</label>
        </div>
        <div class="border-bottom ps-3">
            <h6 class="fw-bold small text-secondary">Duration</h6>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3 mt-3">
                    <input type="date" class="form-control form-control-sm" id="email" placeholder="Enter email" name="email">
                    <label for="email">Start Date</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating mb-3 mt-3">
                    <input type="date" class="form-control" id="email" placeholder="Enter email" name="email">
                    <label for="email">End Date</label>
                </div>
            </div>
        </div>

    </div>

    <div class="basiccont m-4 p-3">
        <div class="border-bottom ps-3">
            <h6 class="fw-bold small text-secondary">Objectives</h6>
        </div>
        <div class="form-floating mb-3 mt-3">
            <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
            <label for="email">Program Title</label>
        </div>
        <div class="form-floating mb-3 mt-3">
            <select class="form-select" id="sel1" name="sellist">
                <option selected disabled>Program Leader</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
            </select>
            <label for="sel1" class="form-label">Program Leader</label>
        </div>
        <div class="form-floating mb-3 mt-3">
            <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
            <label for="email">Project Title</label>
        </div>
        <div class="form-floating mb-3 mt-3">
            <select class="form-select" id="sel1" name="sellist">
                <option selected disabled>Project Leader</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
            </select>
            <label for="sel1" class="form-label">Project Leader</label>
        </div>
        <div class="form-floating mb-3 mt-3">
            <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
            <label for="email">Duration</label>
        </div>
    </div>
    &nbsp;
</div>

@endsection
@section('scripts')
<script>

</script>
@endsection