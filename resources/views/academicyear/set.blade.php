@extends('layouts.app')


@section('content')
<div class="admincontainer p-0 border border-start border-end border-bottom border-top-0">
    <div class="mainnav border-bottom mb-3 shadow-sm px-2">
        <div class="border-2 border-start border-end p-2 divhover" id="redirectFiscal">
            Fiscal Years
        </div>
        <div class="border-2 border-end p-2 currentdiv">
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

        $('#redirectFiscal').click(function() {
            window.location.href = "{{ route('fiscalYear.set') }}"
        });
        $('#searchDatePicker').datepicker();

        $('#searchDatePicker').datepicker().on('change', function(e) {
            $('#searchDatePicker').datepicker('hide');
        });

        $('#ayStartDatePicker').datepicker();

        $('#ayStartDatePicker').datepicker().on('change', function(e) {
            $('#ayStartDatePicker').datepicker('hide');
        });

        $('#ayEndDatePicker').datepicker();

        $('#ayEndDatePicker').datepicker().on('change', function(e) {
            $('#ayEndDatePicker').datepicker('hide');
        });

        $('#firstSemStartDatePicker').datepicker();

        $('#firstSemStartDatePicker').datepicker().on('change', function(e) {
            $('#firstSemStartDatePicker').datepicker('hide');
        });

        $('#firstSemEndDatePicker').datepicker();

        $('#firstSemEndDatePicker').datepicker().on('change', function(e) {
            $('#firstSemEndDatePicker').datepicker('hide');
        });

        $('#secondSemStartDatePicker').datepicker();

        $('#secondSemStartDatePicker').datepicker().on('change', function(e) {
            $('#secondSemStartDatePicker').datepicker('hide');
        });

        $('#secondSemEndDatePicker').datepicker();

        $('#secondSemEndDatePicker').datepicker().on('change', function(e) {
            $('#secondSemEndDatePicker').datepicker('hide');
        });
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
            $('#AYModalLabel').text("Edit Dates");
            $('#academicyear').text("( " + academicyear + " )");

            $('#aystartdate').val(academicyearstartdate);
            $('#ayenddate').val(academicyearenddate);
            $('#firstsemstartdate').val(firstsemstartdate);
            $('#firstsemenddate').val(firstsemenddate);
            $('#secondsemstartdate').val(secondsemstartdate);
            $('#secondsemenddate').val(secondsemenddate);
            $('#editOrAdd').val("edit");
            $('#AYModal').modal('show');
        });
        $('#addDates').click(function() {
            $('#academicyearid').val("");
            $('#academicyear').text("");
            $('#AYModalLabel').text("Add Academic Year");
            $('#aystartdate').val("");
            $('#ayenddate').val("");
            $('#firstsemstartdate').val("");
            $('#firstsemenddate').val("");
            $('#secondsemstartdate').val("");
            $('#secondsemenddate').val("");
            $('#editOrAdd').val("add");
            $('#AYModal').modal('show');
        });

    });
</script>
@endsection