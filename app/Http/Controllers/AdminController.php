<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Role;


class AdminController extends Controller
{
    public function dummy(){
        return view('admin.dummy');
    }
    public function Dashboard(){ 
        return view('admin.index', );
    }
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $notification = array(
            'message' => 'User Logout Successfully',
            'alert-type' => 'success'
        );
        return redirect('/login')->with($notification);
    } // End Function

    public function Profile(){
        $id=Auth::user()->id;
        $adminData=User::find($id);
        return view('admin.admin_profile_view',compact('adminData'));
    } // End Function

    public function EditProfile(){
        $id=Auth::user()->id;
        $editData=User::find($id);
        return view('admin.admin_profile_edit',compact('editData'));
    } // End Function

    public function StoreProfile(Request $request){
        $id=Auth::user()->id; 
        $data=User::find($id);
        $data->name =$request->name;
        $data->phone =$request->phone;
        $data->honorific =$request->honorific;
        if($request->file('profile_image')){
            $file = $request->file('profile_image');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin-images'),$filename);
            $data['profile_image']=$filename;
        }
        $data->save();
        $notification = array(
            'message' => 'Admin Profile updated Successfully',
            'alert-type' => 'info'
            );
        return redirect()->route('admin.profile')->with($notification);
    } // End Function

    public function rolelist(){
        // $roles  =   DB::table('roles')->get();
        $roles  =   Role::all();
        return view('admin.role_list',compact('roles'));
    }  // End Function

    public function Storerolelist(Request $request){
        $id=Auth::user()->id;
        // $input = $request->all();
        if (!empty($request->kt_roles_select_all)){
            $input=trim($request->kt_roles_select_all);
        }else{
            $kt_roles_select_all=trim($request->kt_roles_select_all);
            $role_name =trim($request->role_name);
            $dealers_read =trim($request->dealers_read);
            $dealers_write =trim($request->dealers_write);
            $dealers_create =trim($request->dealers_create);
            $service_provider_read =trim($request->service_provider_read);
            $service_provider_write =trim($request->service_provider_write);
            $service_provider_create =trim($request->service_provider_create);
            $pilots_read =trim($request->pilots_read);
            $pilots_write =trim($request->pilots_write);
            $pilots_create =trim($request->pilots_create);
            $farmers_read =trim($request->farmers_read);
            $farmers_write =trim($request->farmers_write);
            $farmers_create=trim($request->farmers_create);
            $master_read=trim($request->master_read);
            $master_write=trim($request->master_write);
            $master_create=trim($request->master_create);
            $user_management_read=trim($request->user_management_read);
            $user_management_write=trim($request->user_management_write);
            $user_management_create =trim($request->user_management_create);
            $role_management_read=trim($request->role_management_read);
            $role_management_write=trim($request->role_management_write);
            $role_management_create=trim($request->role_management_create);
            $coe_read=trim($request->coe_read);
            $coe_write=trim($request->coe_write);
            $coe_create=trim($request->coe_create);
            $student_read=trim($request->student_read);
            $student_write=trim($request->student_write);
            $student_create=trim($request->student_create);
            $cms_read=trim($request->cms_read);
            $cms_write=trim($request->cms_write);
            $cms_create=trim($request->cms_create);
            $lms_read=trim($request->lms_read);
            $lms_write=trim($request->lms_write);
            $lms_create=trim($request->lms_create);
            $training_read=trim($request->training_read);
            $training_write=trim($request->training_write);
            $training_create=trim($request->training_create);
            $data = array(
                'dealers_read'  => $dealers_read,
                'dealers_write' => $dealers_write,
                'dealers_create' => $dealers_create,
                'service_provider_read' => $service_provider_read,
                'service_provider_write' => $service_provider_write,
                'service_provider_create' => $service_provider_create,
                'pilots_read' => $pilots_read,
                'pilots_write' => $pilots_write,
                'pilots_create' => $pilots_create,
                'farmers_read' => $farmers_read,
                'farmers_write' => $farmers_write,
                'farmers_create' => $farmers_create,
                'master_read' => $master_read,
                'master_write' => $master_write,
                'master_create' => $master_create,
                'user_management_read' => $user_management_read,
                'user_management_write' => $user_management_write,
                'user_management_create' => $user_management_create,
                'role_management_read' => $role_management_read,
                'role_management_write' => $role_management_write,
                'role_management_create' => $role_management_create,
                'coe_read'=>$coe_read,
                'coe_write'=>$coe_write,
                'coe_create'=>$coe_create,
                'student_read'=>$student_read,
                'student_write'=>$student_write,
                'student_create'=>$student_create,
                'cms_read'=>$cms_read,
                'cms_write'=>$cms_write,
                'cms_create'=>$cms_create,
                'lms_read'=>$lms_read,
                'lms_write'=>$lms_write,
                'lms_create'=>$lms_create,
                'training_read'=>$training_read,
                'training_write'=>$training_write,
                'training_create'=>$training_create ,
              );
            $input =implode(",", $data);
        }
        $role = Role::create([
            'role_name' => $request->role_name,
            'role' => $input,
            'isdeleted' => "0",
        ]);
        $notification = array(
            'message' => 'Added New Role Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('list.role')->with($notification);
    } // End Function

    public function Updaterolelist(Request $request){
        $id=Auth::user()->id;
        // $input = $request->all();
        $role_id=$request->role_id;
        if (!empty($request->kt_roles_select_all)){
            $input=trim($request->kt_roles_select_all);
        }else{
            $kt_roles_select_all=trim($request->kt_roles_select_all);
            $role_name =trim($request->role_name);
            $dealers_read =trim($request->dealers_read);
            $dealers_write =trim($request->dealers_write);
            $dealers_create =trim($request->dealers_create);
            $service_provider_read =trim($request->service_provider_read);
            $service_provider_write =trim($request->service_provider_write);
            $service_provider_create =trim($request->service_provider_create);
            $pilots_read =trim($request->pilots_read);
            $pilots_write =trim($request->pilots_write);
            $pilots_create =trim($request->pilots_create);
            $farmers_read =trim($request->farmers_read);
            $farmers_write =trim($request->farmers_write);
            $farmers_create=trim($request->farmers_create);
            $master_read=trim($request->master_read);
            $master_write=trim($request->master_write);
            $master_create=trim($request->master_create);
            $user_management_read=trim($request->user_management_read);
            $user_management_write=trim($request->user_management_write);
            $user_management_create =trim($request->user_management_create);
            $role_management_read=trim($request->role_management_read);
            $role_management_write=trim($request->role_management_write);
            $role_management_create=trim($request->role_management_create);
            $coe_read=trim($request->coe_read);
            $coe_write=trim($request->coe_write);
            $coe_create=trim($request->coe_create);
            $student_read=trim($request->student_read);
            $student_write=trim($request->student_write);
            $student_create=trim($request->student_create);
            $cms_read=trim($request->cms_read);
            $cms_write=trim($request->cms_write);
            $cms_create=trim($request->cms_create);
            $lms_read=trim($request->lms_read);
            $lms_write=trim($request->lms_write);
            $lms_create=trim($request->lms_create);
            $training_read=trim($request->training_read);
            $training_write=trim($request->training_write);
            $training_create=trim($request->training_create);
            $data = array(
                'dealers_read'  => $dealers_read,
                'dealers_write' => $dealers_write,
                'dealers_create' => $dealers_create,
                'service_provider_read' => $service_provider_read,
                'service_provider_write' => $service_provider_write,
                'service_provider_create' => $service_provider_create,
                'pilots_read' => $pilots_read,
                'pilots_write' => $pilots_write,
                'pilots_create' => $pilots_create,
                'farmers_read' => $farmers_read,
                'farmers_write' => $farmers_write,
                'farmers_create' => $farmers_create,
                'master_read' => $master_read,
                'master_write' => $master_write,
                'master_create' => $master_create,
                'user_management_read' => $user_management_read,
                'user_management_write' => $user_management_write,
                'user_management_create' => $user_management_create,
                'role_management_read' => $role_management_read,
                'role_management_write' => $role_management_write,
                'role_management_create' => $role_management_create,
                'coe_read'=>$coe_read,
                'coe_write'=>$coe_write,
                'coe_create'=>$coe_create,
                'student_read'=>$student_read,
                'student_write'=>$student_write,
                'student_create'=>$student_create,
                'cms_read'=>$cms_read,
                'cms_write'=>$cms_write,
                'cms_create'=>$cms_create,
                'lms_read'=>$lms_read,
                'lms_write'=>$lms_write,
                'lms_create'=>$lms_create,
                'training_read'=>$training_read,
                'training_write'=>$training_write,
                'training_create'=>$training_create ,
              );
            $input =implode(",", $data);
        }
        $role=Role::where('id',$role_id);
        $role->update(['role'=>$input]);
        $notification = array(
            'message' => 'Role are Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('list.role')->with($notification);
    } // End Function

    public function Deleterolelist(Request $request){
        $id =$request->id;
        $roleresult=Role::where('id',$id);
        $roleresult->delete();
        $notification = array(
            'message' => 'A role is deleted Successfully',
            'alert-type' => 'warning'
            );
        return redirect()->route('list.role')->with($notification);
    }  // End Function

    public function Deleteuserlist(Request $request){
        $id =$request->id;
        $userresult=User::where('id',$id)->update(['isdeleted' => 1]);
        $notification = array(
            'message' => 'A user is deleted Successfully',
            'alert-type' => 'warning'
            );
        return redirect()->route('list.user')->with($notification);
    }  // End Function

   public function Editrolelist(Request $request){
        $id =$request->id;
        $editrole = DB::table('roles')->get()->where('id',$id);
        return view('admin.role_edit',compact('editrole'));
    }  // End Function

    public function roleview(){
        return view('admin.role_view');
    }  // End Function

    public function UpdateEmail(Request $request){
        $id=Auth::user()->id;
        $editData= DB::table('users')
                    ->where('id',$id)
                    ->first();
        $existing_password = $editData->password;
        $email = $request->email;
        if(Hash::check($request->password, $editData->password)){
            User::where('id', $id)->update(['email' => $email]);
            $notification = array(
                'message' => 'Email Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect('/edit/profile')->with($notification);
        }else{
            $notification = array(
                'message' => 'Wrong Password',
                'alert-type' => 'warning'
            );
            return redirect('/edit/profile')->with($notification);
        }

    }

    public function UpdatePassword(Request $request){
        $id=Auth::user()->id;
        $editData= DB::table('users')
                    ->where('id',$id)
                    ->first();
        $existing_password = $editData->password;
        $current_password = $request->currentpassword;
        $new_password = $request->newpassword;
        $confirm_password = $request->confirmpassword;
        if($new_password == $confirm_password){
            if(Hash::check($request->currentpassword, $editData->password)){
                User::where('id', $id)->update(['password' => Hash::make($request->newpassword)]);
                $notification = array(
                    'message' => 'Password Updated Successfully',
                    'alert-type' => 'success'
                );
                return redirect('/edit/profile')->with($notification);
            }else{
                $notification = array(
                    'message' => 'Current Password does not match!!',
                    'alert-type' => 'warning'
                );
                return redirect('/edit/profile')->with($notification);
            }
        }else{
            $notification = array(
                'message' => 'New password and Confirm password does not match!!',
                'alert-type' => 'warning'
            );
            return redirect('/edit/profile')->with($notification);
        }
    }
    public function adduser(){
        $usersdetails   =   DB::table('users')->get()->where('isdeleted',0);
        $roledetails    =   DB::table('roles')->get();
        return view('admin.user_add',compact('usersdetails','roledetails'));
    }
    public function userlist(){
        $usersdetails = DB::table('users')->get()->where('isdeleted',0);
        $roledetails = DB::table('roles')->get();
        return view('admin.user_list',compact('usersdetails','roledetails'));
    }  // End Function

    public function Storeuserlist(Request $request){ 
        if ($request->hasFile('profile_image')) {
            $file       = $request->file('profile_image');
            $filename   = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin-images'), $filename);
        } else {
            $filename = 'default.jpg';
        } 
        $userresult = User::create(array_merge($request->all(), 
                                    [   'password' => Hash::make($request->password),
                                        'profile_image' => $filename,
                                        'isdeleted' => 0,
                                        'status' => 0 ])); 
        if($userresult){ 
            $notification = array(  'message'       => 'User Profile is created Successfully',
                                    'alert-type'    => 'success'    );
            return redirect()->route('list.user')->with($notification);
        }
    }

}