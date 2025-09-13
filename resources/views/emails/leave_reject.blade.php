<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $details['subject'] ?? 'Leave Notification' }}</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; background-color: #ffffff; padding: 20px; line-height: 1.6;">

    <p>Hi {{ $details['username'] ?? 'Employee' }},</p>

    <p>Your leave request has been <strong>rejected</strong>.</p>

    <p><strong>Reason:</strong> {{ $details['reason'] ?? 'Not specified' }}</p>

    <p>
        Best Regards,<br>
        HR Team
    </p>

</body>
</html>
