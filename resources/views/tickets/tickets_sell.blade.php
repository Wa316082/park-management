@extends('layouts.auth.app')
@section('title','Tickets')
@section('content')
<div class="content-wrapper mt-4">

    <!-- Main content -->
    <section class="content">
        <div class="card ">
              <div class="card-header">
                <h3 class="card-title">Sell Tickets</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div>
                <div class="card-body row">
                  <form class="form-group col-md-6 ticket_code ">
                    <label for="ticket_code">Barcode Scan</label>
                    <input type="text" name="ticket_code" class="form-control" id="ticket_code" autofocus>
                  </form>
                  <div class="col-md-6 " >

                    <div class="row row-cols-1 row-cols-md-3">
                        @foreach ($tickets as $ticket)
                        <div class="col mb-4">
                            <div class="card sell-ticket" style="cursor: pointer">
                                <div class="card-header">
                                    <h4>{{ $ticket->ticket_type }}</h4>
                                </div>
                                <div class="card-body">
                                    <h5>{{ $ticket->title }}</h5>
                                    <p>{{ $ticket->description }}</p>
                                    <input type="hidden" class="code" value="{{ $ticket->ticket_code }}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                      </div>
                </div>
              </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>



<script>
    $('.ticket_code').submit(function(e){
        e.preventDefault();
        const ticketCode = $('#ticket_code').val();
        print(ticketCode);
        $('#ticket_code').val('');
    })
    $('.sell-ticket').click(function(e){
        e.preventDefault();
        const ticketCode = $(this).find('.code').val();
        print(ticketCode);
    })



    function print (ticketCode){
        $.ajax({
            url: `ticket-print`,
            type: 'GET',
            data: {'ticketCode':ticketCode}
            , success: function(response) {
                var ticket_info = response.ticket_info;
                var ticket = response.ticket;
                var sr_no = response.sr_no;
                var date = new Date();
                var localdate= (date.toLocaleString('default', { month: 'short' })) + ' - ' + date.getDate() + ' - ' + date.getFullYear()
                var image= new Image();
                image.src='{{ asset("")}}' +ticket_info.image;
                image.onload = () => {
                var doc = new jsPDF({
                            orientation: 'p',
                            unit: 'mm',
                            format: [
                                78, 210]
                        });

                    doc.addImage( image,'png', 10, 5, 50, 30);

                    doc.setFontSize(10);

                    doc.text(
                        "Management By :"

                        , 2
                        , 45, {
                            maxWidth: 100
                        }
                        , 0
                    );
                    doc.text(
                        `${ticket_info.management_name}`

                        , 2
                        , 50, {
                            maxWidth: 100
                        }
                        , 0
                    );
                    doc.setFontSize(15);
                    doc.text(
                        `${ticket_info.org_name}`
                        , 6
                        , 60, {
                            maxWidth: 100
                        }
                        , 0
                    );
                    if(ticket_info.org_name_2){
                    doc.text(
                        ticket_info.org_name_2
                        , 6
                        , 65, {
                            maxWidth: 100
                        }
                        , 0
                    );
                    }
                    doc.setFontSize(15);
                    doc.text(
                        `${ticket.ticket_type}`
                        , 20
                        , 75, {
                            maxWidth: 100
                        }
                        , 0
                    );
                    doc.setFontSize(8);
                        doc.text(
                            "SR: "+ sr_no
                            , 2
                            , 85, {
                                maxWidth: 50
                            }
                            , 0
                        );
                    doc.text(
                        "Date :"+ localdate
                        , 45
                        , 85, {
                            maxWidth: 50
                        }
                        , 0
                    );
                    doc.setFontSize(8);
                    doc.text(
                        `${ticket.title}`
                        , 2
                        , 95, {
                            maxWidth: 50
                        }
                        , 0
                    );
                    doc.text(
                        "Ticket Price : "+ticket.price
                        , 25
                        , 95, {
                            maxWidth: 50
                        }
                        , 0
                    );
                    doc.text(
                        " 1 person"
                        , 55
                        , 95, {
                            maxWidth: 50
                        }
                        , 0
                    );

                    doc.setFontSize(10);
                        doc.text(
                            "Total Price:"+ (ticket.price)
                            , 2
                            , 105, {
                                maxWidth: 50
                            }
                            , 0
                        );

                    doc.setFontSize(10);
                    doc.text(
                        `${ticket_info.greetings}`
                        , 15
                        , 115, {
                            maxWidth: 50
                        }
                        , 0
                    );

                    doc.setFontSize(10);

                    if (ticket_info.email_1) {
                        doc.text(
                        "Email: "+ ticket_info.email_1
                        , 2
                        , 125, {
                            maxWidth: 50
                        }
                        , 0
                    );

                    }
                    if (ticket_info.email_2) {
                        doc.text(
                        "Email: "+ ticket_info.email_2
                        , 2
                        , 130, {
                            maxWidth: 50
                        }
                        , 0
                    );

                    }

                    if (ticket_info.phone_1) {
                        doc.setFontSize(10);
                        doc.text(
                        "Phone: "+ ticket_info.phone_1
                        , 2
                        , 135, {
                            maxWidth: 50
                        }
                        , 0
                    );

                    }

                    if (ticket_info.phone_2) {
                        doc.setFontSize(10);
                        doc.text(
                        "Phone: "+ ticket_info.phone_2
                        , 2
                        , 140, {
                            maxWidth: 50
                        }
                        , 0
                    );

                    }

                doc.autoPrint()

                const blob =  doc.output('blob');
                const url = URL.createObjectURL(blob);
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.src = url;
                document.body.appendChild(iframe);
                iframe.contentWindow.print();
            }
            }, error: function(error) {
                console.error(error);
            }
        })

    }


</script>
@endsection
