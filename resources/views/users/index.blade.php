@extends('layouts.auth.app')
@section('title','user List')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper mt-4">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header container-fluid">
                    <div class="row mb-2">
                      <div class="col-sm-6">
                        <h5>users list</h5>
                      </div>
                      <div class="col-sm-6">

                          <div class="breadcrumb-item float-sm-right"><a class="btn btn-primary" href="{{ route('user-create') }}">Add User</a></div>
                      </div>
                    </div>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user )
                  <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}
                    </td>
                    <td>{{ $user->role->name }}</td>
                    <td class="d-flex justify-content-between align-items-center">
                        <a class="btn btn-info btn-sm" href="{{ url('user-edit',$user->id) }}">Edit</a>
                        <a class="btn btn-danger btn-sm" href="{{ url('user-delete',$user->id) }}">Delete</a>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection
@section('scripts')
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });

  </script>
  @endsection
