<!DOCTYPE html>
<html>

<head>
    <title>{{ $subject }}</title>
</head>

<body>
    <p>
        Dear {{ $name }}, </br>
        We are pleased to inform you that you have been assigned to a new activity on our platform. Here are the details:
        </br></br>
        Activity Name: {{ $activityname }} </br>
        Assigned By: {{ $sendername }} </br>
        Deadline: {{ $activitydeadline }}</br>
        </br></br>
        You can access the activity by logging into your account on our platform. Once logged in, you will find the activity on your home page.
        </br></br>
        This assignment may require your attention, and we trust that you will complete it with your usual dedication and expertise. If you have any questions or need further assistance, please do not hesitate to reach out to us.
        </br></br>
        Thank you for your commitment to our projects. We appreciate your contributions to our team's success.
        </br></br>
        Best regards,
        </br></br>
        {{ $sendername }} </br>
        Cavite State University-Carmona Extension Services Office
        {{ $senderemail }}
    </p>
</body>

</html>