@extends('layouts.auth.app')
@section('title','Tickets')
@section('content')
<div class="content-wrapper mt-4">

    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create User</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('user-store') }}" method="POST">
                @csrf
                <div class="card-body row">
                    <div class="form-group col-md-6">
                        <label for="name">User Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="User Name" value="{{ old('name')}}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                      <label for="email">User Email</label>
                      <input type="email" name="email" class="form-control" id="email" placeholder="User Email" value="{{ old('email')}}">
                      @error('email')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group col-md-6">
                      <label for="password">Password</label>
                      <input type="password" name="password" class="form-control" id="password" placeholder="User Password" >
                      @error('password')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="form-group col-md-6">
                      <label for="password">Confirm Password</label>
                      <input type="password" name="password_confirmation" class="form-control" id="password" placeholder="Confirm Password">
                      @error('password_confirmation')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                  </div>


                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>


    </section>
</div>
@endsection
