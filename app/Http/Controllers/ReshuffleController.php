<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Support\Facades\Route;
use App\Models\Room;
use App\Models\Rack;
use App\Models\Cage;
use App\Models\Slot;

use App\Traits\CageReshuffle;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class ReshuffleController extends Controller
{
  use HasRoles;

	use CageReshuffle;


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all();
        return view('reshuffle.reshuffleHome')
        						->with(['rooms'=>$rooms]);
    }

    public function fetchRacks(Request $request)
    {

      $id = $request['room'];
      $room = Room::where('image_id', $id)->first();
      $racks = Rack::where('room_id', $room->room_id)->get();
      // now retrive the racks in that room
      return view("reshuffle.rackUpdate")->with('racks',$racks);
    }

    public function fetchCages(Request $request)
    {

      $rack_info = array();
      $rackName = $request['rackName'];
      $racks = Rack::where('rack_name', $rackName)->first();
      $cageIds = Slot::where('rack_id', $racks->rack_id)->get();

      foreach($cageIds as $val)
      {
        $info['slot_id'] = $val->slot_id;
              $info['cage_id'] = $val->cage_id;
              $info['status'] = $val->status;
        array_push($rack_info, $info);
        $info = array();
      }
      // now retrive the racks in that room

      return view("reshuffle.cageShuffle")
              ->with('rack_info', $rack_info)
              ->with('racks', $racks);

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cageUpdate(Request $request)
    {
        $data_string = $request['dataString'];
        $data_string = str_replace("border py-2 border-gray-200", "", $data_string);
        $msg = $this->postCageReshuffleData($data_string);
        echo $msg;
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
