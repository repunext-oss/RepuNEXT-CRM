<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of availabilities
     */
public function index()
{
    // Fetch availabilities with user details
    $availabilities = Availability::with('user')
        ->where('is_active', true)
        ->orderBy('user_id')
        ->orderBy('day_of_week')
        ->get();

    // Fetch users with status 0 (example)
    $users = User::where('status', 0)->get();

    // Initialize $rolerawdata as an empty array to avoid errors if the user is not logged in
    $rolerawdata = [];

    // Check if the user is authenticated
    if (auth()->check()) {
        // Fetch roles from the authenticated user (if any)
        // Ensure that the 'roles' relationship is defined on the User model
        if (auth()->user()->roles) {
            $rolerawdata = auth()->user()->roles->pluck('name')->toArray(); // Assuming roles is a relationship
        }
    }

    // Pass data to the view
    return view('admin.availability.index', compact('availabilities', 'users', 'rolerawdata'));
}


    /**
     * Show the form for creating a new availability
     */
    public function create()
    {
        $users = User::where('status', 0)->get();
        $daysOfWeek = [
            'Monday' => 'Monday',
            'Tuesday' => 'Tuesday', 
            'Wednesday' => 'Wednesday',
            'Thursday' => 'Thursday',
            'Friday' => 'Friday',
            'Saturday' => 'Saturday',
            'Sunday' => 'Sunday'
        ];

        return view('admin.availability.create', compact('users', 'daysOfWeek'));
    }



    /**
     * Store a newly created availability
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'availability_type' => 'required|in:regular,exception,holiday',
                'exception_date' => 'nullable|date|required_if:availability_type,exception',
                'notes' => 'nullable|string|max:500',
                'is_available' => 'boolean',
                'is_active' => 'boolean'
            ]);

            $availability = Availability::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Availability created successfully',
                'data' => $availability->load('user')
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create availability',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified availability
     */
    public function show($id)
    {
        $availability = Availability::with('user')->findOrFail($id);
        return view('admin.availability.show', compact('availability'));
    }

    /**
     * Show the form for editing the specified availability
     */
    public function edit($id)
    {
        $availability = Availability::findOrFail($id);
        $users = User::where('status', 0)->get();
        $daysOfWeek = [
            'Monday' => 'Monday',
            'Tuesday' => 'Tuesday', 
            'Wednesday' => 'Wednesday',
            'Thursday' => 'Thursday',
            'Friday' => 'Friday',
            'Saturday' => 'Saturday',
            'Sunday' => 'Sunday'
        ];

        return view('admin.availability.edit', compact('availability', 'users', 'daysOfWeek'));
    }

    /**
     * Update the specified availability
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $availability = Availability::findOrFail($id);

            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'availability_type' => 'required|in:regular,exception,holiday',
                'exception_date' => 'nullable|date|required_if:availability_type,exception',
                'notes' => 'nullable|string|max:500',
                'is_available' => 'boolean',
                'is_active' => 'boolean'
            ]);

            $availability->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Availability updated successfully',
                'data' => $availability->load('user')
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update availability',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified availability
     */
    public function destroy($id): JsonResponse
    {
        try {
            $availability = Availability::findOrFail($id);
            $availability->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Availability deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete availability',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get availability for a specific user
     */
    public function getUserAvailability($userId): JsonResponse
    {
        try {
            $availabilities = Availability::where('user_id', $userId)
                ->where('is_active', true)
                ->orderBy('day_of_week')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $availabilities
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch availability',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get availability for a specific date range
     */
    public function getAvailabilityForDateRange(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date'
            ]);

            $startDate = $validated['start_date'];
            $endDate = $validated['end_date'];
            $userId = $validated['user_id'];

            $availabilities = [];

            // Get all regular availabilities for the user
            $regularAvailabilities = Availability::where('user_id', $userId)
                ->where('availability_type', 'regular')
                ->where('is_available', true)
                ->where('is_active', true)
                ->get();

            // Get all exceptions for the date range
            $exceptions = Availability::where('user_id', $userId)
                ->where('availability_type', 'exception')
                ->where('exception_date', '>=', $startDate)
                ->where('exception_date', '<=', $endDate)
                ->where('is_active', true)
                ->get();

            // Generate availability for each date in the range
            $currentDate = Carbon::parse($startDate);
            $endDateObj = Carbon::parse($endDate);

            while ($currentDate->lte($endDateObj)) {
                $dateString = $currentDate->format('Y-m-d');
                $dayOfWeek = $currentDate->format('l'); // Monday, Tuesday, etc.

                // Check for exceptions first
                $exception = $exceptions->where('exception_date', $dateString)->first();

                if ($exception) {
                    if ($exception->is_available) {
                        $availabilities[$dateString] = [
                            'date' => $dateString,
                            'day_of_week' => $dayOfWeek,
                            'start_time' => $exception->start_time,
                            'end_time' => $exception->end_time,
                            'type' => 'exception',
                            'notes' => $exception->notes
                        ];
                    }
                } else {
                    // Check for regular availability
                    $regular = $regularAvailabilities->where('day_of_week', $dayOfWeek)->first();
                    if ($regular) {
                        $availabilities[$dateString] = [
                            'date' => $dateString,
                            'day_of_week' => $dayOfWeek,
                            'start_time' => $regular->start_time,
                            'end_time' => $regular->end_time,
                            'type' => 'regular',
                            'notes' => $regular->notes
                        ];
                    }
                }

                $currentDate->addDay();
            }

            return response()->json([
                'status' => 'success',
                'data' => array_values($availabilities)
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch availability',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check availability for a specific date and time
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'date' => 'required|date',
                'start_time' => 'nullable|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i|after:start_time'
            ]);

            $isAvailable = Availability::isAvailable(
                $validated['user_id'],
                $validated['date'],
                $validated['start_time'] ?? null,
                $validated['end_time'] ?? null
            );

            return response()->json([
                'status' => 'success',
                'is_available' => $isAvailable
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to check availability',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available time slots for a specific date
     */
    public function getAvailableSlots(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'date' => 'required|date'
            ]);

            $slots = Availability::getAvailableSlots(
                $validated['user_id'],
                $validated['date']
            );

            return response()->json([
                'status' => 'success',
                'slots' => $slots
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get available slots',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for bulk creating availabilities
     */
    public function bulkCreateForm()
    {
        $users = User::where('status', 0)->get();
        return view('admin.availability.bulk-create', compact('users'));
    }

    /**
     * Show the form for checking availability
     */
    public function checkForm()
    {
        $users = User::where('status', 0)->get();
        return view('admin.availability.check', compact('users'));
    }

    /**
     * Show the calendar view
     */
    public function calendar()
    {
        $users = User::where('status', 0)->get();
        return view('admin.availability.calendar', compact('users'));
    }

    /**
     * Test availability for debugging
     */
    public function testAvailability(Request $request)
    {
        $userId = $request->input('user_id');
        $date = $request->input('date');
        
        $isAvailable = Availability::isAvailable($userId, $date);
        $slots = Availability::getAvailableSlots($userId, $date);
        
        return response()->json([
            'status' => 'success',
            'user_id' => $userId,
            'date' => $date,
            'is_available' => $isAvailable,
            'slots' => $slots,
            'day_of_week' => Carbon::parse($date)->format('l')
        ]);
    }

    public function debugAvailability()
    {
        $availabilities = Availability::with('user')->get();
        $data = [];
        
        foreach ($availabilities as $av) {
            $data[] = [
                'id' => $av->id,
                'user_name' => $av->user->name,
                'type' => $av->availability_type,
                'day_of_week' => $av->day_of_week,
                'exception_date' => $av->exception_date,
                'start_time' => $av->start_time,
                'end_time' => $av->end_time,
                'is_available' => $av->is_available,
                'is_active' => $av->is_active
            ];
        }
        
        return response()->json([
            'status' => 'success',
            'total_count' => count($data),
            'data' => $data
        ]);
    }

    /**
     * Bulk create availabilities for a user
     */
    public function bulkCreate(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'availabilities' => 'required|array|min:1',
                'availabilities.*.day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'availabilities.*.start_time' => 'required|date_format:H:i',
                'availabilities.*.end_time' => 'required|date_format:H:i|after:availabilities.*.start_time',
                'availabilities.*.is_available' => 'boolean'
            ]);

            $created = [];
            foreach ($validated['availabilities'] as $availabilityData) {
                $availability = Availability::create([
                    'user_id' => $validated['user_id'],
                    'availability_type' => 'regular',
                    'is_active' => true,
                    ...$availabilityData
                ]);
                $created[] = $availability;
            }

            return response()->json([
                'status' => 'success',
                'message' => count($created) . ' availabilities created successfully',
                'data' => $created
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create availabilities',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle availability status
     */
    public function toggleStatus($id): JsonResponse
    {
        try {
            $availability = Availability::findOrFail($id);
            $availability->update([
                'is_available' => !$availability->is_available
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Availability status updated successfully',
                'data' => $availability->load('user')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update availability status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
