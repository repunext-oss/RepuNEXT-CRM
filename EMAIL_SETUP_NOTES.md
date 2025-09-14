# Email Notification Setup for Jira Task Assignment

## Overview
The system now sends email notifications when tasks are assigned to users in the Jira board. This includes:
- When creating a new task with an assignee
- When updating a task and changing the assignee
- When using the assign task functionality

## Files Created/Modified

### 1. Mailable Class
- `app/Mail/TaskAssignedMail.php` - Handles email composition and sending

### 2. Email Template
- `resources/views/emails/task-assigned.blade.php` - Professional HTML email template

### 3. Controller Updates
- `app/Http/Controllers/JiraTaskController.php` - Added email notifications to:
  - `store()` method - When creating tasks with assignees
  - `update()` method - When changing assignees
  - `assignTask()` method - When assigning tasks

### 4. Test Command
- `app/Console/Commands/TestTaskAssignmentEmail.php` - For testing email functionality

## Email Configuration

To enable email notifications, configure your `.env` file with appropriate mail settings:

```env
# For SMTP (Gmail example)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# For local testing with mailtrap
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=test@example.com
MAIL_FROM_NAME="Task Management System"
```

## Testing Email Functionality

### Method 1: Using the Test Command
```bash
php artisan test:task-email user@example.com
php artisan test:task-email user@example.com 1  # Test with specific task ID
```

### Method 2: Through the Application
1. Create a new task with an assignee
2. Update an existing task's assignee
3. Use the assign task functionality on the board

## Email Template Features

The email template includes:
- **Professional Design**: Modern, responsive layout with gradients and shadows
- **Task Information**: Complete task details including priority, status, due date
- **User Information**: Assignee and reporter details with avatars
- **Action Buttons**: Direct links to view task details and board
- **Mobile Responsive**: Optimized for all device sizes
- **Visual Indicators**: Color-coded priority and status badges

## Error Handling

The system includes robust error handling:
- Email failures are logged but don't break the application
- Try-catch blocks prevent email errors from affecting task operations
- Detailed error logging for debugging

## Queue Support

The mailable class implements `ShouldQueue` for better performance:
- Emails are queued for background processing
- Prevents blocking the user interface during email sending
- Requires queue worker to be running: `php artisan queue:work`

## Customization

### Modifying Email Template
Edit `resources/views/emails/task-assigned.blade.php` to customize:
- Colors and styling
- Content layout
- Additional information
- Branding elements

### Modifying Email Content
Edit `app/Mail/TaskAssignedMail.php` to customize:
- Email subject line
- Data passed to template
- Email headers and metadata

## Troubleshooting

### Common Issues
1. **Emails not sending**: Check mail configuration in `.env`
2. **Template not found**: Clear view cache: `php artisan view:clear`
3. **Queue not working**: Start queue worker: `php artisan queue:work`
4. **Permission errors**: Check file permissions on storage and logs directories

### Debug Mode
For debugging, you can:
1. Set `MAIL_MAILER=log` to log emails instead of sending
2. Check `storage/logs/laravel.log` for email-related errors
3. Use the test command to verify functionality

## Security Considerations

- Email addresses are validated before sending
- No sensitive information is included in emails
- Email content is escaped to prevent XSS attacks
- Queue system prevents email flooding

## Performance Notes

- Emails are sent asynchronously using queues
- Template caching improves performance
- Database queries are optimized with eager loading
- Failed emails are logged for retry attempts
