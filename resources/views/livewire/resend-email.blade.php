<div>

    <nav class='nav-pagelink d-flex justify-content-center'>
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" wire:click="changePage(1)">First</a>
            </li>
            @if ($currentPage === 1)
            <li class="page-item disabled">
                <span class="page-link" aria-hidden="true"><i class="bi bi-chevron-compact-left"></i></span>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" wire:click="changePage({{ $currentPage - 1 }})" rel="prev"><i class="bi bi-chevron-compact-left"></i></a>
            </li>
            @endif

            @for ($i = 1; $i <= $totalPages; $i++) <li class="page-item {{ $i === $currentPage ? 'active' : 'number-link' }}" aria-current="{{ $i === $currentPage ? 'page' : '' }}">
                <a class="page-link" wire:click="changePage({{ $i }})">{{ $i }}</a>
                </li>
                @endfor

                @if ($currentPage === $totalPages)
                <li class="page-item disabled">
                    <span class="page-link" aria-hidden="true"><i class="bi bi-chevron-compact-right"></i></span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" wire:click="changePage({{ $currentPage + 1 }})"><i class="bi bi-chevron-compact-right"></i></a>
                </li>
                @endif
                <li class="page-item">
                    <a class="page-link" wire:click="changePage({{ $totalPages }})">Last</a>
                </li>
        </ul>
    </nav>




    <div class="tablecontainer">
        <table class="approvaltable">
            <thead>
                <tr>
                    <th class="p-2 text-center bg-light subject">SUBJECT</th>
                    <th class="p-2 text-center bg-light reciEmail">RECIPIENT EMAIL</th>
                    <th class="p-2 text-center bg-light reciName">RECIPIENT NAME</th>
                    <th class="p-2 text-center bg-light senderEmail">SENDER EMAIL</th>
                    <th class="p-2 text-center bg-light senderName">SENDER NAME</th>
                    <th class="p-2 text-center bg-light initialSentDate">INITIAL SENT DATE</th>
                    <th class="p-2 text-center bg-light emailActions">ACTIONS</th>

                </tr>
            </thead>

            <tbody>
                @foreach($emailLogs as $emailLog)
                <tr>
                    <td class="p-2">{{ $emailLog->message }}</td>
                    <td class="p-2">{{ $emailLog->email }}</td>
                    <td class="p-2">{{ $emailLog->name }}</td>
                    <td class="p-2">{{ $emailLog->senderemail }}</td>
                    <td class="p-2">{{ $emailLog->sendername }}</td>
                    <td class="p-2">{{ date('F d, Y', strtotime($emailLog->created_at)) }}</td>
                    <td class="p-2">
                        <div class="text-center">

                            <button type="button" class="btn btn-sm btn-outline-success border shadow-sm resendEmail" data-value="{{ $emailLog->id }}">
                                <b class="small">Resend Email</b>
                            </button>

                            <span class="ms-2 small" id="loadingSpan[{{ $emailLog->id }}]" style="display: none;">Sending Email..</span>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="emailError[{{ $emailLog->id }}]" style="display: none;">
                                <!-- Your error message goes here -->
                                <strong>Error:</strong><span id="errorMessage[{{ $emailLog->id }}]"></span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            var resendButtons = document.getElementsByClassName('resendEmail');

            for (var i = 0; i < resendButtons.length; i++) {
                resendButtons[i].addEventListener('click', function() {
                    var id = this.getAttribute('data-value');
                    this.nextElementSibling.style.display = "inline-block";
                    Livewire.emit('sendEmail', id);
                });
            }

            Livewire.on('updateLoadingFailed', function(id, e) {
                document.getElementById('loadingSpan[' + id + ']').style.display = "none";
                document.getElementById('errorMessage[' + id + ']').textContent = e;
                document.getElementById('emailError[' + id + ']').style.display = "inline-block";

            });

        });
    </script>
</div>