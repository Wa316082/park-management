@extends('layouts.auth.app')
@section('title','Tickets Settings')
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
              <form action="{{ route('update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                <div class="card-body row">
                  <div class="form-group col-md-6">
                    <label for="image"></label>
                    <input type="file" name="image" class="form-control" id="image" placeholder="Ticket Logo" >
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- value="{{ old('title', $ticket->title) }}" --}}

                  <div class="form-group  col-md-6" >
                    <label for="management_name">Management Name</label>
                    <input type="text" name="management_name" class="form-control" id="management_name" placeholder="Management Name" value="{{ old('management_name', $ticket->management_name) }}" >
                    @error('management_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                  <div class="form-group  col-md-6">
                    <label for="org_name">
                        Organigation Name
                    </label>
                    <input type="text" name="org_name" class="form-control" id="org_name" placeholder="Organigation Name" value="{{ old('org_name', $ticket->org_name) }}">
                    @error('org_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group  col-md-6">
                    <label for="org_name_2">
                        Organigation Name 2nd part
                    </label>
                    <input type="text" name="org_name_2" class="form-control" id="org_name_2" placeholder="Organigation Name 2nd part"value="{{ old('org_name_2', $ticket->org_name_2) }}" >
                    @error('org_name_2')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group  col-md-6">
                    <label for="org_name">
                        Greetings
                    </label>
                    <input type="text" name="greetings" class="form-control" id="greetings" placeholder="Greetings" value="{{ old('greetings', $ticket->greetings) }}" >
                    @error('greetings')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group  col-md-6">
                    <label for="org_name">
                      Primary Phone Number
                    </label>
                    <input type="number" name="phone_1" class="form-control" id="phone_1" placeholder="Primary Phone Number"  value="{{ old('phone_1', $ticket->phone_1) }}">
                    @error('phone_1')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group  col-md-6">
                    <label for="org_name">
                      Secondary Phone Number
                    </label>
                    <input type="number" name="phone_2" class="form-control" id="phone_2" placeholder="Secondary Phone Number" value="{{ old('phone_2', $ticket->phone_2) }}" >
                    @error('phone_2')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group  col-md-6">
                    <label for="org_name">
                      Primary Email
                    </label>
                    <input type="email" name="email_1" class="form-control" id="email_1" placeholder="Primary Email" value="{{ old('email_1', $ticket->email_1) }}" >
                    @error('email_1')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group  col-md-6">
                    <label for="email_2">
                      Secondary Email
                    </label>
                    <input type="email" name="email_2" class="form-control" id="email_2" placeholder="Secondary Email" value="{{ old('email_2', $ticket->email_2) }}" >
                    @error('email_1')
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
