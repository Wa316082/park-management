<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use Illuminate\Http\Request;
use App\Models\TicketSellsReport;

class TicketSellsReportController extends Controller
{
    public function ticket_sells_report()
    {
        $sells_reports = TicketSellsReport::with('ride')->orderBy('id', 'DESC')->paginate(100);
        $totalsells = TicketSellsReport::sum('ticekt_price');
        $rides=Ride::get();
        return view('reports.ticket_sells_report' ,compact('sells_reports','rides', 'totalsells'));
    }


    public function ticket_report_search(Request $request)
    {
        $rides = RIde::get();
        if($request->date_range !=null ){
            $arr_date = explode("/", $request->date_range);
            $from_date = $arr_date[0];
            $end_date = $arr_date[1];
        }
        if ($request->ticket_type != null || $request->ride_id != null || $request->date_range != null) {
            if ($request->ticket_type != null && $request->date_range != null && $request->ride_id !=null) {
                $sells_reports = TicketSellsReport::where('ticket_type' , $request->ticket_type)->where('ride_id', $request->ride_id)->whereBetween(
                    'created_at',array($from_date . ' 00:00:00', $end_date .' 23:59:59')
                )->with('ride')->paginate(100);
                $totalsells = TicketSellsReport::where('ticket_type' , $request->ticket_type)->where('ride_id', $request->ride_id)->whereBetween(
                    'created_at',array($from_date . ' 00:00:00', $end_date .' 23:59:59')
                )->sum('ticekt_price');
                $sells_reports->appends($request->all());
             }else if($request->ticket_type != null && $request->date_range != null && $request->ride_id == null){
                $sells_reports = TicketSellsReport::where('ticket_type' , $request->ticket_type)->whereBetween(
                    'created_at',array($from_date . ' 00:00:00', $end_date .' 23:59:59')
                )->with('ride')->paginate(100);
                $totalsells = TicketSellsReport::where('ticket_type' , $request->ticket_type)->whereBetween(
                    'created_at',array($from_date . ' 00:00:00', $end_date .' 23:59:59')
                )->sum('ticekt_price');
                $sells_reports->appends($request->all());
             }else if($request->ticket_type != null && $request->date_range == null && $request->ride_id != null){
                $sells_reports = TicketSellsReport::where('ticket_type' , $request->ticket_type)->where('ride_id', $request->ride_id)->with('ride')->paginate(100);
                $totalsells = TicketSellsReport::where('ticket_type' , $request->ticket_type)->where('ride_id', $request->ride_id)->sum('ticekt_price');
                $sells_reports->appends($request->all());
             }else if($request->ticket_type == null && $request->date_range != null && $request->ride_id != null){
                $sells_reports = TicketSellsReport::where('ride_id' , $request->ride_id)->whereBetween(
                    'created_at',array($from_date . ' 00:00:00', $end_date .' 23:59:59')
                )->with('ride')->paginate(100);
                $totalsells = TicketSellsReport::where('ride_id' , $request->ride_id)->whereBetween(
                    'created_at',array($from_date . ' 00:00:00', $end_date .' 23:59:59')
                )->sum('ticekt_price');
                $sells_reports->appends($request->all());
             }else if($request->ticket_type == null && $request->date_range == null && $request->ride_id != null){
                $sells_reports = TicketSellsReport::where('ride_id' , $request->ride_id)
                ->with('ride')->paginate(100);
                $totalsells = TicketSellsReport::where('ride_id' , $request->ride_id)
                ->sum('ticekt_price');
                $sells_reports->appends($request->all());
             }else if($request->ticket_type == null && $request->date_range != null && $request->ride_id == null){
                $sells_reports = TicketSellsReport::whereBetween(
                    'created_at',array($from_date . ' 00:00:00', $end_date .' 23:59:59')
                )->with('ride')->paginate(100);
                $totalsells = TicketSellsReport::whereBetween(
                    'created_at',array($from_date . ' 00:00:00', $end_date .' 23:59:59')
                )->sum('ticekt_price');
                $sells_reports->appends($request->all());
             }else if($request->ticket_type != null && $request->date_range == null && $request->ride_id == null){
                $sells_reports = TicketSellsReport::where('ticket_type' , $request->ticket_type)->with('ride')->paginate(100);
                $totalsells = TicketSellsReport::where('ticket_type' , $request->ticket_type)->sum('ticekt_price');
                $sells_reports->appends($request->all());
             }


             return view('reports.ticket_sells_report', compact('sells_reports','rides', 'totalsells'));
        } else {
            return redirect()->back()->with('info', 'Search Not Match !');

    }
}
}
