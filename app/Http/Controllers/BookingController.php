<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    /**
     * Display the booking index page
     */
    public function index()
    {
        return view('admin.bk.add');
    }

    /**
     * Fetch all bookings
     */
    public function fetch(): JsonResponse
    {
        try {
            $bookings = Booking::all()->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'title' => $booking->title,
                    'description' => $booking->description,
                    'start' => $booking->start,
                    'end' => $booking->end,
                    'extendedProps' => [
                        'description' => $booking->description
                    ]
                ];
            });
            
            return response()->json($bookings);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch bookings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new booking
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'start' => 'required|date',
                'end' => 'required|date|after:start',
            ]);

            // Create the booking
            $booking = Booking::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Booking created successfully',
                'data' => $booking
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
                'message' => 'Failed to create booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing booking
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $booking = Booking::findOrFail($id);

            // Validate the request
            $validated = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'start' => 'sometimes|required|date',
                'end' => 'sometimes|required|date|after:start',
            ]);

            // Update the booking
            $booking->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Booking updated successfully',
                'data' => $booking
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Booking not found'
            ], 404);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a booking
     */
    public function destroy($id): JsonResponse
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Booking deleted successfully'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Booking not found'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
