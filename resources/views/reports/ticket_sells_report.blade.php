@extends('layouts.auth.app')
@section('title','Reports')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper mt-4">

    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Date picker</h3>
            </div>
            <form class="card-body row" action="{{ route('ticket-report-search') }}" method="GET">
                <div class="form-group col-md-4">
                    <label>Ticket Type</label>
                    <select  class="form-control select2bs4" name="ticket_type" style="width: 100%;">
                      <option value="">Select One</option>
                      <option value="Entry Ticket">Entry Ticket</option>
                      <option value="Ride Ticket">Ride Ticket</option>

                    </select>
                  </div>
                <div class="form-group col-md-4">
                    <label>Select Ride</label>
                    <select class="form-control select2bs4" name="ride_id" style="width: 100%;">
                      <option value="">Select One</option>
                      @foreach ($rides as $ride )
                      <option value="{{ $ride->id }}">{{ $ride->title }}</option>
                      @endforeach
                    </select>
                  </div>
              <!-- Date and time range -->
                <div class="form-group col-md-4">
                    <label>Date range </label>
                    <div class="input-group" >
                    <button type="button" class="btn btn-default float-right" id="daterange-btn">
                        <i class="far fa-calendar-alt"></i> Date range picker
                        <i class="fas fa-caret-down"></i>
                    </button>
                    </div>
                    <input type="hidden" name='date_range' id="dayerange">
                </div>
                <div class="my-auto">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </form>
        </div>

      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header container-fluid">
                    <div class="row mb-2">
                      <div class="col-sm-6">
                        <h5>Ticket sells report</h5>
                      </div>
                    </div>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th>Date:</th>
                    <th>Ticket Title</th>
                    <th>Ticket Ride</th>
                    <th>Ticket SR No:</th>
                    <th>Ticket Price</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($sells_reports as $data )
                  <tr>
                    <td>{{ $data->created_at->format('d-M-Y') }}</td>
                    <td>{{ $data->ticket_title }}</td>

                    @if ($data->ride != null)
                    <td>{{ $data->ride->title}}</td>
                    @else
                    <td>Empty</td>
                    @endif
                    <td>{{ $data->ticket_serial_number}}</td>
                    <td class="price">{{ $data->ticekt_price }}</td>
                  </tr>

                  @endforeach


                  <tr>
                      <th>Date:</th>
                    <th>Ticket Title</th>
                    <th>Ticket Ride</th>
                    <th>Ticket SR NO</th>
                    <th>{{ $totalsells }}</th>
                </tr>
                </tbody>
                </table>
                <div> Total sells ticket: {{ $sells_reports->total() }}</div>
                <div class=" d-flex justify-content-center ">
                    {{ $sells_reports->links() }}
                </div>
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
        "responsive": true, "lengthChange": false, "autoWidth": false,"paging": false,"info": false,
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


    // $(document).ready(function() {
    //     var data = 0
    //      $('.price').each(function() {
    //         data += parseFloat($(this).text());
    //         });
    //     $('.totat_price').html(data);
    // });
  </script>

<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
      //Money Euro
      $('[data-mask]').inputmask()

      //Date picker
      $('#reservationdate').datetimepicker({
          format: 'L'
      });

      //Date and time picker
      $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

      //Date range picker
      $('#reservation').daterangepicker()
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
          format: 'MM/DD/YYYY hh:mm A'
        }
      })
      //Date range as a button
      $('#daterange-btn').daterangepicker(
        {
          ranges   : {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate  : moment()
        },
        function (start, end) {
            // console.log('Selected date range: ' + start.format('M-D-YYYY') + ' - ' + end.format('M-D-YYYY'));
          $('#dayerange').val(start.format('YYYY-M-D') + '/' + end.format('YYYY-M-D'))
          $('#daterange-btn').html(start.format('YYYY-M-D') + '/' + end.format('YYYY-M-D'))
        }
      )

      //Timepicker
      $('#timepicker').datetimepicker({
        format: 'LT'
      })

    //   //Bootstrap Duallistbox
    //   $('.duallistbox').bootstrapDualListbox()

    //   //Colorpicker
    //   $('.my-colorpicker1').colorpicker()
    //   //color picker with addon
    //   $('.my-colorpicker2').colorpicker()

    //   $('.my-colorpicker2').on('colorpickerChange', function(event) {
    //     $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    //   })
    })

  </script>
  @endsection
