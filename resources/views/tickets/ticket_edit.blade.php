@extends('layouts.auth.app')
@section('title','Tickets')
@section('content')
<div class="content-wrapper mt-4">

    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tickets Edit</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('ticket-update') }}" method="POST">
                @csrf
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                <div class="card-body row">
                  <div class="form-group col-md-6">
                    <label for="ticket_title">Ticket Title/ টিকিট</label>
                    <input type="text" name="title" class="form-control" id="ticket_title" placeholder="Ticket Title" value="{{ old('title', $ticket->title) }}">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                  <div class="form-group  col-md-6 ">
                    <label for="ticket_type">Ticket Type</label>
                    <select  name="ticket_type" class="form-control" id="ticket_type" placeholder="Ticket Type">
                        <option value="">Select One</option>
                        <option value="Entry Ticket" {{ $ticket->ticket_type == 'Entry Ticket' ? 'selected' : '' }}>Entry Ticket</option>
                        <option value="Ride Ticket" {{ $ticket->ticket_type == 'Ride Ticket' ? 'selected' : '' }}>Ride Ticket</option>
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
                        <option value="{{ $ride->id }}" {{ $ticket->ride_id == $ride->id ? 'selected' : '' }}>{{ $ride->title }}</option>
                        @endforeach


                    </select>
                    @error('ride')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group  col-md-6" >
                    <label for="ticket_description">Ticket Description</label>
                    <input type="text" name="description" class="form-control" id="ticket_description" placeholder="Ticket Description" value="{{ old('description', $ticket->description) }}">
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                  <div class="form-group  col-md-6">
                    <label for="ticket_price">Ticket Price</label>
                    <input type="number" name="ticket_price" class="form-control" id="ticket_price" placeholder="Ticket Price" value="{{ old('description', $ticket->price) }}">
                    @error('ticket_price')
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
