$(document).ready(function() {
$('#notificationBar').click(function(event){
    event.preventDefault();
    $('#notificationList .dropdown-menu').toggleClass('shows');
    var markAsReadUrl = $(this).attr('data-url');
    
    // Perform an Ajax request
    $.ajax({
      url: markAsReadUrl,
      method: "GET",
      dataType: "json",
      success: function(data) {
        // Handle the successful response, e.g., display a success message
        console.log("Notification marked as read:", data);
        
        // Redirect to another URL if the marking as read was successful
        window.location.href = "";
      },
      error: function(xhr, status, error) {
        // Handle Ajax errors, e.g., display an error message
        console.error("Error marking notification as read:", error);
      }
    });
})
});