@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Admin Management</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Admin Management</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12">
            <!-- TABLE STARTS -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Admin Management</h3>
                <a class="btn btn-block btn-primary" href="{{ url('admin/subadmin/register') }}" style="max-width: 150px; float: right; display: inline-block">Add Admin</a>
              </div>
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
              <!-- /.card-header -->
              <div class="card-body">
                <table id="subadmins" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($admins as $admin)
                    <tr>
                      <td>{{ $admin['id'] }}</td>
                      <td>{{ $admin['name'] }}</td>
                      <td>{{ $admin['email'] }}</td>
                      <td>{{ $admin['phone'] }}</td>
                      <td>
                        @if ($admin['status'] == 1)
                        <a class="updateAdminStatus" id="admin-{{$admin['id']}}" admin_id="{{ $admin['id'] }}" href="javascript:void(0)" style="color: #3f6ed3;">
                          <i status="Active" class="fas fa-toggle-on"></i>
                        </a>
                        @else
                        <a class="updateAdminStatus" id="admin-{{$admin['id']}}" admin_id="{{ $admin['id'] }}" href="javascript:void(0)" style="color: grey;">
                          <i status="Inactive" class="fas fa-toggle-off"></i>
                        </a>
                        @endif
                        &nbsp;&nbsp;
                        <a href="{{ url('admin/subadmin/' . $admin['id'] . '/edit') }}"><i style="color: #3f6ed3;" class="fas fa-edit"></i></a>
                        &nbsp;&nbsp;
                        <a href="{{ url('admin/subadmin/' . $admin['id'] . '/roles') }}"><i style="color: #3f6ed3;" class="fas fa-unlock"></i></a>
                        &nbsp;&nbsp;
                        <form method="POST" action="{{ url('admin/subadmin/' . $admin['id']) }}" style="display: inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" name="admin" class="confirmDelete" style="background: none; border: none; padding: 0; color: #dc3545;">
                            <i class="fas fa-trash"></i>
                          </button>
                      </form>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- TABLE ENDS -->
          </div>
         

          
        </div>
        <!-- /.row -->

      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection