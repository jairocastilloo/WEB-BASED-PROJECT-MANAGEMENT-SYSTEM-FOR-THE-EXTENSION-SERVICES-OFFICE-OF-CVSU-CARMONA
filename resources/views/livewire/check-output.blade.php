<div>
    {{-- Success is as dangerous as failure. --}}
    <div class="modal fade" id="outputCheckModal" tabindex="-1" aria-labelledby="outputCheckModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="outputCheckModalLabel">Confirm Output Check</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="checkActId" />
                    <p>Are you sure you want to check the output for the activity: <span id="checkActName"></span>?</p>
                </div>
                <div class="modal-footer">
                    <span class="ms-2 small" id="loadingSpanOutput" style="display: none;">Searching for output..</span>
                    <button type="button" class="btn btn-primary" id="confirmCheckOutput">Yes, Check Output</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelCheckOutput">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <button type="button" id="openOutput" class="d-none" data-bs-toggle="modal" data-bs-target="#outputDetailsModal"></button>

    <div class="modal fade" id="outputDetailsModal" tabindex="-1" aria-labelledby="outputDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="outputDetailsModalLabel"> @if ($outputactivity != null){{ 'Outputs for ' . $outputactivity->actname }} @endif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    @if ($outputTypes != [])

                    @foreach ($outputTypes as $outputType)
                    <div>
                        <p class="lh-base fw-bold ps-3">{{ $outputType }}</p>
                        @foreach ($outputs as $output)
                        @if ($output->output_type === $outputType)
                        <p class="lh-1 ps-5" data-id="{{ $output->id }}">
                            {{ $output->output_name . ': ' . $output->totaloutput_submitted }} /
                            <span class="expectedoutput">{{ $output->expectedoutput }}</span>
                        </p>
                        @endif
                        @endforeach
                    </div>
                    @endforeach
                    @else
                    <div class="text-center">
                        <h5><i>No Outputs Set Yet.</i></h5>
                    </div>
                    @endif

                </div>




                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            document.getElementById('confirmCheckOutput').addEventListener('click', function() {

                var checkActId = document.getElementById('checkActId').value;
                document.getElementById('loadingSpanOutput').style.display = "inline-block";
                document.getElementById('confirmCheckOutput').disabled = true;
                Livewire.emit('showOutput', checkActId);
            });
            Livewire.on('successShow', function() {
                document.getElementById('loadingSpanOutput').style.display = "none";
                document.getElementById('confirmCheckOutput').disabled = false;
                document.getElementById('cancelCheckOutput').click();
                document.getElementById('openOutput').click();
            });
        });
    </script>
</div>