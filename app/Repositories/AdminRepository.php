<?php 

namespace App\Repositories;

use App\Contracts\AdminInterface;
use App\Models\Admin;
use App\Models\adminRoles;
use App\Models\AdminsRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class AdminRepository implements AdminInterface {
    public function all() {
        return Admin::where('type', 'subadmin')->get();
    }

    public function register(array $data) {
        $password = Hash::make($data['password']);
        $admin = Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $password,
            'type' => 'subadmin',
        ]);
        if($admin) {
            $role = new AdminsRole();
            $role->admin_id = (int)$admin->id;
            $role->save();
        }
        return $admin;
    }

    public function login(array $data) {
        if(isset($data['remember'])) {
            setcookie('email', $data['email'], time()+3600);
            setcookie('password', $data['password'], time()+3600);
        } else {
            setcookie('email', '');
            setcookie('password', '');
        }
        return Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']]);
    }

    public function changePassword(array $data) {
        $changed = false;
        if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
            return Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['password'])]);
        } else {
            return $changed;
        }
    }

    public function updateProfile(array $data) {
        // Upload profile image
        if(isset($data['image']) && $data['image']->isValid()) {
            // Generate unique image name
            $image_name = uniqid('profile_').'.'.$data['image']->getClientOriginalExtension();

            // create image manager with desired driver
            $manager = new ImageManager(new Driver());
            
            // read image from file system
            $image = $manager->read($data['image']);
            // resize image
            // $image = $image->resize(370,246);

            $image_url = 'admin/images/profile/'.$image_name;
            // save modified image in new format 
            // $image->toPng()->save('images/foo.png');
            $image->toJpeg(80)->save($image_url);

        } else {
            $image_name = Auth::guard('admin')->user()->image;
        }

        // Update admin profile
        $admin = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        if($admin) {
            $admin->update([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'image' => $image_name
            ]);
        }
        return $admin;
    }

    public function logout() {
        return Auth::guard('admin')->logout();
    }

    public function show($id) {
        return Admin::find($id);
    }

    public function getPermissions($id) {
        $role = AdminsRole::where('admin_id', $id)->first();
        // Find the admin name
        $admin= Admin::find($id)->first();
        // Return only the updated data
        return [
            'admin_id' => $role->admin_id,
            'name' => $admin->name,
            'module' => $role->module,
            'view_access' => $role->view_access,
            'edit_access' => $role->edit_access,
            'full_access' => $role->full_access,
        ];
    }

    public function update($id, array $data) {
        $admin = Admin::find($id);
        $admin->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
        ]);
        return $admin;
    }

    public function updateStatus(array $data) {
        if($data['status'] == 'Active') {
            $status = 0;
        } else {
            $status = 1;
        }
        $id = (int)$data['admin_id'];
        $subadmin = Admin::where('id', $id)->update(['status' => $status]);
        return $subadmin;
    }

    public function updateRoles(array $data) {
        // Extract permissions data
        // Get the keys of the array
        $keys = array_keys($data);
        $cms = $keys[1];
        $cat = $keys[2];
        // Use the keys to access their corresponding arrays
        $cms_permissions = $data[$cms] ?? [];;
        $category_permissions = $data[$cat] ?? [];;
        dd($category_permissions);
      
        // Ensure admin ID is an integer
        $adminId = (int)$data['admin_id'];
    
        // Find the admin role
        $role = AdminsRole::where('admin_id', $adminId)->first();
    
        // If role doesn't exist, create a new one
        if (!$role) {
            $role = new AdminsRole();
            $role->admin_id = $adminId;
        }
    
        // Update or set permissions
        $role->module = 'cms_pages';
        $role->view_access = isset($permissions['view']) ? (int)$permissions['view'] : 0;
        $role->edit_access = isset($permissions['edit']) ? (int)$permissions['edit'] : 0;
        $role->full_access = isset($permissions['full']) ? (int)$permissions['full'] : 0;
    
        // Save the role
        $role->save();
    
        // Return only the updated data
        return [
            'admin_id' => $role->admin_id,
            'module' => $role->module,
            'view_access' => $role->view_access,
            'edit_access' => $role->edit_access,
            'full_access' => $role->full_access,
        ];
    }
    
    public function delete($id) {
        return Admin::destroy($id);
    }
}