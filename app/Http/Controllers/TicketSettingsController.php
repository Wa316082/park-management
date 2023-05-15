<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketSetting;

class TicketSettingsController extends Controller
{
    public function show_ticket()
    {
        return view('ticket_settings.show_ticket');
    }

    public function edit_ticket()
    {
        $ticket = TicketSetting::where('id',1)->first();
        return view('ticket_settings.edit_ticket', compact('ticket'));
    }


    public function update_ticket(Request $request)
    {
        $validated = $request->validate([
            'management_name'=>'required',
            'org_name'=>'required',
            'greetings'=>'required',
        ]);

       try {
                $ticket_info = TicketSetting::find($request->ticket_id);
                if(request()->hasFile('image')){
                    $image = $request['image'];
                    $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                    Image::make($image)->resize(400, 400)->save('upload/ticket_logo/' . $name_gen);
                    $save_url = 'upload/ticket_logo/' . $name_gen;

                    $ticket_info->image=$save_url;
                }
                $ticket_info->management_name=$request->management_name;
                $ticket_info->org_name=$request->org_name;
                $ticket_info->greetings=$request->greetings;
                $ticket_info->phone_1=$request->phone_1;
                $ticket_info->phone_2=$request->phone_2;
                $ticket_info->email_1=$request->email_1;
                $ticket_info->email_2=$request->email_2;
                $ticket_info->org_name_2=$request->org_name_2;

                $ticket_info->update();

                return redirect()->route('ticket-settings')->with('success','Ticket Edited Successfully');

       } catch (\Throwable $th) {
        return $th;
       }
    }



    public function demo_ticket()
    {
        $ticket_info = TicketSetting::where('id', 1)->first();
        return response()->json([
            'ticket_info'=> $ticket_info,
            'success'=>'Ticket Printed Successfully'
        ]);
    }
}

