@extends('layouts.auth.app')
@section('title','Tickets')
@section('content')
<div class="content-wrapper mt-4">

    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create New Tickets</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('ticket-store') }}" method="POST">
                @csrf
                <div class="card-body row">
                  <div class="form-group col-md-6">
                    <label for="ticket_title">Ticket Title/ টিকিট</label>
                    <input type="text" name="title" class="form-control" id="ticket_title" placeholder="Ticket Title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                  <div class="form-group  col-md-6 ">
                    <label for="ticket_type">Ticket Type</label>
                    <select  name="ticket_type" class="form-control" id="ticket_type" placeholder="Ticket Type">
                        <option value="">Select One</option>
                        <option value="Entry Ticket">Entry Ticket</option>
                        <option value="Ride Ticket">Ride Ticket</option>
                    </select>
                    @error('ticket_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group  col-md-6 ">
                    <label for="ride">Select Ride</label>
                    <select  name="ride" class="form-control" id="ride" placeholder="Ride">
                        <option value="">Select Ride</option>
                        @foreach ($rides as $ride )
                        <option value="{{ $ride->id }}">{{ $ride->title }}</option>
                        @endforeach
                    </select>
                    @error('ride')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group  col-md-6" >
                    <label for="ticket_description">Ticket Description</label>
                    <input type="text" name="description" class="form-control" id="ticket_description" placeholder="Ticket Description">
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                  <div class="form-group  col-md-6">
                    <label for="ticket_price">Ticket Price</label>
                    <input type="number" name="ticket_price" class="form-control" id="ticket_price" placeholder="Ticket Price">
                    @error('ticket_price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror</div>

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
