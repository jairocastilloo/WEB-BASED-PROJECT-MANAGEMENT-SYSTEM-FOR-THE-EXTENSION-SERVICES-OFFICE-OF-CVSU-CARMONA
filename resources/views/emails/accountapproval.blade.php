<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $subject }}</title>
</head>

<body>
    <p>Dear {{ $name }},</p>

    <p>We are excited to inform you that the admin has approved your account as a {{ $role }}. You are now a part of our team in the role of {{ $role }}.</p>

    <p><strong>Account Details:</strong></p>
    <ul>
        <li><strong>Username:</strong> {{ $username }}</li>
        <li><strong>Email:</strong> {{ $email }}</li>
        <li><strong>Role:</strong> {{ $role }}</li>
    </ul>

    <p>You can now access your account and start performing your duties as a {{ $role }}. If you have any questions or require assistance, please do not hesitate to contact us.</p>

    <p>Thank you for choosing to be a part of our organization, and we look forward to your valuable contributions as a {{ $role }}.</p>

    <p>Best regards,<br>
        Cavite State University-Carmona Extension Services Office</p>
</body>

</html>