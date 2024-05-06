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
                <h1>Category Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Category Management</li>
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
                    <form name="categoryForm" id="categoryForm" @if (empty($category['id'])) action="{{ url('admin/categories') }}" @else action="{{ url('admin/categories/' . $category['id'] . '') }}" @endif method="post">
                        @csrf
                        @if (!empty($category['id']))
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Category Name *</label>
                                <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter category name" @if (!empty($category['category_name'])) value="{{ $category['category_name'] }}" @else value="{{ old('category_name') }}" @endif required>
                            </div>
                            <div class="form-group">
                                <label for="url">URL</label>
                                <input type="text" class="form-control" name="url" id="url" placeholder="Enter url" @if (!empty($category['url'])) value="{{ $category['url'] }}" @else value="{{ old('url') }}" @endif required>
                            </div>
                            <div class="form-group">
                                <label for="meta_title">Meta Title</label>
                                <input type="text" class="form-control" name="meta_title" id="meta_title" placeholder="Enter meta title" @if (!empty($category['meta_title'])) value="{{ $category['meta_title'] }}" @else value="{{ old('meta_title') }}" @endif>
                            </div>
                            <div class="form-group">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input type="text" class="form-control" name="meta_keywords" id="meta_keywords" placeholder="Enter keywords" @if (!empty($category['meta_keywords'])) value="{{ $category['meta_keywords'] }}" @else value="{{ old('meta_keywords') }}" @endif>
                            </div>
                            <div class="form-group">
                                <label for="meta_desc">Meta Description</label>
                                <input type="text" class="form-control" name="meta_desc" id="meta_desc" placeholder="Enter meta description" @if (!empty($category['meta_desc'])) value="{{ $category['meta_desc'] }}" @else value="{{ old('meta_desc') }}" @endif>
                            </div>
                            <div class="form-group">
                                <label for="url">Category Discount</label>
                                <input type="text" class="form-control" name="category_discount" id="category_discount" placeholder="Enter discount" @if (!empty($category['category_discount'])) value="{{ $category['category_discount'] }}" @else value="{{ old('category_discount') }}" @endif>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="desc" rows="3" placeholder="Enter description">@if (!empty($category['desc'])) {{ $category['desc'] }} @endif</textarea>
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