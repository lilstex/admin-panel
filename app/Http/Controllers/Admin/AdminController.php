<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\AdminInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateAdminProfileRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;
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
        $title = 'Add Admin';
        return view('admin.addAdmin')->with(compact('title'));
    }

    /**
     * Store the admin
     */
    public function registerStore(AdminStoreRequest $request)
    {
        $validated = $request->validated();

        $newAdmin = $this->admin->register($validated);
        
        if($newAdmin) {
            return redirect('admin/subadmins')->with(['success_message' => 'New Admin added successfully']);
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to add an admin']);
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

    /**
     * Display a listing of the resource.
    */
    public function subadmins()
    {
        Session::put('page', 'sub-admin');
        $admins = $this->admin->all();
        if($admins) {
            return view('admin.subadmins')->with(compact('admins'));
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to get all subadmins']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        Session::put('page', 'sub-admin');
        $title = 'Edit Admin';
        $subadmin = $this->admin->show($id);
        return view('admin.addAdmin')->with(compact('title', 'subadmin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminProfileRequest $request, $id)
    {
        $validated = $request->validated();
        $updatedCmsPage = $this->admin->update($id, $validated);
        
        if($updatedCmsPage) {
            return redirect('admin/subadmins')->with(['success_message' => 'Subadmin updated successfully']);
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to subadmin']);
        }
    }

    /**
     * Update admin status
     */
    public function updateAdminStatus(Request $request)
    {
        if($request->ajax()) {
            $data = $request->all();
            $isChanged = $this->admin->updateStatus($data);

            if($isChanged) {
                return response()->json(['status' => $data['status'], 'admin_id' => $data['admin_id']]);
            } else {
                return redirect()->back()->withErrors(['error_message' => 'Failed to update admin status']);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editAdminRoles($id)
    {
        Session::put('page', 'sub-admin');
        $role = $this->admin->getPermissions($id);
        $title = 'Update '.$role['name'].' Permissions';
        return view('admin.adminRoles')->with(compact('title', 'role'));
    }

    /**
     * Update admin access
     */
    public function updateAdminRoles(UpdateRoleRequest $request)
    {
        $validated = $request->validated();
        $role = $this->admin->updateRoles($validated);
        if($role) {
            return redirect()->back()->with(['success_message' => 'Permissions updated successfully']);
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to update permission']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deletedAdmin = $this->admin->delete($id);
        
        if($deletedAdmin) {
            return redirect()->back()->with(['success_message' => 'Subadmin deleted successfully']);
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to update subadmin']);
        }
    }

}
