$(document).ready(function() {
    
    $(document).on('input', '.autocapital', function() {
        var inputValue = $(this).val();
        if (inputValue.length > 0) {
            $(this).val(inputValue.charAt(0).toUpperCase() + inputValue.slice(1));
        }
    });

    
$('#confirmactivity').click((event) => {
    event.preventDefault();
    
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
    
});



});