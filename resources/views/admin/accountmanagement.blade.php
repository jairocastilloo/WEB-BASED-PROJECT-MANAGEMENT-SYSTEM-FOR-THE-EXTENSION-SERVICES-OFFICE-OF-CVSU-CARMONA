@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mainnav border-bottom mb-3 shadow-sm px-2">
        <div class="border-2 border-start border-end p-2 currentdiv">
            Account Approval
        </div>
        <div class="border-2 border-end p-2 divhover" id="editAccounts">
            Account Management
        </div>
        <div class="border-2 border-end p-2 divhover" id="editAccounts">
            Submission Management
        </div>
        <div class="border-2 border-end p-2 divhover" id="editAccounts">
            Edit Accounts
        </div>
        <div class="border-2 border-end p-2 divhover" id="editAccounts">
            Edit Accounts
        </div>
        <div class="border-2 border-end p-2 divhover" id="editAccounts">
            Edit Accounts
        </div>



    </div>
    @if(Auth::user()->role === 'Admin')

    @livewire('account-approval')


    @else

    <h1>Sorry, this is exclusive for admin. <a href="{{ route('tasks.show', ['username' => Auth::user()->username]) }}">Go back</a></h1>

    @endif
</div>
@endsection
@section('scripts')

<script>
    $(document).ready(function() {
        $('#navbarDropdown').click(function() {
            // Add your function here
            $('.dropdown-menu').toggleClass('shows');
        });


        $('#editAccounts').click(function() {
            window.location.href = "{{ route('admin.editaccount') }}";
        });

        $('#searchAccount').on('keyup', function(e) {
            var inputData = $(this).val().toLowerCase();

            $('.accountRow').each(function() {
                var accountName = $(this).attr('data-name').toLowerCase();

                if (accountName.includes(inputData)) {
                    $(this).show();

                } else {
                    $(this).hide();
                }
            });

        });
        $('#searchEmail').on('keyup', function(e) {
            var inputData = $(this).val().toLowerCase();

            $('.accountRow').each(function() {
                var accountEmail = $(this).attr('data-email').toLowerCase();

                if (accountEmail.includes(inputData)) {
                    $(this).show();

                } else {
                    $(this).hide();
                }
            });

        });
    });
</script>

@endsection