<?php 

namespace App\Repositories;

use App\Contracts\AdminInterface;
use App\Models\Admin;
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
        $permissions = AdminsRole::where('admin_id', $id)->get();
        // Find the admin name
        $admin= Admin::find($id)->first();
        // Return only the updated data
        return [
            'admin_id' => $id,
            'name' => $admin->name,
            'permissions' => $permissions,
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
        $keys = array_keys(array_filter($data, function($value) {
            return is_array($value);
        }));
        // Ensure admin ID is an integer
        $adminId = (int)$data['admin_id'];
        
        foreach ($keys as $key) {
            // Check if a record exists with the provided conditions
            $existingPermission = AdminsRole::where('admin_id', $adminId)->where('module', $key)->first();
        
            // If permission exists, delete it
            if ($existingPermission) {
                $existingPermission->delete();
            }
            // Create a new record with the updated values
            AdminsRole::create([
                'admin_id' => $adminId,
                'module' => $key,
                'view_access' => isset($data[$key]['view']) ? (int)$data[$key]['view'] : 0,
                'edit_access' => isset($data[$key]['edit']) ? (int)$data[$key]['edit'] : 0,
                'full_access' => isset($data[$key]['full']) ? (int)$data[$key]['full'] : 0,
            ]);
        }
    
        return true;
    }
    
    public function delete($id) {
        return Admin::destroy($id);
    }
}