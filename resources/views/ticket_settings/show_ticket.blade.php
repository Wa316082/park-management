@extends('layouts.auth.app')
@section('title','Ticket List')
@section('content')

<div class="content-wrapper ">
    <!-- Main content -->
    <section class="content mt-4">

        <div class="d-flex justify-content-center align-items-center">
            <div class="p-4">
                <button class="btn btn-success show_ticket">View Ticket Preview</button>
            </div>
            <div class="p-4">
                <a href="{{ route('edit') }}" class="btn btn-success">Ticket Edit</a>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>



<script>

        $('.show_ticket').click(function(e){
            e.preventDefault();
            console.log('hello');
            print();
        })

      function print (){
        $.ajax({
            url: `demo-ticket`,
            type: 'GET'
            , success: function(response) {
                var ticket_info = response.ticket_info;
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
                        `Entry Type`
                        , 20
                        , 75, {
                            maxWidth: 100
                        }
                        , 0
                    );
                    doc.setFontSize(8);
                        doc.text(
                            "SR: 00000000"
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
                        `Entry Title`
                        , 2
                        , 95, {
                            maxWidth: 50
                        }
                        , 0
                    );
                    doc.text(
                        "Ticket Price : 50"
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
                            "Total Price: 50"
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
                window.open(doc.output('bloburl'))
                // doc.autoPrint()

                // const blob =  doc.output('blob');
                // const url = URL.createObjectURL(blob);
                // const iframe = document.createElement('iframe');
                // iframe.style.display = 'none';
                // iframe.src = url;
                // document.body.appendChild(iframe);
                // iframe.contentWindow.print();
                }
            }, error: function(error) {
                console.error(error);
            }
        })

    }
</script>
@endsection
