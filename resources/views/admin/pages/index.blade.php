@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Content Management System (CMS)</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">CMS Pages</li>
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
                <h3 class="card-title">Content Management System Pages</h3>
                <a class="btn btn-block btn-primary" href="{{ url('admin/cms_page/create') }}" style="max-width: 150px; float: right; display: inline-block">Add CMS Page</a>
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
                <table id="cmsPages" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>URL</th>
                    <th>Created On</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($allPages as $page)
                    <tr>
                      <td>{{ $page['id'] }}</td>
                      <td>{{ $page['title'] }}</td>
                      <td>{{ $page['url'] }}</td>
                      <td>{{ date("F j, Y, g:i a", strtotime($page['created_at'])) }}</td>
                      <td>
                        @if ($page['status'] == 1)
                        <a class="updateCmsStatus" id="page-{{$page['id']}}" page_id="{{ $page['id'] }}" href="javascript:void(0)" style="color: #3f6ed3;">
                          <i status="Active" class="fas fa-toggle-on"></i>
                        </a>
                        @else
                        <a class="updateCmsStatus" id="page-{{$page['id']}}" page_id="{{ $page['id'] }}" href="javascript:void(0)" style="color: grey;">
                          <i status="Inactive" class="fas fa-toggle-off"></i>
                        </a>
                        @endif
                        &nbsp;&nbsp;
                        <a href="{{ url('admin/cms_page/' . $page['id'] . '/edit') }}"><i style="color: #3f6ed3;" class="fas fa-edit"></i></a>
                        &nbsp;&nbsp;
                        {{-- <a href="{{ url('admin/cms_page/' . $page['id'] . '') }}"><i style="color: #dc3545;" class="fas fa-trash"></i></a> --}}
                        <form method="POST" action="{{ url('admin/cms_page/' . $page['id']) }}" style="display: inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" name="CMS Page" class="confirmDelete" style="background: none; border: none; padding: 0; color: #dc3545;">
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