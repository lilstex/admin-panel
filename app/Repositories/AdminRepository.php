<?php 

namespace App\Repositories;

use App\Contracts\AdminInterface;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class AdminRepository implements AdminInterface {
    public function all() {
        return Admin::all();
    }

    public function register(array $data) {
        $password = Hash::make($data['password']);
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $password,
        ]);
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

    public function update($id, array $data) {
        $admin = Admin::find($id);
        $admin->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'image' => $data['image'],
        ]);
        return $admin;
    }

    public function delete($id) {
        return Admin::destroy($id);
    }
}