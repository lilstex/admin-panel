<?php 

namespace App\Repositories;

use App\Contracts\ProductInterface;
use App\Models\AdminsRole;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductRepository implements ProductInterface {

    public function all() {
        // Initialize permissions with default values
        $permissions = [
            'module' => 'products',
            'view_access' => 0,
            'edit_access' => 0,
            'full_access' => 0,
        ];
    
        // Check if the user is an admin
        $isAdmin = Auth::guard('admin')->user()->type === 'admin';
    
        if (!$isAdmin) {
            // Retrieve the user's role permissions
            $roles = AdminsRole::where('admin_id', Auth::guard('admin')->user()->id)->where('module', 'products')->first();
    
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
    
        // Retrieve all products
        $products = Product::with('category')->get();
    
        // Combine products and permissions into an associative array
        $data = [
            'products' => $products,
            'permissions' => $permissions,
        ];
    
        return $data;
    }

    public function subcategories() {
        // Retrieve all categories/subcategories
        return Category::getcategories();
    }

    public function create(array $data) {
        return Product::create([
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
        return Product::find($id);
    }

    public function update($id, array $data) {
        $category = Product::find($id);
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
        $category = Product::where('id', $id)->update(['status' => $status]);
        return $category;
    }

    public function delete($id) {
        return Product::destroy($id);
    }

    public function deleteImage($id) {
        // Get the image from the DB
        $cat_image =  Product::select('category_image')->where('id', $id)->first();
        // Get the image path
        $image_path = 'admin/images/category/';
        // Remove the image from the folder
        if(file_exists(($image_path.$cat_image->category_image))) {
            unlink($image_path.$cat_image->category_image);
        }
        // Remove the image from the DB table
        return Product::where('id', $id)->update(['category_image' => '']);
    }
}