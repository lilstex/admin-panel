<?php 

namespace App\Repositories;

use App\Contracts\ProductInterface;
use App\Models\AdminsRole;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

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

    public function filter() {
        return Product::filterProducts();
    }

    public function create(array $data) {
        // Upload product video
        if(isset($data['product_video']) && $data['product_video']->isValid()) {
            // Generate unique image name
            $video_name = uniqid('product_').'.'.$data['image']->getClientOriginalExtension();
            
            $video_url = 'admin/videos/product/'.$video_name;

            // read image from file system
            $data['product_video']->move($video_url, $video_name);

        } else {
            $video_name = '';
        }

        // Check for product discount and calculate the final price
        if(isset($data['product_discount']) && $data['product_discount'] > 0) {
            // Set the discount type
            $discount_type = 'product';
            $final_price = $data['product_price'] - ($data['product_price'] * $data['product_discount'])/100;
        } else {
            $getCategoryDiscount = Category::select('category_discount')->where('id', $data['category_id'])->first();
            if($getCategoryDiscount->category_discount > 0) {
                $discount_type = 'category';
                $final_price = $data['product_price'] - ($data['product_price'] * $$getCategoryDiscount->category_discount)/100;
            } else {
                $discount_type = '';
                $final_price = $data['product_price'];
            }
        }

        $product = Product::create([
            'parent_id' => $data['parent_id'],
            'category_name' => $data['category_name'],
            'category_discount' => $data['category_discount'],
            'desc' => $data['desc'],
            'url' => $data['url'],
            'meta_desc' => $data['meta_desc'],
            'meta_title' => $data['meta_title'],
            'meta_keywords' => $data['meta_keywords'],
            'status' => 1,
            'product_video' => $video_name,
            'product_discount' => $data['product_discount'],
            'product_price' => $data['product_price'],
            'discount_type' => $discount_type,
            'final_price' => $final_price,
        ]);

        // Upload product images
        if(isset($data['product_images']) && $data['product_images']->isValid()) {
            // Get the product ID
            $product_id = DB::getPdo()->lastInsertId();

            foreach ($data['product_images'] as $key => $prod_image) {
                // Generate unique image name
                $image_name = uniqid('product_').'.'.$prod_image->getClientOriginalExtension();
                // create image manager with desired driver
                $manager = new ImageManager(new Driver());
                
                // read image from file system
                $image = $manager->read($prod_image);

                $image_url = 'admin/images/product/'.$image_name;
                // save modified image in new format 
                $image->toJpeg(80)->save($image_url);

                ProductsImage::create([
                    'product_id' => $product_id,
                    'image' => $image_name,
                    'image_sort' => 0,
                    'status' => 1,
                ]);
            }

        }


        return $product;
    }

    public function show($id) {
        return Product::with('images')->find($id);
    }

    public function update($id, array $data) {
         // Upload product image
         if(isset($data['image']) && $data['image']->isValid()) {
            // Generate unique image name
            $image_name = uniqid('product_').'.'.$data['image']->getClientOriginalExtension();

            // create image manager with desired driver
            $manager = new ImageManager(new Driver());
            
            // read image from file system
            $image = $manager->read($data['image']);

            $image_url = 'admin/images/product/'.$image_name;
            // save modified image in new format 
            $image->toJpeg(80)->save($image_url);

        } else {
            $image_name = '';
        }

        // Upload product video
         if(isset($data['product_video']) && $data['product_video']->isValid()) {
            // Generate unique image name
            $video_name = uniqid('product_').'.'.$data['image']->getClientOriginalExtension();
            
            $video_url = 'admin/videos/product/'.$video_name;

            // read image from file system
            $data['product_video']->move($video_url, $video_name);

        } else {
            $video_name = '';
        }

        // Check for product discount and calculate the final price
        if(isset($data['product_discount']) && $data['product_discount'] > 0) {
            // Set the discount type
            $discount_type = 'product';
            $final_price = $data['product_price'] - ($data['product_price'] * $data['product_discount'])/100;
        } else {
            $getCategoryDiscount = Category::select('category_discount')->where('id', $data['category_id'])->first();
            if($getCategoryDiscount->category_discount > 0) {
                $discount_type = 'category';
                $final_price = $data['product_price'] - ($data['product_price'] * $$getCategoryDiscount->category_discount)/100;
            } else {
                $discount_type = '';
                $final_price = $data['product_price'];
            }
        }


        $product = Product::find($id);
        return $product->update([
            'parent_id' => $data['parent_id'],
            'category_name' => $data['category_name'],
            'category_discount' => $data['category_discount'],
            'desc' => $data['desc'],
            'url' => $data['url'],
            'meta_desc' => $data['meta_desc'],
            'meta_title' => $data['meta_title'],
            'meta_keywords' => $data['meta_keywords'],
            'product_image' => $image_name,
            'product_video' => $video_name,
            'product_discount' => $data['product_discount'],
            'product_price' => $data['product_price'],
            'discount_type' => $discount_type,
            'final_price' => $final_price,
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
        $prod_image =  ProductsImage::select('image')->where('id', $id)->first();
        // Get the image path
        $image_path = 'admin/images/product/';
        // Remove the image from the folder
        if(file_exists(($image_path.$prod_image->image))) {
            unlink($image_path.$prod_image->image);
        }
        // Remove the image from the DB table
        return ProductsImage::where('id', $id)->delete();
    }

    public function deleteVideo($id) {
        // Get the video from the DB
        $prod_video =  Product::select('product_video')->where('id', $id)->first();
        // Get the video path
        $video_path = 'admin/videos/product/';
        // Remove the video from the folder
        if(file_exists(($video_path.$prod_video->product_video))) {
            unlink($video_path.$prod_video->product_video);
        }
        // Remove the video from the DB table
        return Product::where('id', $id)->update(['product_video' => '']);
    }
}