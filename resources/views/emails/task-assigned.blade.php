<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Assigned - {{ $task->task_key }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }
        .task-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .task-key {
            background: #007bff;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
            margin-bottom: 15px;
            display: inline-block;
        }
        .info-row {
            margin: 10px 0;
            padding: 10px;
            background: white;
            border-radius: 3px;
        }
        .info-label {
            font-weight: bold;
            color: #666;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 5px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Task Assigned</h1>
    </div>

    <div class="content">
        <div class="task-title">{{ $task->title }}</div>
        <span class="task-key">{{ $task->task_key }}</span>
        
        <div class="info-row">
            <span class="info-label">Priority:</span> {{ ucfirst($task->priority) }}
        </div>
        
        <div class="info-row">
            <span class="info-label">Status:</span> {{ ucfirst(str_replace('_', ' ', $task->status)) }}
        </div>
        
        <div class="info-row">
            <span class="info-label">Type:</span> {{ ucfirst($task->type) }}
        </div>

        @if($task->due_date)
        <div class="info-row">
            <span class="info-label">Due Date:</span> {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
        </div>
        @endif

        @if($task->project)
        <div class="info-row">
            <span class="info-label">Project:</span> {{ $task->project->project_name }}
        </div>
        @endif

        @if($task->description)
        <div class="info-row">
            <span class="info-label">Description:</span><br>
            {!! $task->description !!}
        </div>
        @endif

        @if($reporter)
        <div class="info-row">
            <span class="info-label">Reporter:</span> {{ $reporter->name }}
        </div>
        @endif

        <div style="text-align: center; margin-top: 20px;"> 
            <a href="{{ $boardUrl }}" class="btn">Go to Board</a>
        </div>
    </div>

    <div class="footer">
        <p>This is an automated notification from your project management system.</p>
    </div>
</body>
</html>
