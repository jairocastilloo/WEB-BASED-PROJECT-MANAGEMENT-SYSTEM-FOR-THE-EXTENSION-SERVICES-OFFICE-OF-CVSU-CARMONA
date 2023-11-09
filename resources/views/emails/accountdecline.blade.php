<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $subject }}</title>
</head>

<body>
    <p>Dear {{ $name }},</p>

    <p>We regret to inform you that your account has been declined by the admin. Unfortunately, your request to create account for our site has not been approved at this time.</p>

    <p><strong>Reason for Decline:</strong></p>
    <p>{{ $declineReason }}</p>

    <p>If you have any questions or require further information regarding this decision, please do not hesitate to contact us.</p>

    <p>We appreciate your interest in our organization, and we wish you the best in your future endeavors.</p>

    <p>Best regards,<br>
        Cavite State University-Carmona Extension Services Office</p>
</body>

</html>