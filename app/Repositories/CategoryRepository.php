<?php 

namespace App\Repositories;

use App\Contracts\CategoryInterface;
use App\Models\AdminsRole;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryRepository implements CategoryInterface {
    public function all() {
        // Initialize permissions with default values
        $permissions = [
            'module' => 'categories',
            'view_access' => 0,
            'edit_access' => 0,
            'full_access' => 0,
        ];
    
        // Check if the user is an admin
        $isAdmin = Auth::guard('admin')->user()->type === 'admin';
    
        if (!$isAdmin) {
            // Retrieve the user's role permissions
            $roles = AdminsRole::where('admin_id', Auth::guard('admin')->user()->id)->first();
    
            // If roles exist, update permissions accordingly
            if ($roles) {
                $permissions['view_access'] = $roles->view_access;
                $permissions['edit_access'] = $roles->edit_access;
                $permissions['full_access'] = $roles->full_access;
            }
        } else {
            // If user is an admin, set full access
            $permissions['view_access'] = 1;
            $permissions['edit_access'] = 1;
            $permissions['full_access'] = 1;
        }
    
        // Retrieve all categories
        $categories = Category::with('parentcategory')->get();
    
        // Combine categories and permissions into an associative array
        $data = [
            'categories' => $categories,
            'permissions' => $permissions,
        ];
    
        return $data;
    }

    public function subcategories() {
        // Retrieve all categories/subcategories
        return Category::getcategories();
    }


    public function create(array $data) {
        return Category::create([
            'parent_id' => $data['parent_id'],
            'category_name' => $data['category_name'],
            'category_discount' => $data['category_discount'],
            'desc' => $data['desc'],
            'url' => $data['url'],
            'meta_desc' => $data['meta_desc'],
            'meta_title' => $data['meta_title'],
            'meta_keywords' => $data['meta_keywords'],
            'status' => 1,
        ]);
    }

    public function show($id) {
        return Category::find($id);
    }

    public function update($id, array $data) {
        $category = Category::find($id);
        return $category->update([
            'parent_id' => $data['parent_id'],
            'category_name' => $data['category_name'],
            'category_discount' => $data['category_discount'],
            'desc' => $data['desc'],
            'url' => $data['url'],
            'meta_desc' => $data['meta_desc'],
            'meta_title' => $data['meta_title'],
            'meta_keywords' => $data['meta_keywords'],
        ]);
    }

    public function updateStatus(array $data) {
        if($data['status'] == 'Active') {
            $status = 0;
        } else {
            $status = 1;
        }
        $id = (int)$data['category_id'];
        $category = Category::where('id', $id)->update(['status' => $status]);
        return $category;
    }

    public function delete($id) {
        return Category::destroy($id);
    }

    public function deleteImage($id) {
        // Get the image from the DB
        $cat_image =  Category::select('category_image')->where('id', $id)->first();
        // Get the image path
        $image_path = 'admin/images/category/';
        // Remove the image from the folder
        if(file_exists(($image_path.$cat_image->category_image))) {
            unlink($image_path.$cat_image->category_image);
        }
        // Remove the image from the DB table
        return Category::where('id', $id)->update(['category_image' => '']);
    }
}