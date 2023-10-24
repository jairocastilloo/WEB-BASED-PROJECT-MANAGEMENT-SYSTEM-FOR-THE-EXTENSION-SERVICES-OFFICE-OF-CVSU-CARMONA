@extends('layouts.app')


@section('content')
<div class="admincontainer p-0 border border-start border-end border-bottom border-top-0">
    <div class="mainnav border-bottom mb-3 shadow-sm px-2">
        <div class="border-2 border-start border-end p-2 currentdiv">
            Fiscal Years
        </div>
        <div class="border-2 border-end p-2 divhover" id="redirectAcademic">
            Academic Years
        </div>
    </div>
    @if(Auth::user()->role === 'Admin')

    @livewire('set-fiscal-year')


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

        $('#redirectAcademic').click(function() {
            window.location.href = "{{ route('acadyear.set') }}"
        });
        $('#searchDatePicker').datepicker();

        $('#searchDatePicker').datepicker().on('change', function(e) {
            $('#searchDatePicker').datepicker('hide');
        });
        $('#fiscalStartDatePicker').datepicker();

        $('#fiscalStartDatePicker').datepicker().on('change', function(e) {
            $('#fiscalStartDatePicker').datepicker('hide');
        });
        $('#fiscalEndDatePicker').datepicker();

        $('#fiscalEndDatePicker').datepicker().on('change', function(e) {
            $('#fiscalEndDatePicker').datepicker('hide');
        });


        $(document).on('click', '.editdates', function() {

            var parentdiv = $(this).closest('tr');

            var fiscalyear = parentdiv.find('.fiscalyear').text();
            var fiscalyearstartdate = parentdiv.find('.fiscalyearstartdate').text();
            var fiscalyearenddate = parentdiv.find('.fiscalyearenddate').text();

            $('#fiscalyearid').val(parentdiv.attr('data-id'));
            $('#fiscalModalLabel').text("Edit Dates");
            $('#fiscalyear').text("( " + fiscalyear + " )");

            $('#fiscalstartdate').val(fiscalyearstartdate);
            $('#fiscalenddate').val(fiscalyearenddate);

            $('#editOrAdd').val("edit");
            $('#fiscalModal').modal('show');

        });
        $('#addDates').click(function() {
            $('#fiscalyearid').val("");
            $('#fiscalyear').text("");
            $('#fiscalModalLabel').text("Add Fiscal Year");
            $('#fiscalstartdate').val("");
            $('#fiscalenddate').val("");
            $('#editOrAdd').val("add");
            $('#fiscalModal').modal('show');
        });

    });
</script>
@endsection