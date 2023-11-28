@extends('layouts.app')


@section('content')
<div class="admincontainer p-0 border border-start border-end border-bottom border-top-0">
    <div class="mainnav border-bottom mb-3 shadow-sm px-2">
        <div class="border-2 border-start border-end p-2 divhover" id="accountapproval">
            Account Approval
        </div>
        <div class="border-2 border-end p-2 currentdiv">
            Account Details
        </div>
        <!--
        <div class="border-2 border-end p-2 divhover" id="editAccounts">
            Account Management
        </div>
        <div class="border-2 border-end p-2 divhover" id="editAccounts">
            Submission Management
        </div>
        <div class="border-2 border-end p-2 divhover" id="editAccounts">
            Edit Accounts
        </div>
 -->



    </div>
    @if(Auth::user()->role === 'Admin')

    @livewire('edit-account')


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
        $('#accountapproval').click(function() {
            window.location.href = "{{ route('admin.manage') }}";
        });
        $(document).on('click', '.editdetails', function() {
            var parentdiv = $(this).closest('tr');

            var firstname = parentdiv.find('.firstname').text();
            var middlename = parentdiv.find('.middlename').text();
            var lastname = parentdiv.find('.lastname').text();
            var username = parentdiv.find('.username').text();
            var email = parentdiv.find('.email').text();
            var department = parentdiv.find('.dept').text();
            var role = parentdiv.find('.role').text();
            $('#userid').val(parentdiv.attr('data-value'));
            $('#firstname').val(firstname);
            $('#middlename').val(middlename);
            $('#lastname').val(lastname);
            $('#username').val(username);
            $('#email').val(email);
            $('#department').val(department);
            $('#role').val(role);
            $('#registrationModal').modal('show');
        });
    });
</script>

@endsection