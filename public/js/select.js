$(document).ready(function() {
    

$('#confirmactivity').click((event) => {
    event.preventDefault();
    
    var incrementedid = $('#incrementedID').val();
    var department = $('#department').val();
    var activityname = $('#activityname').val();

    var acturl = $('#acturl').attr('data-url');
    acturl = acturl.replace(':activityid', incrementedid);
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
        window.location.href = acturl;
        
    },
    error: function(xhr, status, error) {
        console.log(xhr.responseText);
        console.error(error);
        
    }
    });
    
});



});