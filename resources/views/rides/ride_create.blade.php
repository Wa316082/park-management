@extends('layouts.auth.app')
@section('title','Rides')
@section('content')
<div class="content-wrapper mt-4">

    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create New Ride</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('ride-store') }}" method="POST">
                @csrf
                <div class="card-body row">
                  <div class="form-group col-md-6">
                    <label for="ride_title">RIde Title</label>
                    <input type="text" name="ride_title" class="form-control" id="ride_title" placeholder="ride Title">
                    @error('ride_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                  <div class="form-group  col-md-6" >
                    <label for="ride_description">Ride Description</label>
                    <input type="text" name="description" class="form-control" id="ride_description" placeholder="ride Description">
                    @error('description')
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
