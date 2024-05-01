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
                <h1>Content Management System (CMS)</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">CMS Page</li>
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
                    <form name="cmsForm" id="cmsForm" @if (empty($cmsPage['id'])) action="{{ url('admin/cms_page') }}" @else action="{{ url('admin/cms_page/' . $cmsPage['id'] . '') }}" @endif method="post">
                        @csrf
                        @if (!empty($cmsPage['id']))
                            @method('PUT')
                        @endif
                        <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title *</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Enter Page Title" @if (!empty($cmsPage['title'])) value="{{ $cmsPage['title'] }}" @endif required>
                        </div>
                        <div class="form-group">
                            <label for="url">URL *</label>
                            <input type="text" class="form-control" name="url" id="url" placeholder="Enter Page URL" @if (!empty($cmsPage['url'])) value="{{ $cmsPage['url'] }}" @endif required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description *</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Enter Page Description">@if (!empty($cmsPage['desc'])) {{ $cmsPage['desc'] }} @endif</textarea>
                          </div>
                        <div class="form-group">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" class="form-control" name="meta_title" id="meta_title" @if (!empty($cmsPage['meta_title'])) value="{{ $cmsPage['meta_title'] }}" @endif placeholder="Enter Meta Title">
                        </div>
                        <div class="form-group">
                            <label for="meta_keywords">Meta Keywords</label>
                            <input type="text" class="form-control" name="meta_keywords" id="meta_keywords" @if (!empty($cmsPage['meta_keywords'])) value="{{ $cmsPage['meta_keywords'] }}" @endif placeholder="Enter Meta Keywords">
                        </div>
                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <input type="text" class="form-control" name="meta_description" id="meta_description" @if (!empty($cmsPage['meta_desc'])) value="{{ $cmsPage['meta_desc'] }}" @endif placeholder="Enter Meta Description">
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