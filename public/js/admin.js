$(document).ready(function() {
    $(document).on('click', '.edit-account', function() {

        var editid = $(this).prev().val();
        
        var edituser = alluser.find(function(user) {
            return user.id == editid;
          });
          $("#name").val(edituser.name);
          $("#middle_name").val(edituser.middle_name);
          $("#last_name").val(edituser.last_name);
          $("#email").val(edituser.email);
          $("#role").val(edituser.role);
          $("#department").val(edituser.department);
          $("#password").val(edituser.password);
          
        $("#myModal").modal("show");
    });
});