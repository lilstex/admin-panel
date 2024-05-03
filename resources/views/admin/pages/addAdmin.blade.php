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
                    <form name="cmsForm" id="cmsForm" @if (empty($subadmin['id'])) action="{{ url('admin/subadmin/register') }}" @else action="{{ url('admin/subadmin/' . $subadmin['id'] . '') }}" @endif method="post">
                        @csrf
                        @if (!empty($subadmin['id']))
                            @method('PUT')
                        @endif
                        <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" @if (!empty($subadmin['name'])) value="{{ $subadmin['name'] }}" @else value="{{ old('name') }}" @endif required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email" @if (!empty($subadmin['email'])) value="{{ $subadmin['email'] }}" @else value="{{ old('email') }}" @endif required>
                        </div>
                        @if (!isset($subadmin['id']))
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="****************">
                        </div>
                        <div class="form-group">
                            <label for="password">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password" placeholder="****************">
                        </div>
                        @else
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ $subadmin['phone'] }}">
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