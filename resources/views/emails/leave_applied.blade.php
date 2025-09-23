<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $details['subject'] }}</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; background-color: #ffffff; padding: 20px; line-height: 1.6;">

    <p>Dear Abbas,</p>

    <p>
        I am writing to inform you that I am taking leave for <strong>{{ $details['total_days'] }}</strong> day(s).
    </p>

    <p>
        <strong>Name:</strong> {{ $details['username'] }}<br>
        <strong>Email:</strong> {{ $details['user_email'] }}<br>
        <strong>Leave Type:</strong> {{ $details['leave_type'] }}<br>
        <strong>Start Date:</strong> {{ $details['start_date'] }}<br>
        <strong>End Date:</strong> {{ $details['end_date'] }}<br>
        <strong>Total Days:</strong> {{ $details['total_days'] }} Days<br>
        <strong>Reason:</strong> {{ $details['reason'] }}
    </p>

    <p>
        I request your approval for this leave. Thank you for your understanding.
    </p>

    <p>
        Best Regards,<br>
        {{ $details['username'] }}
    </p>

 <p>
        <a href="{{ url('/leave/list' . $details['id']) }}" 
           style="display: inline-block; background-color: #28a745; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;">
            Approve or Rejected
        </a>
    </p>


</body>
</html>


