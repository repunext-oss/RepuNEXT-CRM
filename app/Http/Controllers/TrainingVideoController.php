<?php

namespace App\Http\Controllers;

use App\Models\TrainingVideo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class TrainingVideoController extends Controller
{
    public function index()
    {
        $tvideo = TrainingVideo::where('isdeleted', 0)->orderBy('id', 'DESC')->get();
        return view('training_video.list', compact('tvideo'));
    }

    public function create()
    {
        return view('training_video.add');
    }

    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'tv_name' => 'required|string|max:255',
            'tv_department' => 'required|string|max:500',
            'tv_description' => 'nullable|string|max:255',
            'tv_url' => 'required|mimes:mp4,avi,mov,mkv|max:102400',
            'l_material' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:20480',
        ]);

        // Prepare data array
        $data = [
            'tv_name' => $request->tv_name, // Store only the entered TV name
            'tv_department' => $request->tv_department,
            'tv_description' => $request->tv_description,
            'tv_url' => null, // Default null
            'tv_extension' => null, // Store only video extension
            'l_material' => null, // Default null
            'l_extension' => null, // Store only training material extension
        ];

        // Handle video file upload
        if ($request->hasFile('tv_url')) {
            $file = $request->file('tv_url');

            // Extract the extension (e.g., mp4, avi)
            $extension = $file->getClientOriginalExtension();

            // Use only `tv_name` provided by the user and append the correct extension
            $filename = str_replace(' ', '-', strtolower($request->tv_name)) . '-' . time() . '.' . $extension;

            // Move file to public upload directory
            $file->move(public_path('upload/training_videos'), $filename);

            // Store in database
            // $data['tv_name'] = $filename;// Store filename in the `tv_name` field
            $data['tv_url'] = $filename; // Store filename without timestamp
            $data['tv_extension'] = $extension; // Store only the extension
        }

        // Handle training material upload (Same logic as video)
        if ($request->hasFile('l_material')) {
            $file = $request->file('l_material');

            // Extract the extension (e.g., jpg, png, pdf, doc)
            $extension = $file->getClientOriginalExtension();

            // Use only `tv_name` provided by the user and append the correct extension
            $filename = str_replace(' ', '-', strtolower($request->tv_name)) . '-' . time() . '.' . $extension;

            // Move file to public upload directory
            $file->move(public_path('upload/training_learn_materials'), $filename);

            // Store in database
            $data['l_material'] = $filename; // Store filename without timestamp
            $data['l_extension'] = $extension; // Store only the extension
        }

        // Save to database
        TrainingVideo::create($data);

        return redirect()->route('list.tvideos')->with('success', 'Training video added successfully!');
    }



    public function show($id)
    {
        $tvideo = TrainingVideo::findOrFail($id);

        // Generate correct file paths
        $videoPath = $tvideo->tv_url ? asset('upload/training_videos/' . $tvideo->tv_url) : null;
        $filePath = $tvideo->l_material ? asset('upload/training_learn_materials/' . $tvideo->l_material) : null;

        // Extract training material extension
        $fileExtension = $tvideo->l_material ? pathinfo($tvideo->l_material, PATHINFO_EXTENSION) : null;

        return view('training_video.show', compact('tvideo', 'videoPath', 'filePath', 'fileExtension'));
    }


    public function edit($id)
    {
        $tvideo = TrainingVideo::findOrFail($id);
        return view('training_video.edit', compact('tvideo'));
    }

    public function update(Request $request)
    {
        $tvideo = TrainingVideo::findOrFail($request->id);

        // Validate request
        $request->validate([
            'tv_name' => 'required|string|max:255',
            'tv_url' => 'nullable|mimes:mp4,avi,mov,mkv|max:102400',
            'tv_description' => 'nullable|string|max:500',
            'tv_department' => 'nullable|string|max:255',
            'l_material' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:20480',
        ]);

        // Prepare data array
        $data = [
            'tv_name' => $request->tv_name, // Store only the entered TV name
            'tv_department' => $request->tv_department,
            'tv_description' => $request->tv_description,
            'tv_url' => $tvideo->tv_url, // Default to old file if not updated
            'tv_extension' => $tvideo->tv_extension, // Default to old extension
            'l_material' => $tvideo->l_material, // Default to old file if not updated
            'l_extension' => $tvideo->l_extension, // Default to old extension
        ];

        // Handle video file update
        if ($request->hasFile('tv_url')) {
            // Delete old video file if exists
            if (!empty($tvideo->tv_url) && file_exists(public_path('upload/training_videos/' . $tvideo->tv_url))) {
                unlink(public_path('upload/training_videos/' . $tvideo->tv_url));
            }

            $file = $request->file('tv_url');
            $extension = $file->getClientOriginalExtension(); // Extract file extension
            $filename = str_replace(' ', '-', strtolower($request->tv_name)) . '-' . time() . '.' . $extension;
            
            // Move file to public upload directory
            $file->move(public_path('upload/training_videos'), $filename);

            // Store in database
            $data['tv_url'] = $filename; // Store filename without timestamp
            $data['tv_extension'] = $extension; // Store only the extension
        }

        // Handle training material update
        if ($request->hasFile('l_material')) {
            // Delete old training material if exists
            if (!empty($tvideo->l_material) && file_exists(public_path('upload/training_learn_materials/' . $tvideo->l_material))) {
                unlink(public_path('upload/training_learn_materials/' . $tvideo->l_material));
            }

            $file = $request->file('l_material');
            $extension = $file->getClientOriginalExtension(); // Extract file extension
            $filename = str_replace(' ', '-', strtolower($request->tv_name)) . '-' . time() . '.' . $extension;

            // Move file to public upload directory
            $file->move(public_path('upload/training_learn_materials'), $filename);

            // Store in database
            $data['l_material'] = $filename; // Store filename without timestamp
            $data['l_extension'] = $extension; // Store only the extension
        }

        // Update database
        $tvideo->update($data);

        return redirect()->route('list.tvideos')->with('success', 'Training video updated successfully!');
    }


    public function destroy($id)
    {
        $tvideo = TrainingVideo::findOrFail($id);
        $tvideo->update(['isdeleted' => 1]);

        return redirect()->route('list.tvideos')->with('success', 'Training video deleted successfully.');
    }
}
