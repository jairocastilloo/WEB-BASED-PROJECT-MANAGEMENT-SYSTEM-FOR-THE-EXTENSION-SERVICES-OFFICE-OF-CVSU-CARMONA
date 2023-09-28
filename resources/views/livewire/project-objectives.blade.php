<div>
    <div class="px-4 pt-2 pb-1">
        <label for="objectives" class="form-label">Input all objectives:</label>
        @php
        $x = 0;
        @endphp
        @while ($x <= $lastObjectivesetId) <div class="py-2 border-bottom">
            <label class="form-label">{{ $x + 1 }}.</label>
            @foreach($objectives->where('objectiveset_id', $x) as $objective)

            <div class="mb-3 container">
                <div class="row">
                    <div class="col-10">
                        <input placeholder="Enter Objective" value="{{ $objective['name'] }}" type="text" class="form-control" id="programTitle" name="programTitle" required disabled>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-outline-danger"><i class="bi bi-trash-fill"></i></button>
                    </div>
                </div>
            </div>
            @endforeach
            <button type="button" class="btn btn-outline-success"> Add Objective</button>
    </div>
    @php
    $x++;
    @endphp
    @endwhile


</div>
<div class="btn-group mt-2 ms-3 mb-3 shadow" id="div-editObjectives">
    <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" id="btn-editObjectives" aria-haspopup="true" aria-expanded="false">
        <b class="small">Edit Objectives</b>
    </button>
</div>
</div>