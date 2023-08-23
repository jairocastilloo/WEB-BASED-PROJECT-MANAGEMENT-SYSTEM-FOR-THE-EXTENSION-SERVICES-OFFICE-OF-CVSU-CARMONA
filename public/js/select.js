$(document).ready(function() {
    
function acthasError(){

    var hasErrors = false;

    $('.invalid-feedback strong').text('');
    $('.is-invalid').removeClass('is-invalid');

    var actname = $('#activityname').val();
    var selectobjective = $('#objective-select').find(':selected');
    var objectivevalue = selectobjective.val();
    var expectedoutput = $('#expectedoutput').val();
    var actstartdate = $('#activitystartdate').val();
    var actenddate = $('#activityenddate').val();
    var projstartdate = $('#projsavestartdate').val();
    var projenddate = $('#projsaveenddate').val();
    var actbudget = $('#budget').val();
    var actsource = $('#source').val();



    // Validation for Project Title
    if (actname.trim() === '') {
        $('#activityname').addClass('is-invalid');
        $('#activityname').next('.invalid-feedback').find('strong').text('Activity Name is required.');
        hasErrors = true;
      }

    // Validation for Project Leader
    if (objectivevalue === "") {
        $('#objective-select').addClass('is-invalid');
        $('#objective-select').next('.invalid-feedback').find('strong').text('Make sure that there is an objective selected.');
        hasErrors = true;
      }

    // Validation for Program Title
    if (expectedoutput.trim() === '') {
        $('#expectedoutput').addClass('is-invalid');
        $('#expectedoutput').next('.invalid-feedback').find('strong').text('Expected Output is required.');
        hasErrors = true;
      }

      if (expectedoutput.trim() === '') {
        $('#expectedoutput').addClass('is-invalid');
        $('#expectedoutput').next('.invalid-feedback').find('strong').text('Expected Output is required.');
        hasErrors = true;
      }
   
    if (actstartdate === ''){
        $('#activitystartdate').addClass('is-invalid');
        $('#activitystartdate').next('.invalid-feedback').find('strong').text('Activity Start Date is required.');
        hasErrors = true;
    }
    // Validation for Project Start Date
    else if (new Date(projstartdate) > new Date(actstartdate)) {
        $('#activitystartdate').addClass('is-invalid');
        $('#activitystartdate').next('.invalid-feedback').find('strong').text('Activity Start Date must be after ' + new Date(projstartdate).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) + '.');
        hasErrors = true;
      }
      if (actenddate === ''){
        $('#activityenddate').addClass('is-invalid');
        $('#activityenddate').next('.invalid-feedback').find('strong').text('Activity End Date is required');
        hasErrors = true;
      }

      else if (new Date(actenddate) < new Date(actstartdate)) {
        $('#activityenddate').addClass('is-invalid');
        $('#activityenddate').next('.invalid-feedback').find('strong').text('Activity End Date must be after ' + new Date(actstartdate).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) + '.');
        hasErrors = true;
      }

      else if (new Date(projenddate) < new Date(actenddate)) {
        $('#activityenddate').addClass('is-invalid');
        $('#activityenddate').next('.invalid-feedback').find('strong').text('Activity End Date must be before ' + new Date(projenddate).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) + '.');
        hasErrors = true;
    }
    

      if (actbudget.trim() === '') {
        $('#budget').addClass('is-invalid');
        $('#budget').next('.invalid-feedback').find('strong').text('Budget is required.');
        hasErrors = true;
      }
      if (actsource.trim() === '') {
        $('#source').addClass('is-invalid');
        $('#source').next('.invalid-feedback').find('strong').text('Source of budget is required.');
        hasErrors = true;
      }
      return hasErrors;
}

    
    $('#confirmactivity').click((event) => {
        event.preventDefault();
        var activityhasError = acthasError();
            if (!activityhasError){
            var incrementedid = $('#incrementedID').val();
            var department = $('#department').val();
            var activityname = $('#activityname').val();

            var acturl = $('#acturl').attr('data-url');
                
            acturl = acturl.replace(':department', department);
            acturl = acturl.replace(':activityname', activityname);

            var dataurl = $('#act1').attr('data-url');
            var data1 = $('#act1').serialize();
            
            
            // send data via AJAX
                $.ajax({
                url: dataurl,
                type: 'POST',
                data: data1,
                success: function(response) {
                    console.log(response);
                    var actId = response.actid;
                    acturl = acturl.replace(':activityid', actId);
                    window.location.href = acturl;
                    
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.error(error);
                    
                }
                });
            }
        });



});