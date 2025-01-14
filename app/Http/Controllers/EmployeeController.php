<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function userlist(){
        $usersdetails = DB::table('users')->get()->where('isdeleted',0);
        $roledetails = DB::table('roles')->get();
        return view('employee.employee_list',compact('usersdetails','roledetails'));
    }  // End Function

    public function Storeuserlist(Request $request){
        //print_r($_REQUEST);die;
        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->honorific =$request->honorific;
        $user->password = Hash::make($request->password);
        $user->role= $request->role;
        $user->isdeleted=0;
        $user->status=0;
        $userresult=User::where('email',$request->email)->first();
        if($userresult){
            $notification = array(
                'message' => 'User email address is already exists',
                'alert-type' => 'info'
                );
            return redirect()->route('list.employee')->with($notification);

        }
        else{
            if($request->file('profile_image')){
                $file = $request->file('profile_image');
                $filename = date('YmdHi').$file->getClientOriginalName();
                $file->move(public_path('upload/admin-images'),$filename);
                $user->profile_image=$filename;
            }
            $user->save();
            $notification = array(
                'message' => 'User Profile is created Successfully',
                'alert-type' => 'success'
                );
            return redirect()->route('list.employee')->with($notification);
        }
    }
}
