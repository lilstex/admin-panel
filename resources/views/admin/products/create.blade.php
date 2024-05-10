@extends('admin.layout.layout')
@section('content')
<!-- FORM START -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Product Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Product Management</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

<!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>

                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <h5>{{ $title }}</h5>
                <div class="row">
                <div class="col-12">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    {{-- CUSTOM ALERT MESSAGE --}}
                    @if (Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success:</strong> {{ Session::get('success_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                   <!-- form start -->
                    <form name="productForm" id="productForm" @if (empty($product['id'])) action="{{ url('admin/products') }}" @else action="{{ url('admin/products/' . $product['id'] . '') }}" @endif method="post">
                        @csrf
                        @if (!empty($product['id']))
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Product Name *</label>
                                <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter product name" @if (!empty($product['product_name'])) value="{{ $product['product_name'] }}" @else value="{{ old('product_name') }}" @endif required>
                            </div>
                            <div class="form-group">
                                <label for="product_code">Product Code</label>
                                <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Enter product code" @if (!empty($product['product_code'])) value="{{ $product['product_code'] }}" @else value="{{ old('product_code') }}" @endif required>
                            </div>
                            <div class="form-group">
                                <label for="name">Category *</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($categoryLevels as $categoryLevel)
                                    <option value="{{ $categoryLevel['id'] }}" @if (!empty($product['id']) && $product['category_id'] == $categoryLevel['id']) selected @endif>
                                        {{ $categoryLevel['category_name'] }}
                                    </option>
                                        @if(!empty($categoryLevel['subcategories']))
                                        @foreach ($categoryLevel['subcategories'] as $subLevel)
                                            <option value="{{ $subLevel['id'] }}" @if (!empty($product['id']) && $product['category_id'] == $subLevel['id']) selected @endif>
                                                &nbsp;&nbsp;&raquo; {{ $subLevel['category_name'] }}
                                            </option>
                                                @if(!empty($subLevel['subcategories']))
                                                @foreach ($subLevel['subcategories'] as $subsubLevel)
                                                    <option value="{{ $subsubLevel['id'] }}" @if (!empty($product['id']) && $product['category_id'] == $subsubLevel['id']) selected @endif>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&raquo; {{ $subsubLevel['category_name'] }}
                                                    </option>
                                                @endforeach
                                                @endif
                                        @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_price">Price</label>
                                <input type="text" class="form-control" name="product_price" id="product_price" placeholder="Enter price" @if (!empty($product['product_price'])) value="{{ $product['product_price'] }}" @else value="{{ old('product_price') }}" @endif required>
                            </div>
                            <div class="form-group">
                                <label for="meta_title">Meta Title</label>
                                <input type="text" class="form-control" name="meta_title" id="meta_title" placeholder="Enter meta title" @if (!empty($product['meta_title'])) value="{{ $product['meta_title'] }}" @else value="{{ old('meta_title') }}" @endif>
                            </div>
                            <div class="form-group">
                                <label for="meta_title">Product Image</label>
                                <input type="file" class="form-control" name="product_image">
                                @if (isset($product['image']))
                                    <a href="{{ url('admin/images/product/'.$product['image']) }}" target="_blank">
                                        <img style="width: 50px; margin: 10px" src="{{ url('admin/images/product/'.$product['image']) }}" alt="Image">
                                    </a>
                                    <form method="POST" action="{{ url('admin/products/image/' . $product['id']) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" name="product" class="confirmDelete" style="background: none; border: none; padding: 0; color: #fff;">
                                          <i class="fas fa-trash"></i>
                                        </button>
                                      </form>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input type="text" class="form-control" name="meta_keywords" id="meta_keywords" placeholder="Enter keywords" @if (!empty($product['meta_keywords'])) value="{{ $product['meta_keywords'] }}" @else value="{{ old('meta_keywords') }}" @endif>
                            </div>
                            <div class="form-group">
                                <label for="meta_desc">Meta Description</label>
                                <input type="text" class="form-control" name="meta_desc" id="meta_desc" placeholder="Enter meta description" @if (!empty($product['meta_desc'])) value="{{ $product['meta_desc'] }}" @else value="{{ old('meta_desc') }}" @endif>
                            </div>
                            <div class="form-group">
                                <label for="product_discount">Product Discount</label>
                                <input type="text" class="form-control" name="product_discount" id="product_discount" placeholder="Enter discount" @if (!empty($product['product_discount'])) value="{{ $product['product_discount'] }}" @else value="{{ old('product_discount') }}" @endif>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="desc" rows="3" placeholder="Enter description">@if (!empty($product['desc'])) {{ $product['desc'] }} @endif</textarea>
                            </div>
                            <div class="form-group">
                                <label for="is_feature">Featured</label>
                                <input type="checkbox" class="form-control" name="is_featured" value="Yes">
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                   <!-- form end -->
                </div>
            
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
           
            </div>
            <!-- /.card -->
        </div>
    <!-- /.container-fluid -->
    </section>
<!-- /.content -->
</div>
<!-- FORM ENDS -->
@endsection