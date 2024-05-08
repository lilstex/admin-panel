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
                <h1>Admin Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Admin Management</li>
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
                <h5></h5>
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
                    <form name="cmsForm" id="cmsForm" action="{{ url('admin/subadmin/' . $role['admin_id'] . '/roles') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                        <input type="hidden" class="form-control" name="admin_id" value="{{ $role['admin_id'] }}">
                        @if (!empty($role['permissions']))
                            @foreach ($role['permissions'] as $permission)
                            <div class="form-group">
                                <label for="permissions">{{ $permission['module'] }}:</label>&nbsp;&nbsp;
                                <input type="checkbox" name="{{ $permission['module'] }}[view]" @if ($permission['view_access'] == 1) checked @endif value="1"> &nbsp;&nbsp;View Access
                                &nbsp;&nbsp;
                                <input type="checkbox" name="{{ $permission['module'] }}[edit]" @if ($permission['edit_access'] == 1) checked @endif value="1"> &nbsp;&nbsp;Edit Access
                                &nbsp;&nbsp;
                                <input type="checkbox" name="{{ $permission['module'] }}[full]" @if ($permission['full_access'] == 1) checked @endif value="1"> &nbsp;&nbsp;Full Access
                                &nbsp;&nbsp;
                                <input type="hidden" name="{{ $permission['module'] }}[module]" value="{{ $permission['module'] }}">
                            </div>
                            @endforeach
                        @else
                        <div class="form-group">
                            <label for="categories">Categories: </label>&nbsp;&nbsp;
                            <input type="checkbox" name="categories[view]" value="1"> &nbsp;&nbsp;View Access
                            &nbsp;&nbsp;
                            <input type="checkbox" name="categories[edit]" value="1"> &nbsp;&nbsp;Edit Access
                            &nbsp;&nbsp;
                            <input type="checkbox" name="categories[full]" value="1"> &nbsp;&nbsp;Full Access
                            &nbsp;&nbsp;
                            <input type="hidden" name="categories[module]" value="categories">
                        </div>
                        @endif
                        
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