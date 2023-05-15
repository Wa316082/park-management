@extends('layouts.auth.app')
@section('title','Ticket List')
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
                        <h5>Tickets list</h5>
                      </div>
                      <div class="col-sm-6">

                          <div class="breadcrumb-item float-sm-right"><a class="btn btn-primary" href="{{ route('ticket-create') }}">Add</a></div>
                      </div>
                    </div>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Ticket Title</th>
                    <th>Ticket Type</th>
                    <th>Ticket Desc</th>
                    <th>Ticket Price</th>
                    <th>Ticket Code</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($tickets as $ticket )
                  <tr>
                    <td>{{ $ticket->title }}</td>
                    <td>{{ $ticket->ticket_type }}
                    </td>
                    <td>{{ $ticket->description }}</td>
                    <td class="price">{{ $ticket->price }}</td>
                    <td>{{ $ticket->ticket_code }}</td>
                    <td class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-sm btn-primary print_barcode"id="{{ $ticket->id }}">Print Barcode</button>
                        <a class="btn btn-info btn-sm" href="{{ url('ticket-edit',$ticket->id) }}">Edit</a>
                        <a class="btn btn-danger btn-sm" href="{{ url('ticket-delete',$ticket->id) }}">Delete</a>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
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


    $('.print_barcode').click(function(){
        let id = $(this).attr('id');
        $.ajax({
            url: `barcode-print`,
            type: 'GET',
            data: {'id':id}
            , success: function(response) {
                let barcodeURL = response.barcodeURL;
                var ticket = response.ticket;
                var doc = new jsPDF({
                            orientation: 'p',
                            unit: 'mm',
                            format: [
                                78, 210]
                        });
                    doc.setFontSize(13);
                    doc.text(
                        "Amusment Park Ticket Barcode"

                        , 5
                        , 10, {
                            maxWidth: 100
                        }
                        , 0
                    );

                    doc.addImage(barcodeURL,'png', 12, 15, 50, 10);
                    doc.setFontSize(12);
                    doc.text(
                        `${ticket.ticket_code}`

                        , 20
                        , 30, {
                            maxWidth: 100
                        }
                        , 0
                    );
                    doc.setFontSize(12);
                    doc.text(
                        `${ticket.title}`

                        , 24
                        , 35, {
                            maxWidth: 100
                        }
                        , 0
                    );
                doc.autoPrint()

                const blob =  doc.output('blob');
                const url = URL.createObjectURL(blob);
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.src = url;
                document.body.appendChild(iframe);
                iframe.contentWindow.print();

            }, error: function(error) {
                console.error(error);
            }
        })

    });
  </script>
  @endsection
