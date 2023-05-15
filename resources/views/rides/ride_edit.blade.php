@extends('layouts.auth.app')
@section('title','Rides')
@section('content')
<div class="content-wrapper mt-4">

    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Ride</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('ride-update') }}" method="POST">
                @csrf

                <input type="hidden" name="ride_id" value="{{ $ride->id }}">
                <div class="card-body row">
                  <div class="form-group col-md-6">
                    <label for="ride_title">RIde Title</label>
                    <input type="text" name="ride_title" class="form-control" id="ride_title" placeholder="ride Title" value="{{ old('ride_title', $ride->title) }}">
                  </div>
                  <div class="form-group  col-md-6" >
                    <label for="ride_description">Ride Description</label>
                    <input type="text" name="description" class="form-control" id="ride_description" placeholder="ride Description" value="{{ old('ride_title', $ride->description) }}">
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
