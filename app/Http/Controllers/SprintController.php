<?php

namespace App\Http\Controllers;

use App\Models\Sprint;
use App\Models\JiraTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SprintController extends Controller
{
    /**
     * Display a listing of sprints
     */
    public function index()
    {
        $sprints = Sprint::active()
            ->withCount('tasks')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'sprints' => $sprints
        ]);
    }

    /**
     * Store a newly created sprint
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:planning,active'
        ]);

        // Check if there's already an active sprint and user is trying to create another active sprint
        if ($request->status === 'active') {
            $activeSprint = Sprint::where('status', 'active')->first();
            if ($activeSprint) {
                return response()->json([
                    'success' => false,
                    'message' => 'There is already an active sprint. Please complete it before creating a new active sprint.'
                ], 422);
            }
        }

        $sprint = Sprint::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sprint created successfully!',
            'sprint' => $sprint
        ]);
    }

    /**
     * Start a sprint (change status from planning to active)
     */
    public function start($id)
    {
        $sprint = Sprint::findOrFail($id);

        if ($sprint->status === 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Sprint is already active.'
            ], 422);
        }

        if (!in_array($sprint->status, ['planning'])) {
            return response()->json([
                'success' => false,
                'message' => 'Only planning sprints can be started.'
            ], 422);
        }

        // Check if there's already an active sprint
        $activeSprint = Sprint::where('status', 'active')->where('id', '!=', $id)->first();
        if ($activeSprint) {
            return response()->json([
                'success' => false,
                'message' => 'There is already an active sprint. Please complete it before starting a new one.'
            ], 422);
        }

        $sprint->status = 'active';
        $sprint->save();

        return response()->json([
            'success' => true,
            'message' => 'Sprint started successfully!',
            'sprint' => $sprint
        ]);
    }

    /**
     * Complete a sprint and move incomplete tasks to backlog
     */
    public function complete($id)
    {
        $sprint = Sprint::findOrFail($id);

        if ($sprint->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Only active sprints can be completed.'
            ], 422);
        }

        DB::transaction(function () use ($sprint) {
            // Move all incomplete tasks back to backlog
            $incompleteTasks = $sprint->tasks()
                ->whereIn('status', ['todo', 'in_progress', 'review'])
                ->get();

            foreach ($incompleteTasks as $task) {
                $task->status = 'backlog';
                $task->sprint_id = null; // Remove from sprint
                $task->save();
            }

            // Mark sprint as completed
            $sprint->status = 'completed';
            $sprint->save();
        });

        return response()->json([
            'success' => true,
            'message' => 'Sprint completed successfully! Incomplete tasks have been moved to backlog.',
            'sprint' => $sprint
        ]);
    }

    /**
     * Add tasks to sprint
     */
    public function addTasks(Request $request, $id)
    {
        $sprint = Sprint::findOrFail($id);

        $request->validate([
            'task_ids' => 'required|array',
            'task_ids.*' => 'exists:jira_tasks,id'
        ]);

        $tasks = JiraTask::whereIn('id', $request->task_ids)->get();

        foreach ($tasks as $task) {
            // Only add tasks that are in backlog
            if ($task->status === 'backlog') {
                $task->sprint_id = $sprint->id;
                $task->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Tasks added to sprint successfully!'
        ]);
    }

    /**
     * Remove task from sprint
     */
    public function removeTask(Request $request, $id)
    {
        $sprint = Sprint::findOrFail($id);

        $request->validate([
            'task_id' => 'required|exists:jira_tasks,id'
        ]);

        $task = JiraTask::findOrFail($request->task_id);
        
        if ($task->sprint_id === $sprint->id) {
            $task->sprint_id = null;
            $task->status = 'backlog'; // Move back to backlog
            $task->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Task removed from sprint successfully!'
        ]);
    }

    /**
     * Get current active sprint
     */
    public function getCurrentSprint()
    {
        $sprint = Sprint::where('status', 'active')
            ->with(['tasks.assignee', 'tasks.reporter', 'tasks.project'])
            ->first();

        if (!$sprint) {
            return response()->json([
                'success' => false,
                'message' => 'No active sprint found'
            ], 404);
        }

        // Organize tasks by status
        $tasksByStatus = [
            'todo' => $sprint->tasks->where('status', 'todo')->values(),
            'in_progress' => $sprint->tasks->where('status', 'in_progress')->values(),
            'review' => $sprint->tasks->where('status', 'review')->values(),
            'done' => $sprint->tasks->where('status', 'done')->values(),
        ];

        return response()->json([
            'success' => true,
            'sprint' => $sprint,
            'tasks' => $tasksByStatus,
            'progress' => $sprint->getProgressPercentage(),
            'total_story_points' => $sprint->getTotalStoryPoints(),
            'completed_story_points' => $sprint->getCompletedStoryPoints()
        ]);
    }

    /**
     * Update sprint details
     */
    public function update(Request $request, $id)
    {
        $sprint = Sprint::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        $sprint->update([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sprint updated successfully!',
            'sprint' => $sprint
        ]);
    }

    /**
     * Delete sprint
     */
    public function destroy($id)
    {
        $sprint = Sprint::findOrFail($id);

        if ($sprint->status === 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete an active sprint. Please complete it first.'
            ], 422);
        }

        // Remove sprint_id from all tasks
        $sprint->tasks()->update(['sprint_id' => null]);

        $sprint->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sprint deleted successfully!'
        ]);
    }

    /**
     * Get sprint details with closed tickets
     */
    public function show($id)
    {
        $sprint = Sprint::with(['tasks.assignee', 'tasks.reporter', 'tasks.project'])
            ->findOrFail($id);

        // Get closed tickets (status = 'done')
        $closedTickets = $sprint->tasks()
            ->where('status', 'done')
            ->with(['assignee', 'reporter', 'project'])
            ->orderBy('moved_to_done_at', 'desc')
            ->get();

        // Get all tickets for statistics
        $allTickets = $sprint->tasks()->get();
        $totalTickets = $allTickets->count();
        $closedTicketsCount = $closedTickets->count();
        $incompleteTickets = $allTickets->where('status', '!=', 'done');

        // Calculate statistics
        $completionRate = $totalTickets > 0 ? round(($closedTicketsCount / $totalTickets) * 100, 1) : 0;
        $totalStoryPoints = $allTickets->sum('story_points') ?? 0;
        $completedStoryPoints = $closedTickets->sum('story_points') ?? 0;

        return response()->json([
            'success' => true,
            'sprint' => $sprint,
            'closedTickets' => $closedTickets,
            'incompleteTickets' => $incompleteTickets,
            'statistics' => [
                'total_tickets' => $totalTickets,
                'closed_tickets' => $closedTicketsCount,
                'incomplete_tickets' => $incompleteTickets->count(),
                'completion_rate' => $completionRate,
                'total_story_points' => $totalStoryPoints,
                'completed_story_points' => $completedStoryPoints,
                'remaining_story_points' => $totalStoryPoints - $completedStoryPoints
            ]
        ]);
    }

    /**
     * Get all sprints with their statistics
     */
    public function getAllSprints()
    {
        $sprints = Sprint::withCount(['tasks as total_tasks', 'tasks as closed_tasks' => function($query) {
            $query->where('status', 'done');
        }])
        ->with(['tasks' => function($query) {
            $query->select('sprint_id', 'story_points', 'status');
        }])
        ->orderBy('created_at', 'desc')
        ->get();

        $sprintsWithStats = $sprints->map(function($sprint) {
            $totalStoryPoints = $sprint->tasks->sum('story_points') ?? 0;
            $completedStoryPoints = $sprint->tasks->where('status', 'done')->sum('story_points') ?? 0;
            $completionRate = $sprint->total_tasks > 0 ? round(($sprint->closed_tasks / $sprint->total_tasks) * 100, 1) : 0;

            return [
                'id' => $sprint->id,
                'name' => $sprint->name,
                'description' => $sprint->description,
                'start_date' => $sprint->start_date,
                'end_date' => $sprint->end_date,
                'status' => $sprint->status,
                'status_text' => $sprint->status_text,
                'total_tasks' => $sprint->total_tasks,
                'closed_tasks' => $sprint->closed_tasks,
                'completion_rate' => $completionRate,
                'total_story_points' => $totalStoryPoints,
                'completed_story_points' => $completedStoryPoints,
                'created_at' => $sprint->created_at,
                'updated_at' => $sprint->updated_at
            ];
        });

        return response()->json([
            'success' => true,
            'sprints' => $sprintsWithStats
        ]);
    }

    /**
     * Get closed tickets for a specific sprint
     */
    public function getClosedTickets($id)
    {
        $sprint = Sprint::findOrFail($id);

        $closedTickets = $sprint->tasks()
            ->where('status', 'done')
            ->with(['assignee', 'reporter', 'project'])
            ->orderBy('moved_to_done_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'sprint' => [
                'id' => $sprint->id,
                'name' => $sprint->name,
                'start_date' => $sprint->start_date,
                'end_date' => $sprint->end_date,
                'status' => $sprint->status
            ],
            'closedTickets' => $closedTickets,
            'totalClosed' => $closedTickets->count()
        ]);
    }
}