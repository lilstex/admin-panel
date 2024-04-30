<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\AdminInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateAdminProfileRequest;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public $admin;

    /**
     * Assingning the admin interface to the admin
     */
    function __construct(AdminInterface $adminInterface) {
        $this->admin = $adminInterface;
    }
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        // To enable page link active 
        Session::put('page', 'dashboard');
        return view('admin.dashboard');
    }

    /**
     * Display the admin login page and login admin
     */
    public function login()
    {
        return view('admin.login');
    }

    /**
     * Execute login post action
     */
    public function loginStore(LoginRequest $request)
    {
        $validated= $request->validated();

        $isLogin = $this->admin->login($validated);
        // echo "<pre>"; print_r($isLogin); die;
        if($isLogin) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Invalid credentials']);
        }
    }

    /**
     * Display the admin register page
     */
    public function register()
    {
        return view('admin.register');
    }

    /**
     * Store the admin
     */
    public function registerStore(AdminStoreRequest $request)
    {
        $validated = $request->validated();

        $newAdmin = $this->admin->register($validated);
        
        // echo "<pre>"; print_r($data); die;
        if($newAdmin) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to register admin']);
        }
       
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        $isLogout = $this->admin->logout();
        if($isLogout) {
            return redirect()->route('login');
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to logout admin']);
        }
    }

    /**
     * Display the admin change password page and change password
     */
    public function password()
    {
        // To enable page link active 
        Session::put('page', 'change-password');
        return view('admin.change-password');
    }

     /**
     * Update and change password
     */
    public function passwordStore(ChangePasswordRequest $request)
    {
        $validated = $request->validated();
        $isChanged = $this->admin->changePassword($validated);
        
        if($isChanged) {
            return redirect()->back()->with(['success_message' => 'Password changed successfully']);
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Current password is incorrect']);
        }
    }

    /**
     * Display the update admin profile page
     */
    public function profile()
    {
        // To enable page link active 
        Session::put('page', 'update-profile');
        return view('admin.update-profile');
    }

     /**
     * Update admin profile
     */
    public function updateProfile(UpdateAdminProfileRequest $request)
    {
        $validated = $request->validated();
        $isChanged = $this->admin->updateProfile($validated);
        
        if($isChanged) {
            return redirect()->back()->with(['success_message' => 'Admin profile updated successfully']);
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to update admin profile']);
        }
    }

}
