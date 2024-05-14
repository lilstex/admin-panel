<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ProductInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public $products;

     /**
     * 
     */
    public function __construct(ProductInterface $productInterface) {
        $this->products = $productInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page', 'category');
        $data = $this->products->all();
        $allProducts = $data['products'];
        $permissions = $data['permissions'];
        if($permissions['view_access'] == 1 || $permissions['edit_access'] == 1 || $permissions['full_access'] == 1) {
            return view('admin.products.index')->with(compact('allProducts', 'permissions'));
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Unauthorised to view this resource']);
        }
    }

    /**
     * Update product status
     */
    public function updateProductStatus(Request $request)
    {
        if($request->ajax()) {
            $data = $request->all();
            $isChanged = $this->products->updateStatus($data);

            if($isChanged) {
                return response()->json(['status' => $data['status'], 'product_id' => $data['product_id']]);
            } else {
                return redirect()->back()->withErrors(['error_message' => 'Failed to update product status']);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Session::put('page', 'product');
        $title = 'Add Product';
        $categoryLevels = $this->products->subcategories();
        $filterProducts = $this->products->filter();
        return view('admin.products.create')->with(compact('title', 'categoryLevels', 'filterProducts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validated();
        $newProduct = $this->products->create($validated);
        
        if($newProduct) {
            return redirect('admin/products')->with(['success_message' => 'New Product added successfully']);
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to add Product']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        Session::put('page', 'product');
        $title = 'Edit Product';
        $product = $this->products->show($id);
        $categoryLevels = $this->products->subcategories();
        $filterProducts = $this->products->filter();
        return view('admin.products.create')->with(compact('title', 'product', 'categoryLevels', 'filterProducts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validated();
        $updatedProduct = $this->products->update($id, $validated);
        
        if($updatedProduct) {
            return redirect('admin/categories')->with(['success_message' => 'Product updated successfully']);
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to update Product']);
        }
    }

    /**
     * Remove product image
     */
    public function deleteImage($id)
    {
        $deletedImage = $this->products->deleteImage($id);
        if($deletedImage) {
            return redirect()->back()->with(['success_message' => 'Product image deleted successfully']);
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to delete product image']);
        }
    }

    /**
     * Remove product video
     */
    public function deleteVideo($id)
    {
        $deletedVideo = $this->products->deleteVideo($id);
        if($deletedVideo) {
            return redirect()->back()->with(['success_message' => 'Product video deleted successfully']);
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to delete product video']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deletedProduct = $this->products->delete($id);
        
        if($deletedProduct) {
            return redirect()->back()->with(['success_message' => 'Product deleted successfully']);
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to update Product']);
        }
    }
}
