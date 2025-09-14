<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Assigned - {{ $task->task_key }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 30px;
        }
        .task-info {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            padding: 25px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .task-title {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .task-key {
            background: #667eea;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 15px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0;
        }
        .info-item {
            background: white;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }
        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 14px;
            font-weight: 500;
            color: #2c3e50;
        }
        .priority-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }
        .priority-high {
            background: #e74c3c;
            color: white;
        }
        .priority-medium {
            background: #f39c12;
            color: white;
        }
        .priority-low {
            background: #27ae60;
            color: white;
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }
        .status-todo {
            background: #3498db;
            color: white;
        }
        .status-in-progress {
            background: #f39c12;
            color: white;
        }
        .status-review {
            background: #9b59b6;
            color: white;
        }
        .status-done {
            background: #27ae60;
            color: white;
        }
        .description {
            background: white;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            margin: 20px 0;
        }
        .description h3 {
            margin: 0 0 10px 0;
            color: #2c3e50;
            font-size: 16px;
        }
        .description p {
            margin: 0;
            color: #555;
            line-height: 1.6;
        }
        .action-buttons {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin: 0 10px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 12px;
            border-top: 1px solid #e9ecef;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        .user-info {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
            margin-right: 15px;
        }
        .user-details h4 {
            margin: 0;
            color: #2c3e50;
            font-size: 14px;
        }
        .user-details p {
            margin: 0;
            color: #7f8c8d;
            font-size: 12px;
        }
        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            .container {
                margin: 10px;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🎯 New Task Assigned</h1>
            <p>You have been assigned a new task</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Task Information -->
            <div class="task-info">
                <div class="task-title">{{ $task->title }}</div>
                <span class="task-key">{{ $task->task_key }}</span>
                
                <!-- Task Details Grid -->
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Priority</div>
                        <div class="info-value">
                            <span class="priority-badge priority-{{ $task->priority }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="status-badge status-{{ $task->status }}">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Type</div>
                        <div class="info-value">{{ ucfirst($task->type) }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Story Points</div>
                        <div class="info-value">{{ $task->story_points ?? 'Not set' }}</div>
                    </div>
                </div>

                @if($task->due_date)
                <div class="info-item" style="margin-top: 15px;">
                    <div class="info-label">Due Date</div>
                    <div class="info-value">
                        <strong>{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</strong>
                    </div>
                </div>
                @endif

                @if($task->project)
                <div class="info-item" style="margin-top: 15px;">
                    <div class="info-label">Project</div>
                    <div class="info-value">
                        <strong>{{ $task->project->project_name }}</strong>
                    </div>
                </div>
                @endif
            </div>

            <!-- Description -->
            @if($task->description)
            <div class="description">
                <h3>📝 Description</h3>
                <p>{{ $task->description }}</p>
            </div>
            @endif

            <!-- Reporter Information -->
            @if($reporter)
            <div class="info-item">
                <div class="info-label">Reporter</div>
                <div class="user-info">
                    <div class="user-avatar">{{ substr($reporter->name, 0, 1) }}</div>
                    <div class="user-details">
                        <h4>{{ $reporter->name }}</h4>
                        <p>{{ $reporter->email }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ $taskUrl }}" class="btn btn-primary">View Task Details</a>
                <a href="{{ $boardUrl }}" class="btn btn-secondary">Go to Board</a>
            </div>

            <!-- Additional Information -->
            <div style="background: #f8f9fa; padding: 20px; border-radius: 6px; margin-top: 20px;">
                <h3 style="margin: 0 0 10px 0; color: #2c3e50; font-size: 16px;">📋 What's Next?</h3>
                <ul style="margin: 0; padding-left: 20px; color: #555;">
                    <li>Review the task requirements and description</li>
                    <li>Update the task status as you begin working</li>
                    <li>Add comments and updates as needed</li>
                    <li>Upload any relevant attachments</li>
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is an automated notification from your project management system.</p>
            <p>If you have any questions, please contact your project manager.</p>
            <p>
                <a href="{{ route('dashboard') }}">Dashboard</a> | 
                <a href="{{ route('jira-tasks.board') }}">Task Board</a>
            </p>
        </div>
    </div>
</body>
</html>
