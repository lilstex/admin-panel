<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\CategoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public $categories;

     /**
     * Assingning the cms interface to the cmsPage
     */
    public function __construct(CategoryInterface $categoryInterface) {
        $this->categories = $categoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page', 'category');
        $data = $this->categories->all();
        $allCategories = $data['categories'];
        $permissions = $data['permissions'];
        if($permissions['view_access'] == 1 || $permissions['edit_access'] == 1 || $permissions['full_access'] == 1) {
            return view('admin.categories.index')->with(compact('allCategories', 'permissions'));
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Unauthorised to view this resource']);
        }
    }
}
