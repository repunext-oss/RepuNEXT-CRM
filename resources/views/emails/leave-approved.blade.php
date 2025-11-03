<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 30px 0;
        }
        .email-container {
            max-width: 700px;
            background-color: #ffffff;
            margin: 0 auto;
            padding: 30px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .email-header {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #202124;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            color: #333;
        }
        .message-content {
            font-size: 15px;
            color: #444;
            line-height: 1.6;
        }
        .footer {
            margin-top: 40px;
            font-size: 13px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            {{ $subject }}
        </div>

        <div class="greeting">
            Hello, {{ $username }}
        </div>

        <div class="message-content">
            {{ $body }}
        </div>

        <div class="footer">
            Best Regards,<br>
            <strong>HR Team</strong><br>
            RepuNEXT
        </div>
    </div>
</body>
</html>
