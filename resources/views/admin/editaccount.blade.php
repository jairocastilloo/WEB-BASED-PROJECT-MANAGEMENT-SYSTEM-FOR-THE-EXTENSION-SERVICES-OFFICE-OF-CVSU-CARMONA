@extends('layouts.app')


@section('content')
    <div class="maincontainer border border-start border-end border-bottom border-top-0">
        <div class="mainnav border-bottom mb-3 shadow-sm px-2">
            <div class="border-2 border-start border-end p-2 divhover" id="accountapproval">
                Account Approval
            </div>
            <div class="border-2 border-end p-2 currentdiv">
                Accounts
            </div>
           

        </div>
        @if (Auth::user()->role === 'Admin')
     <div class="container">
                @livewire('edit-account')
            </div>
        @else
            <h1>Sorry, this is exclusive for admin. 
                <a href="{{ route('tasks.show', ['username' => Auth::user()->username]) }}">Go back</a></h1>
        @endif
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
           
        $(document).on('input', '.autocapital', function() {
            var inputValue = $(this).val();
            if (inputValue.length > 0) {
                $(this).val(inputValue.charAt(0).toUpperCase() + inputValue.slice(1));
            }
        });
  

            $('#navbarDropdown').click(function() {
                // Add your function here
                $('.dropdown-menu').toggleClass('shows');
            });
            $('#accountapproval').click(function() {
                window.location.href = "{{ route('admin.manage') }}";
            });
            $(document).on('click', '.editdetails', function() {
                var parentdiv = $(this).closest('tr');
                var firstnamedata = parentdiv.find('.firstname').text();
var title = firstnamedata.split('.')[0].trim(); // Get the first part before the dot and remove leading/trailing spaces
var firstname = firstnamedata.split(' ').slice(1).join(' ').trim(); // Get the part after the first space and remove leading/trailing spaces

title = title + '.'; 

                var middlename = parentdiv.find('.middlename').text();
                var lastname = parentdiv.find('.lastname').text();
                var username = parentdiv.find('.username').text();
                var email = parentdiv.find('.email').text();
                var department = parentdiv.find('.dept').text();
                var role = parentdiv.find('.role').text();
                $('#userid').val(parentdiv.attr('data-value'));
                $('#title option[value="' + title + '"]').prop('selected', true);

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
