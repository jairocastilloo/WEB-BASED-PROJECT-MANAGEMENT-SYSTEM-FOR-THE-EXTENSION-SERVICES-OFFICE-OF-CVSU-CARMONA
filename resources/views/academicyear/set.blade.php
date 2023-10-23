@extends('layouts.app')


@section('content')
<div class="admincontainer p-0 border border-start border-end border-bottom border-top-0">
    <div class="mainnav border-bottom mb-3 shadow-sm px-2">
        <div class="border-2 border-start border-end p-2 currentdiv">
            Fiscal Years
        </div>
        <div class="border-2 border-end p-2 divhover" id="editAccounts">
            Academic Years
        </div>
    </div>
    @if(Auth::user()->role === 'Admin')

    @livewire('set-academic-year')


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
            $('#account .dropdown-menu').toggleClass('shows');
        });

        $('.datepicker').datepicker();
        $(document).on('click', '.editdates', function() {
            var parentdiv = $(this).closest('tr');

            var academicyear = parentdiv.find('.academicyear').text();
            var academicyearstartdate = parentdiv.find('.academicyearstartdate').text();
            var academicyearenddate = parentdiv.find('.academicyearenddate').text();
            var firstsemstartdate = parentdiv.find('.firstsemstartdate').text();
            var firstsemenddate = parentdiv.find('.firstsemenddate').text();
            var secondsemstartdate = parentdiv.find('.secondsemstartdate').text();
            var secondsemenddate = parentdiv.find('.secondsemenddate').text();
            $('#academicyearid').val(parentdiv.attr('data-id'));
            $('#academicyear').text(academicyear);
            $('#aystartdate').val(academicyearstartdate);
            $('#ayenddate').val(academicyearenddate);
            $('#firstsemstartdate').val(firstsemstartdate);
            $('#firstsemenddate').val(firstsemenddate);
            $('#secondsemstartdate').val(secondsemstartdate);
            $('#secondsemenddate').val(secondsemenddate);
            $('#AYModal').modal('show');
        });
        $('#acadyear-btn').click(function() {
            var dataurl = $('#acadyearform').attr('data-url');
            var data1 = $('#acadyearform').serialize();


            // send data via AJAX
            $.ajax({
                url: dataurl,
                type: 'POST',
                data: data1,
                success: function(response) {
                    console.log(response);

                    window.location.href = "";

                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.error(error);

                }
            });
        });
    });
</script>
@endsection