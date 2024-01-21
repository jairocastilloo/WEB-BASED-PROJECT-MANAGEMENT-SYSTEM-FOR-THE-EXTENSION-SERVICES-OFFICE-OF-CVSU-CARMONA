<!DOCTYPE html>
<html>

<head>
    <title>{{ $subject }}</title>
</head>

<body>
    @if($tasktype === 'activity')
    <p>
        Dear {{ $name }}, </p>
    <p>We are pleased to inform you that you have been assigned to a new activity on our platform. Here are the details:</p>

    <p>Activity Name: {{ $taskname }}</p>
    <p>Assigned By: {{ $sendername }}</p>
    <p>Deadline: {{ $taskdeadline }}</p>

    <p>You can access the activity by logging into your account on our platform. Once logged in, you will find the activity on your home page.</p>

    <p>This assignment may require your attention, and we trust that you will complete it with your usual dedication and expertise. If you have any questions or need further assistance, please do not hesitate to reach out to us.</p>

    <p>Thank you for your commitment to our projects. We appreciate your contributions to our team's success.</p>

    <p>Best regards,</p>

    <p>{{ $sendername }}</p>
    <p>Cavite State University-Carmona Extension Services Office</p>
    <p>{{ $senderemail }}</p>


    @elseif ($tasktype === 'project')
    <p>Dear {{ $name }},</p>
    <p>
        We are pleased to inform you that you have been assigned to a new project on our platform. Here are the details:
    </p>

    <p>Project Name: {{ $taskname }}</p>
    <p>Assigned By: {{ $sendername }}</p>
    <p>Deadline: {{ $taskdeadline }}</p>
    <p>You can access the project by logging into your account on our platform. Once logged in, you will find the project on your home page.</p>
    <p>This assignment may require your attention, and we trust that you will complete it with your usual dedication and expertise. If you have any questions or need further assistance, please do not hesitate to reach out to us.</p>

    <p>Thank you for your commitment to our projects. We appreciate your contributions to our team's success. </p>
    <p>Best regards,</p>

    <p>{{ $sendername }}</p>
    <p>Cavite State University-Carmona Extension Services Office</p>
    <p>{{ $senderemail }}</p>

    @elseif ($tasktype === 'program')
    <p>Dear {{ $name }},</p>

    <p>We are pleased to inform you that you have been assigned to a new program on our platform. Here are the details:</p>

    <p><strong>Project Name:</strong> {{ $taskname }}</p>
    <p><strong>Assigned By:</strong> {{ $sendername }}</p>
    <p><strong>Deadline:</strong> {{ $taskdeadline }}</p>

    <p>You can access the program by logging into your account on our platform. Once logged in, you will find the program on your home page.</p>

    <p>This assignment may require your attention, and we trust that you will complete it with your usual dedication and expertise. If you have any questions or need further assistance, please do not hesitate to reach out to us.</p>

    <p>Thank you for your commitment to our programs. We appreciate your contributions to our team's success.</p>

    <p>Best regards,</p>
    <p>{{ $sendername }}</p>
    <p>Cavite State University-Carmona Extension Services Office</p>
    <p>{{ $senderemail }}</p>

    @elseif ($tasktype === 'subtask')
    <p>Dear {{ $name }},</p>

    <p>We are pleased to inform you that you have been assigned to a new task on our platform. Here are the details:
    </p>

    <p>Activity Name: {{ $taskname }}</p>
    <p>Assigned By: {{ $sendername }}</p>
    <p>Deadline: {{ $taskdeadline }}</p>
    <p>You can access the subtask by logging into your account on our platform. Once logged in, you will find the subtask on your home page.</p>
    <p>This assignment may require your attention, and we trust that you will complete it with your usual dedication and expertise. If you have any questions or need further assistance, please do not hesitate to reach out to us.</p>
    <p>Thank you for your commitment to our projects. We appreciate your contributions to our team's success.</p>

    <p>Best regards,</p>

    <p>{{ $sendername }}</p>
    <p>Cavite State University-Carmona Extension Services Office</p>
    <p>{{ $senderemail }}</p>
    @endif
</body>

</html>