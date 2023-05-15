<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketSetting;
use App\Models\TicketSellsReport;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class TicketController extends Controller
{
    //ticket list
    public function ticket_list()
    {
        $tickets = Ticket::get();
        return view('tickets.ticket_list', compact('tickets'));
    }


    //ticket create
    public function ticket_create()
    {
        $rides = Ride::get();
        return view('tickets.ticket_create', compact('rides'));
    }


    //ticket store
    public function ticket_store(Request $request)
    {
        $validated = $request->validate([
            'title'=>'required|unique:tickets,title',
            'ticket_type'=>'required',
            // 'ride_id'=>'required',
            'description'=>'required',
            'ticket_price'=>'required',
        ]);

        $config = [
            'table' => 'tickets',
            'field' => 'ticket_code',
            'length' => 13,
            'reset_on_prefix_change' => true,
            'prefix' => 'AM'
        ];

        $ticket_code = IdGenerator::generate($config);

        try {
            $ticket = new Ticket;
            $ticket->title=$request->title;
            $ticket->ticket_type=$request->ticket_type;
            $ticket->ride_id=$request->ride;
            $ticket->description=$request->description;
            $ticket->ticket_code=$ticket_code;
            $ticket->price=floatval($request->ticket_price);
            $ticket->save();
            return redirect()->route('ticket-list')->with('success','Ticket Added Successfully !');
        } catch (Throwable $th) {
            return $th;
        }
    }


    //ticket sell
    public function ticket_sell()
    {
        $tickets = Ticket::get();
        return view('tickets.tickets_sell', compact('tickets'));
    }


    //ticket print
    public function ticket_print(Request $request)
    {
        try {
            $ticket_code = $request->get('ticketCode');
            $ticket = Ticket::where('ticket_code', $ticket_code)->first();
            $ticket_info = TicketSetting::where('id', 1)->first();
            $config = [
                'table' => 'ticket_sells_reports',
                'field' => 'ticket_serial_number',
                'length' => 13,
                'prefix'=>date('y')
            ];
            $sr_no =IdGenerator::generate($config);
            $this->sell_report($ticket ,$sr_no);
            return response()->json([
                'ticket_info'=> $ticket_info,
                'ticket' => $ticket,
                "sr_no" =>$sr_no,
                'success'=>'Ticket Printed Successfully'
            ]);
        } catch (\Throwable $th) {
            return $th;
        }

    }

    // ticket report store
    public function sell_report($ticket , $sr_no)
    {
        try {
            $ticket_report = new TicketSellsReport;
            $ticket_report->ticket_id=$ticket->id;
            $ticket_report->ticket_title=$ticket->title;
            $ticket_report->ticket_type=$ticket->ticket_type;
            $ticket_report->ticket_serial_number=$sr_no;
            $ticket_report->ticekt_price=$ticket->price;
            if ($ticket->ride_id != null) {
                $ticket_report->ride_id=$ticket->ride_id;
            }else{
                $ticket_report->ride_id=null;
            }
            $ticket_report->save();
        } catch (\Throwable $th) {
           return $th;
        }
    }


    //barcode generation

    public function barcode_print(Request $request)
    {
        $ticket= Ticket::find($request->id);
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($ticket->ticket_code, $generator::TYPE_CODE_128);
        $barcodeUrl = 'data:image/png;base64,' . base64_encode($barcode);

        return response()->json([
            'ticket'=>$ticket,
            'barcodeURL'=> $barcodeUrl
        ]);

    }

    // ticket edit
    public function ticket_edit($id)
    {
        $rides= Ride::get();
        $ticket = Ticket::find($id);


        return view('tickets.ticket_edit', compact('ticket', 'rides'));
    }

    // ticket Update

    public function ticket_update(Request $request)
    {

        $validated = $request->validate([
            'ticket_type'=>'required',
            'description'=>'required',
            'ticket_price'=>'required',
        ]);

        try {
            $ticket = Ticket::where('id',$request->ticket_id)->first();
            $ticket->title=$request->title;
            $ticket->ticket_type=$request->ticket_type;
            $ticket->ride_id=$request->ride;
            $ticket->description=$request->description;
            $ticket->price=floatval($request->ticket_price);
            $ticket->update();
            return redirect()->route('ticket-list')->with('success','Ticket Added Successfully !');
        } catch (Throwable $th) {
            return $th;
        }
    }



    // ticket delete
    public function ticket_delete($id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();
        return redirect()->route('ticket-list');
    }


}
