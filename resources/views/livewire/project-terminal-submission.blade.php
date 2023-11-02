<div>
    <div class="dropdown-menu border-warning">
        <a class="dropdown-item small hrefnav accept-link" wire:click="accept"><b class="small">Accept</b></a>
        <a class="dropdown-item small hrefnav reject-link" data-bs-toggle="modal" data-bs-target="#myModal"><b class="small">For Revision</b></a>
    </div>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">For Revision</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label class="form-label">Notes:</label>
                    <textarea class="form-control" id="notes" rows="5" placeholder="Input your notes here ..."></textarea>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {

            document.getElementById('submitBtn').addEventListener('click', function() {
                var notes = document.getElementById('notes').value;
                Livewire.emit('reject', notes);
            });
        });
    </script>

</div>