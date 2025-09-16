<?php

namespace App\Http\Controllers;

use App\Models\JiraTask;
use App\Models\User;
use App\Models\ProjectDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssignedMail;
use App\Mail\TaskStatusChangedMail;

class JiraTaskController extends Controller
{
    /**
     * Display the Jira board with tasks organized by status
     */
    public function index()
    {
        if (Auth::check()) {
            session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
        }

        // Get tasks organized by status (excluding backlog - shown in separate page)
        $todoTasks = JiraTask::active()
            ->byStatus('todo')
            ->with(['assignee', 'reporter', 'project'])
            ->orderBy('id', 'DESC')
            ->get();

        $inProgressTasks = JiraTask::active()
            ->byStatus('in_progress')
            ->with(['assignee', 'reporter', 'project'])
            ->orderBy('id', 'DESC')
            ->get();

        $reviewTasks = JiraTask::active()
            ->byStatus('review')
            ->with(['assignee', 'reporter', 'project'])
            ->orderBy('id', 'DESC')
            ->get();

        $doneTasks = JiraTask::active()
            ->byStatus('done')
            ->with(['assignee', 'reporter', 'project'])
            ->orderBy('id', 'DESC')
            ->get();

        $users = User::where('status', 0)->get();
        $projects = ProjectDetail::where('project_status', 0)->get();

        return view('jira-tasks.board', compact(
            'todoTasks', 
            'inProgressTasks', 
            'reviewTasks', 
            'doneTasks', 
            'users', 
            'projects'
        ));
    }

    /**
     * Show the form for creating a new task
     */
    public function create()
    {
        if (Auth::check()) {
            session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
        }

        $users = User::where('status', 0)->get();
        $projects = ProjectDetail::where('project_status', 0)->get();
        
        return view('jira-tasks.create', compact('users', 'projects'));
    }

    /**
     * Store a newly created task
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:task,bug,story,epic',
            'priority' => 'required|in:low,medium,high,critical',
            'assignee_id' => 'nullable|exists:users,id',
            'project_id' => 'required|exists:project_details,id',
            'story_points' => 'required|in:0.5,1,2,4,6,8,10,12,16',
            'due_date' => 'required|date|after:today'
        ]);

        // Generate unique task key
        $taskKey = JiraTask::generateTaskKey($request->project_id);

        $task = new JiraTask();
        $task->task_key = $taskKey;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->type = $request->type;
        $task->priority = $request->priority;
        $task->assignee_id = $request->assignee_id;
        $task->reporter_id = session('name');
        $task->project_id = $request->project_id;
        $task->story_points = $request->story_points;
        $task->due_date = $request->due_date;
        $task->status = 'backlog'; // Default to backlog
        $task->is_active = true;


        // Handle attachments
        if ($request->hasFile('attachments')) {
            $files = [];
            foreach ($request->file('attachments') as $file) {
                $dateTime = date('dmyHis');
                $random = rand(10, 99);
                $extension = $file->getClientOriginalExtension();
                $filename = "rnboard-{$dateTime}{$random}." . $extension; 
                $file->move(public_path('upload/rn-board-tasks'), $filename);
                $files[] = $filename;
            }
            $task->attachments = $files;
        }

        $task->save();

        // Send email notification if task is assigned to someone
        if ($request->assignee_id) {
            $assignee = User::find($request->assignee_id);
            $reporter = User::find(session('name'));
            
            try {
                Mail::to($assignee->email)->send(new TaskAssignedMail($task, $assignee, $reporter));
            } catch (\Exception $e) {
                \Log::error('Failed to send task assignment email: ' . $e->getMessage());
                // Continue execution even if email fails
            }
        }

        return redirect()->route('jira-tasks.backlog')->with([
            'message' => 'Task created successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified task
     */
    public function show($id)
    {
        $task = JiraTask::with(['assignee', 'reporter', 'project'])->findOrFail($id);
        $users = User::where('status', 0)->get();
        return view('jira-tasks.show', compact('task', 'users'));
    }

    /**
     * Get task details for modal display
     */
    public function getTaskDetails($id)
    {
        $task = JiraTask::with(['assignee', 'reporter', 'project'])->findOrFail($id);
        $users = User::where('status', 0)->get();
        
        return response()->json([
            'success' => true,
            'task' => $task,
            'users' => $users
        ]);
    }

    /**
     * Show the form for editing the specified task
     */
    public function edit($id)
    {
        $task = JiraTask::findOrFail($id);
        $users = User::where('status', 0)->get();
        $projects = ProjectDetail::where('project_status', 0)->get();
        
        return view('jira-tasks.edit', compact('task', 'users', 'projects'));
    }

    /**
     * Update the specified task
     */
    public function update(Request $request, $id)
    {
        $task = JiraTask::with(['assignee', 'reporter', 'project'])->findOrFail($id);
        $previousAssigneeId = $task->assignee_id;

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:task,bug,story,epic',
            'priority' => 'required|in:low,medium,high,critical',
            'assignee_id' => 'nullable|exists:users,id',
            'project_id' => 'required|exists:project_details,id',
            'story_points' => 'required|in:0.5,1,2,4,6,8,10,12,16',
            'due_date' => 'required|date'
        ]);

        $task->title = $request->title;
        $task->description = $request->description;
        $task->type = $request->type;
        $task->priority = $request->priority;
        $task->assignee_id = $request->assignee_id;
        $task->project_id = $request->project_id;
        $task->story_points = $request->story_points;
        $task->due_date = $request->due_date;


        // Handle attachments
        if ($request->hasFile('attachments')) {
            $files = [];
            foreach ($request->file('attachments') as $file) {
                $dateTime = date('dmyHis');
                $random = rand(10, 99);
                $extension = $file->getClientOriginalExtension();
                $filename = "rnboard-{$dateTime}{$random}." . $extension;
                $file->move(public_path('upload/rn-board-tasks'), $filename);
                $files[] = $filename;
            }
            $task->attachments = $files;
        }

        $task->save();

        // Send email notification if assignee changed
        if ($request->assignee_id && $request->assignee_id != $previousAssigneeId) {
            $assignee = User::find($request->assignee_id);
            $reporter = $task->reporter;
            
            try {
                Mail::to($assignee->email)->send(new TaskAssignedMail($task, $assignee, $reporter));
            } catch (\Exception $e) {
                \Log::error('Failed to send task assignment email: ' . $e->getMessage());
                // Continue execution even if email fails
            }
        }

        return redirect()->route('jira-tasks.board')->with([
            'message' => 'Task updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified task
     */
    public function destroy($id)
    {
        $task = JiraTask::findOrFail($id);
        $task->is_active = false;
        $task->save();

        return redirect()->route('jira-tasks.board')->with([
            'message' => 'Task deleted successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Update task status (for drag and drop functionality)
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:jira_tasks,id',
            'status' => 'required|in:backlog,todo,in_progress,review,done'
        ]);

        $task = JiraTask::findOrFail($request->task_id);
        $oldStatus = $task->status;
        $newStatus = $request->status;
        
        // Check if trying to move to todo without assignee
        if ($newStatus === 'todo' && !$task->assignee_id) {
            return response()->json([
                'success' => false,
                'message' => 'Task must be assigned to someone before moving to To Do status!'
            ], 422);
        }
        
        // Track status transition dates
        if ($oldStatus !== $newStatus) {
            // Track when moved to todo
            if ($newStatus === 'todo' && $oldStatus !== 'todo') {
                $task->moved_to_todo_at = now();
            }
            
            // Track when moved to done
            if ($newStatus === 'done' && $oldStatus !== 'done') {
                $task->moved_to_done_at = now();
            }
        }
        
        $task->status = $newStatus;
        $task->save();

        // Send email notification only when task moves to todo status
        if ($oldStatus !== $newStatus && $newStatus === 'todo') {
            try {
                $recipients = collect();
                
                // Add assignee if exists
                if ($task->assignee) {
                    $recipients->push($task->assignee);
                }
                
                // Add reporter if exists and different from assignee
                if ($task->reporter && (!$task->assignee || $task->reporter->id !== $task->assignee->id)) {
                    $recipients->push($task->reporter);
                }
                
                // Send email to all recipients
                foreach ($recipients as $recipient) {
                    Mail::to($recipient->email)->send(
                        new TaskStatusChangedMail(
                            $task,
                            $oldStatus,
                            $newStatus,
                            $task->assignee,
                            $task->reporter,
                            Auth::user()
                        )
                    );
                }
            } catch (\Exception $e) {
                // Log the error but don't fail the status update
                \Log::error('Failed to send todo status email: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Task status updated successfully!'
        ]);
    }

    /**
     * Assign task to user
     */
    public function assignTask(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:jira_tasks,id',
            'assignee_id' => 'nullable|exists:users,id'
        ]);

        $task = JiraTask::with(['assignee', 'reporter', 'project'])->findOrFail($request->task_id);
        $previousAssigneeId = $task->assignee_id;
        $task->assignee_id = $request->assignee_id;
        $task->save();

        // Send email notification if task is assigned to someone new
        if ($request->assignee_id && $request->assignee_id != $previousAssigneeId) {
            $assignee = User::find($request->assignee_id);
            $reporter = $task->reporter;
            
            try {
                Mail::to($assignee->email)->send(new TaskAssignedMail($task, $assignee, $reporter));
            } catch (\Exception $e) {
                \Log::error('Failed to send task assignment email: ' . $e->getMessage());
                // Continue execution even if email fails
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Task assigned successfully!'
        ]);
    }

    /**
     * Display backlog view
     */
    public function backlog()
    {
        if (Auth::check()) {
            session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
        }

        $backlogTasks = JiraTask::active()
            ->byStatus('backlog')
            ->with(['assignee', 'reporter', 'project'])
            ->orderBy('id', 'DESC')
            ->get();

        $todoTasks = JiraTask::active()
            ->byStatus('todo')
            ->with(['assignee', 'reporter', 'project'])
            ->orderBy('updated_at', 'DESC')
            ->get();

        $users = User::where('status', 0)->get();
        $projects = ProjectDetail::where('project_status', 0)->get();

        return view('jira-tasks.backlog', compact('backlogTasks', 'todoTasks', 'users', 'projects'));
    }

    /**
     * Add a comment to a task
     */
    public function addComment(Request $request, $id)
    {
        $task = JiraTask::findOrFail($id);
        
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // Get current comments array or initialize empty array
        $comments = $task->comments ?? [];
        
        // Add new comment
        $newComment = [
            'id' => uniqid(),
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'comment' => $request->comment,
            'created_at' => now()->toISOString(),
            'updated_at' => now()->toISOString()
        ];
        
        $comments[] = $newComment;
        
        // Update task with new comments
        $task->comments = $comments;
        $task->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully',
            'comment' => $newComment
        ]);
    }

    /**
     * Delete a comment from a task
     */
    public function deleteComment(Request $request, $id)
    {
        $task = JiraTask::findOrFail($id);
        
        $request->validate([
            'comment_id' => 'required|string',
        ]);

        $comments = $task->comments ?? [];
        
        // Find and remove the comment
        $comments = array_filter($comments, function($comment) use ($request) {
            return $comment['id'] !== $request->comment_id;
        });
        
        // Re-index array
        $comments = array_values($comments);
        
        // Update task
        $task->comments = $comments;
        $task->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }
}