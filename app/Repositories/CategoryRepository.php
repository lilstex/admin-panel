<?php 

namespace App\Repositories;

use App\Contracts\CategoryInterface;
use App\Models\AdminsRole;
use App\Models\Category;
use App\Models\CmsPage;
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
    

    public function create(array $data) {
        return CmsPage::create([
            'title' => $data['title'],
            'desc' => $data['description'],
            'url' => $data['url'],
            'meta_desc' => $data['meta_description'],
            'meta_title' => $data['meta_title'],
            'meta_keywords' => $data['meta_keywords'],
            'status' => 1,
        ]);
    }

    public function show($id) {
        return CmsPage::find($id);
    }

    public function update($id, array $data) {
        $cmsPage = CmsPage::find($id);
        return $cmsPage->update([
            'title' => $data['title'],
            'desc' => $data['description'],
            'url' => $data['url'],
            'meta_desc' => $data['meta_description'],
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
        $id = (int)$data['page_id'];
        $cmsPage = CmsPage::where('id', $id)->update(['status' => $status]);
        return $cmsPage;
    }

    
    public function delete($id) {
        return CmsPage::destroy($id);
    }
}