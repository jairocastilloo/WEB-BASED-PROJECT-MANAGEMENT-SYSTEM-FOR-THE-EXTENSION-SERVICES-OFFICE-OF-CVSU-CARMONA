<div>
    <div class="basiccont word-wrap shadow mt-2">
        <div class="border-bottom ps-3 pt-2 bggreen">
            <h6 class="fw-bold small" style="color:darkgreen;">Output</h6>

        </div>
        @php
        $outputarray = ['Capacity Building', 'IEC Material', 'Advisory Services', 'Others'];
        @endphp
        @foreach ($outputTypes as $outputType)
        <div class="border-bottom p-2 divhover selectoutputdiv" data-value="{{ $outputType }}">
            @php
            $outputarray = array_diff($outputarray, [$outputType]);
            @endphp
            <p class="lh-base fw-bold ps-3">{{ $outputType }}</p>
            @foreach ($outputs as $output)
            @if ($output->output_type === $outputType)
            <p class="lh-1 ps-5" data-value="{{ $output->id }}">{{ $output->output_name . ': ' .  $output->totaloutput_submitted }} / <span class="expectedoutput">{{ $output->expectedoutput }} </span>
                <input type="hidden" class="shadow numberInput" id="numberInput" name="numberInput" pattern="\d{5}" title="Please enter exactly 5 digits" maxlength="5" value="{{ $output->expectedoutput }}">
            </p>
            @endif
            @endforeach
        </div>
        @endforeach
        <div class="dropdown btn-group ms-3 mt-2 mb-3 shadow">
            <button type="button" class="btn btn-sm dropdown-toggle shadow rounded border border-1 btn-gold border-warning text-body" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <b class="small"><i class="bi bi-pencil-square"></i></i> Edit</b>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item small hrefnav border-bottom" data-bs-toggle="modal" data-bs-target="#addoutputmodal">
                    <b class="small">Add Outputs</b>
                </a>
                <a class="dropdown-item small hrefnav border-bottom" id="editOutput">
                    <b class="small">Edit Outputs Needed</b>
                </a>

            </div>
        </div>
        <div class="text-center">
            <div><button type="button" class="btn btn-primary mb-2 d-none mt-2" id="saveOutput">
                    Save
                </button></div>
            <div> <button type="button" class="btn btn-secondary mb-2 d-none" id="cancelOutput">
                    Cancel
                </button></div>

        </div>

    </div>


    <div class="modal fade" id="addoutputmodal" tabindex="-1" aria-labelledby="addoutputmodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAssigneeModalLabel">Add Output</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="outputform">

                        <input type="hidden" name="outputactnumber" id="actid" value="{{ $activityid }}">
                        <div class="mb-3">
                            <label for="assigneeSelect" class="form-label">Select the type of output to be submitted.</label>
                            <select class="form-select" id="outputtype-select" name="outputtype">
                                <option value="" selected disabled>Select Output Type</option>
                                @foreach($outputarray as $outputarr)
                                <option value="{{ $outputarr }}">{{ $outputarr }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-9">
                                <br>
                                <label class="form-label fw-bold">Output Name:</label>
                            </div>
                            <div class="col-3">
                                <label class="form-label fw-bold">Output Needed:</label>
                            </div>
                        </div>


                        <div class="row divhover pt-2 pb-1 ps-1 outputnamediv d-none">
                            <div class="col-9">
                                <h6></h6>
                            </div>
                            <div class="col-3">
                                <input type="number" class="shadow numberInput" id="outputneeded" name="outputneeded[]" pattern="\d{5}" title="Please enter exactly 5 digits" maxlength="5" value="0">
                            </div>


                        </div>
                        <div class="row divhover p-2 mt-1 ps-1 outputinputdiv d-none">
                            <div class="col-9">
                                <input type="text" class="form-control w-100" name="newoutput[]" id="output-input">
                            </div>
                            <div class="col-3">
                                <button type="button" class="btn btn-danger btn-sm removeoutput-btn">Remove</button>
                            </div>

                        </div>


                    </form>
                    <div class="w-60">
                        <button type="button" class="btn btn-success addmoreoutput-btn btn-sm d-none"> Add more Output </button>
                    </div>
                    <span class="text-danger small d-none" id="outputErr">
                        <strong>Make sure that there is output listed and output needed is provided.</strong>
                    </span>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelAddOutput" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="btnAddOutput">Add Output</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            const addOutput = document.getElementById('btnAddOutput');
            const saveOutput = document.getElementById('saveOutput');
            addOutput.addEventListener('click', function() {
                var actid = document.getElementById('actid').value;
                var outputtype = document.getElementById('outputtype-select').value;
                var outputnumber = document.querySelectorAll('input[name="newoutput[]"]').length;
                var outputElements = document.querySelectorAll('input[name="newoutput[]"]');
                var outputNeededNumber = document.querySelectorAll('input[name="outputneeded[]"]');
                var outputValues = [];
                var outputNeeded = [];

                if (outputtype === "") {
                    $('#outputErr').removeClass('d-none');
                    return;
                }
                for (var i = 0; i < outputElements.length; i++) {
                    outputValues.push(outputElements[i].value);
                    if (outputNeededNumber[i].value === "" || outputNeededNumber[i].value == 0) {
                        $('#outputErr').removeClass('d-none');
                        return;
                    }
                    outputNeeded.push(outputNeededNumber[i].value);
                }

                Livewire.emit('addOutput', actid, outputtype, outputnumber, outputValues, outputNeeded);

            });

            Livewire.on('updateOutput', function() {
                document.getElementById('cancelAddOutput').click();
            });
            saveOutput.addEventListener('click', function() {
                // Select all the hidden input elements with class "numberInput"
                var numberInputs = document.querySelectorAll('.numberInput');

                // Create an object to store the values by their parent's data-value attribute
                var valuesByParentId = {};

                // Iterate through the hidden input elements
                numberInputs.forEach(function(numberInput) {
                    // Get the parent <p> element
                    var parentParagraph = numberInput.closest('p');

                    // Get the data-value attribute value of the parent <p> element
                    var parentId = parentParagraph.getAttribute('data-value');

                    // Get the value of the hidden input element
                    var inputValue = parseInt(numberInput.value); // Parse the value as an integer

                    // Check if the parent already exists in the object, if not, create it
                    if (!valuesByParentId[parentId]) {
                        valuesByParentId[parentId] = {
                            outputid: parentId,
                            outputneeded: inputValue
                        };
                    } else {
                        // Add the outputneeded value to the existing parent
                        valuesByParentId[parentId].outputneeded += inputValue;
                    }
                });




                Livewire.emit('saveEditOutput', valuesByParentId)


            });
        });
    </script>
</div>