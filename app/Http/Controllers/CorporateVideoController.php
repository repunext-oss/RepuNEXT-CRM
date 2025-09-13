<?php

namespace App\Http\Controllers;

use App\Models\CorporateVideo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CorporateVideoController extends Controller
{
    public function index()
    {
        $cvideo   =   CorporateVideo::where('isdeleted', 0)->orderBy('id','DESC')->get();
        return view('corporate_videos.list',compact('cvideo'));  
    }
    public function create()
    {
        $cvideo = CorporateVideo::all();
        return view('corporate_videos.add',compact('cvideo')); 
    
    }
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'c_name' => 'required|string|max:255',
            'c_url' => 'required|mimes:mp4,avi,mov,mkv|max:102400', // Video upload validation
            'c_description' => 'nullable|string|max:500',
            'p_video' => 'nullable|string|max:255',
            'l_material' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:20480', // Training material validation
        ]);

        // Prepare data array
        $data = [
            'c_name' => $request->c_name, // Store only the entered Corporate Name
            'c_description' => $request->c_description,
            'p_video' => $request->p_video,
            'c_url' => null, // Default null
            'c_extension' => null, // Store only video extension
            'l_material' => null, // Default null
            'l_extension' => null, // Store only training material extension
        ];

        // Handle corporate video upload
        if ($request->hasFile('c_url')) {
            $file = $request->file('c_url');
            $extension = $file->getClientOriginalExtension(); // Extract file extension
            $filename = str_replace(' ', '-', strtolower($request->c_name)) . '-' . time() . '.' . $extension;


            // Move file to public upload directory
            $file->move(public_path('upload/corporate_videos'), $filename);

            // Store in database
            $data['c_url'] = $filename; // Store filename without timestamp
            $data['c_extension'] = $extension; // Store only the extension
        }

        // Handle training material upload (Same logic as corporate video)
        if ($request->hasFile('l_material')) {
            $file = $request->file('l_material');
            $extension = $file->getClientOriginalExtension(); // Extract file extension
            $filename = str_replace(' ', '-', strtolower($request->c_name)) . '-' . time() . '.' . $extension;

            // Move file to public upload directory
            $file->move(public_path('upload/corporate_materials'), $filename);

            // Store in database
            $data['l_material'] = $filename; // Store filename without timestamp
            $data['l_extension'] = $extension; // Store only the extension
        }

        // Save data to the database
        CorporateVideo::create($data);

        // Redirect back with success message
        return redirect()->route('list.cvideo')->with('success', 'Corporate video added successfully!');
    }




    public function show($id)
    {

        $cvideo = CorporateVideo::findOrFail($id);

        // Generate correct file paths
        $videoPath = $cvideo->c_url ? asset('upload/corporate_videos/' . $cvideo->c_url) : null;
        $filePath = $cvideo->l_material ? asset('upload/corporate_materials/' . $cvideo->l_material) : null;

        // Extract training material extension
        $fileExtension = $cvideo->l_material ? pathinfo($cvideo->l_material, PATHINFO_EXTENSION) : null;

        return view('corporate_videos.show', compact('cvideo', 'videoPath', 'filePath', 'fileExtension'));
    }

    public function edit($id)
    {
        $cvideo   = CorporateVideo::find($id);
        return view('corporate_videos.edit',compact('cvideo'));

    }

    public function update(Request $request)
    {
        $cvideo = CorporateVideo::findOrFail($request->id);

        // Validate request
        $request->validate([
            'c_name' => 'required|string|max:255',
            'c_url' => 'nullable|mimes:mp4,avi,mov,mkv|max:102400', // Video file validation
            'c_description' => 'nullable|string|max:500',
            'p_video' => 'nullable|string|max:255',
            'l_material' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:20480', // Training material validation
        ]);

        // Define storage paths
        $videoStoragePath = 'upload/corporate_videos/';
        $materialStoragePath = 'upload/corporate_materials/';

        // Prepare data array
        $data = [
            'c_name' => $request->c_name, // Store only the entered Corporate Name
            'c_description' => $request->c_description,
            'p_video' => $request->p_video,
            'c_url' => $cvideo->c_url, // Default to old file if not updated
            'c_extension' => $cvideo->c_extension, // Default to old extension
            'l_material' => $cvideo->l_material, // Default to old file if not updated
            'l_extension' => $cvideo->l_extension, // Default to old extension
        ];

        // Handle corporate video update
        if ($request->hasFile('c_url')) {
            // Delete old video file if exists
            if (!empty($cvideo->c_url) && file_exists(public_path($videoStoragePath . $cvideo->c_url))) {
                unlink(public_path($videoStoragePath . $cvideo->c_url));
            }

            $file = $request->file('c_url');
            $extension = $file->getClientOriginalExtension(); // Extract file extension
            $filename = $request->c_name . '.' . $extension; // Store only `c_name.extension`

            // Move file to public upload directory
            $file->move(public_path($videoStoragePath), $filename);

            // Store in database
            $data['c_url'] = $filename; // Store filename without timestamp
            $data['c_extension'] = $extension; // Store only the extension
        }

        // Handle training material update
        if ($request->hasFile('l_material')) {
            // Delete old training material if exists
            if (!empty($cvideo->l_material) && file_exists(public_path($materialStoragePath . $cvideo->l_material))) {
                unlink(public_path($materialStoragePath . $cvideo->l_material));
            }

            $file = $request->file('l_material');
            $extension = $file->getClientOriginalExtension(); // Extract file extension
            $filename = $request->c_name . '.' . $extension; // Store only `c_name.extension`

            // Move file to public upload directory
            $file->move(public_path($materialStoragePath), $filename);

            // Store in database
            $data['l_material'] = $filename; // Store filename without timestamp
            $data['l_extension'] = $extension; // Store only the extension
        }

        // Update database
        $cvideo->update($data);

        return redirect()->route('list.cvideo')->with('success', 'Corporate video updated successfully!');
    }



    public function destroy($id)
    {
        $cvideo                   =   CorporateVideo::find($id);
        $cvideo->isdeleted     =   "1";
        $cvideo->save();     
        return redirect()->route('list.cvideo')->with('success','state has been deleted successfully');
    }



}
