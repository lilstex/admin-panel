<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * Display the admin login page and login admin
     */
    public function login(Request $request)
    {
        if($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required|min:5',
            ]);

            $data = $request->all();
            
            // echo "<pre>"; print_r($data); die;
            if(Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->back()->withErrors(['error_message' => 'Invalid credentials']);
            }
        }
        return view('admin.login');
    }

    /**
     * Display the admin register page
     */
    public function register()
    {
        return view('admin.register');
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('login');
    }

     /**
     * Display the admin change password page and change password
     */
    public function password(Request $request)
    {
        if($request->isMethod('post')) {
            $request->validate([
                'current_password' => 'required|min:5',
                'new_password' => 'required|min:5',
                'confirm_password' => 'required|min:5',
            ]);
            $data = $request->all();
            
            if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
                // Check if password match
                if($data['new_password'] == $data['confirm_password']) {
                    // Update Admin password
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    return redirect()->back()->with(['success_message' => 'Password changed successfully']);
                } else {
                    return redirect()->back()->withErrors(['error_message' => 'New password and confirm password do not match']);
                }
                return redirect()->route('dashboard');
            } else {
                return redirect()->back()->withErrors(['error_message' => 'Incorrect current password']);
            }
        }
        return view('admin.change-password');
    }


}
