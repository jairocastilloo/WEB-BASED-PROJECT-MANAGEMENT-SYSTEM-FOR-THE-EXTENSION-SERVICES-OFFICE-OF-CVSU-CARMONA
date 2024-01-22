<div>
    {{-- Care about people's approval and you will be their prisoner. --}}

    <a class="dropdown-item small hrefnav border-bottom" href="#"><b class="small">Close Project</b></a>
    <div class="modal fade" id="closeProjectModal" tabindex="-1" aria-labelledby="closeProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="closeProjectModalLabel">Close Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Project Closing Form -->
                    <form action="/close-project" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- File Upload for Terminal Report -->
                        <div class="mb-3">
                            <label for="terminalReport" class="form-label">Terminal Report</label>
                            <input type="file" class="form-control" id="terminalReport" name="terminal_report" accept=".pdf, .docx">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-md rounded border border-1 btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-md rounded btn-gold shadow ">Close Project</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>