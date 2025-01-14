<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;  
use Illuminate\Http\Request;   
use Illuminate\Support\Facades\Auth;     
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */   
    public function __construct()  
    {       
         
    }

    public function create()
    {
       
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {     
        $data = $request->all();   
        
        
        $username = User::where('username',$data['username'])->select('username')->get();
        if(isset($username[0])){
            $existing_password = User::where('username',$data['username'])->select('password')->get();
    
            if(Hash::check($data['password'], $existing_password[0]->password)){
                $user = User::where('username',$data['username'])->select('isdeleted')->get();
                $status = User::where('username',$data['username'])->select('status')->get();
                if ($user[0]->isdeleted != 0) {   
                            
                    $notification = array(       
                        'message' => 'User does not exist!!!', 
                        'alert-type' => 'error'            
                    );              
                    return redirect('/login')->with($notification);
                }else if($status[0]->status != 0){               
                    $notification = array(                       
                        'message' => 'User is In-active',     
                        'alert-type' => 'error'                
                    );         
                    return redirect('/login')->with($notification);  
                }else{
                    $request->authenticate(); 
                    $request->session()->regenerate(); 

                    $notification = array(
                        'message' => 'User Login Successfully',    
                        'alert-type' => 'success'
                    );
                    return redirect()->intended(RouteServiceProvider::HOME)->with($notification);
                }
            }else{
                $notification = array(                       
                    'message' => 'Please enter correct password!!',     
                    'alert-type' => 'error'         
                );         
                return redirect('/login')->with($notification);
            }               
        }else{         
            $notification = array(                   
                'message' => 'User is does not exist',     
                'alert-type' => 'error'         
            );         
            return redirect('/login')->with($notification);  
        }      
        
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User Logout Successfully', 
            'alert-type' => 'error'
        );
        return redirect('/login')->with($notification);
    }
}
