@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Category Management</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Category Management</li>
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
                <h3 class="card-title">All Categories</h3>
                @if ($permissions['full_access'] == 1)
                  <a class="btn btn-block btn-primary" href="{{ url('admin/categories/create') }}" style="max-width: 150px; float: right; display: inline-block">Add Category</a>
                @endif
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
                <table id="categories" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Parent Name</th>
                    <th>URL</th>
                    <th>Created On</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($allCategories as $category)
                    <tr>
                      <td>{{ $category['id'] }}</td>
                      <td>{{ $category['category_name'] }}</td>
                      <td>
                      @if (isset($category['parentcategory']['category_name']))
                        {{ $category['parentcategory']['category_name'] }}
                      @endif
                      </td>
                      <td>{{ $category['url'] }}</td>
                      <td>{{ date("F j, Y, g:i a", strtotime($category['created_at'])) }}</td>
                      <td>
                      @if ($permissions['edit_access'] == 1 || $permissions['full_access'] == 1)
                        @if ($category['status'] == 1)
                        <a class="updateCategoryStatus" id="page-{{$category['id']}}" page_id="{{ $category['id'] }}" href="javascript:void(0)" style="color: #3f6ed3;">
                          <i status="Active" class="fas fa-toggle-on"></i>
                        </a>
                        @else
                        <a class="updateCategoryStatus" id="page-{{$category['id']}}" page_id="{{ $category['id'] }}" href="javascript:void(0)" style="color: grey;">
                          <i status="Inactive" class="fas fa-toggle-off"></i>
                        </a>
                        @endif
                        &nbsp;&nbsp;
                        <a href="{{ url('admin/categories/' . $category['id'] . '/edit') }}"><i style="color: #3f6ed3;" class="fas fa-edit"></i></a>
                        &nbsp;&nbsp;
                      @endif
                      @if ($permissions['full_access'] == 1)
                        <form method="POST" action="{{ url('admin/categories/' . $category['id']) }}" style="display: inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" name="category" class="confirmDelete" style="background: none; border: none; padding: 0; color: #dc3545;">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
                      @endif
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