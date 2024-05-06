<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\CategoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\UpdateCategoryRequest;
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

    /**
     * Update category status
     */
    public function updateCategoryStatus(Request $request)
    {
        if($request->ajax()) {
            $data = $request->all();
            $isChanged = $this->categories->updateStatus($data);

            if($isChanged) {
                return response()->json(['status' => $data['status'], 'category_id' => $data['category_id']]);
            } else {
                return redirect()->back()->withErrors(['error_message' => 'Failed to update category status']);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Session::put('page', 'category');
        $title = 'Add Category';
        return view('admin.categories.create')->with(compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $validated = $request->validated();
        $newCategory = $this->categories->create($validated);
        
        if($newCategory) {
            return redirect('admin/categories')->with(['success_message' => 'New Category added successfully']);
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to add Category']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        Session::put('page', 'category');
        $title = 'Edit Category';
        $category = $this->categories->show($id);
        return view('admin.categories.create')->with(compact('title', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $validated = $request->validated();
        $updatedCategory = $this->categories->update($id, $validated);
        
        if($updatedCategory) {
            return redirect('admin/categories')->with(['success_message' => 'Category updated successfully']);
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to update Category']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deletedCategory = $this->categories->delete($id);
        
        if($deletedCategory) {
            return redirect()->back()->with(['success_message' => 'Category deleted successfully']);
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to update Category']);
        }
    }
}
