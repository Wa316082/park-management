<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class RideController extends Controller
{
    public function ride_list()
    {
        $rides = Ride::get();
        return view('rides.ride_list', compact('rides'));
    }


    //ride create
    public function ride_create()
    {
        return view('rides.ride_create');
    }


    //ride store
    public function ride_store(Request $request)
    {
        $validated = $request->validate([
            'ride_title'=>'required|unique:rides,title',
            'description'=>'required',
        ]);

        $config = [
            'table' => 'rides',
            'field' => 'ride_code',
            'length' => 13,
            'reset_on_prefix_change' => true,
            'prefix' => 'RIDE'
        ];

        $ride_code = IdGenerator::generate($config);
        try {
            $ride = new Ride;
            $ride->title=$request->ride_title;
            $ride->description=$request->description;
            $ride->ride_code=$ride_code;
            $ride->save();
            return redirect()->route('ride-list')->with('success','Ride Added Successfully !');
        } catch (Throwable $th) {
            return $th;
        }
    }


    // edit ride
    public function ride_edit($id)
    {

        $ride = Ride::find($id);
        return view('rides.ride_edit', compact('ride'));
    }


    public function ride_update(Request $request)
    {
        $validated = $request->validate([
            // 'ride_title'=>'required|unique:rides,title',
            'description'=>'required',
        ]);

        try {
            $ride = Ride::find('id', $request->ride_id);
            $ride->title=$request->ride_title;
            $ride->description=$request->description;
            $ride->update();
            return redirect()->route('ride-list')->with('success','Ride Added Successfully !');
        } catch (Throwable $th) {
            return $th;
        }
    }


    public function ride_delete($id)
    {
        $ride = Ride::find($id);
        $ride->delete();

        return redirect()->route('ride-list')->with('success','Ride deleted Successfully !');
    }
}
