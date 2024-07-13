<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;


use App\Models\Building;
use App\Models\Rack;
use App\Models\Room;
use App\Models\Slot;

use File;
use App\Traits\SlotCreation;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class RackController extends Controller
{
  use HasRoles, SlotCreation;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $rackInfo = Rack::with('room')->with('slots')->get();
        
        foreach($rackInfo as $rack)
        {
          $occupied = 0;
          $vacant = 0;
          
          $slots = $rack->slots;
            foreach($slots as $row)
            {
              if($row->status == 'O')
              {
                $occupied = $occupied + 1; 
              }else {
                $vacant = $vacant + 1;
              }
            }
            $rack->occupied = $occupied;
            $rack->vacant = $vacant;
        }
        //dd($rackInfo);
      return view('facility.racks.index')
              ->with('rackInfo', $rackInfo);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $rooms = Room::all();
      return view('facility.racks.create')
          ->with('rooms',$rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      //Validate name and permissions field
      $this->validate($request, [
        'room_id'   => 'required|numeric|min:1',
        'rack_name' => 'required|alpha_dash|max:15',
        'rows'      => 'required|numeric|max:2',
        'cols'      => 'required|numeric|max:10',
        'levels'    => 'required|numeric|max:4',
        'notes'     => 'nullable|regex:/(^[A-Za-z0-9 -_]+$)+/|max:250'
      ]);

      $result = $this->inductNewRack($request);
      
      /*
      $rack = new Rack();
      $rack->building_id = 1;
      $rack->floor_id = 1;
      $rack->room_id = $request['room_id'];
      $rack->rack_name = $request['rack_name'];
      $rack->rows = $request['rows'];
      $rack->cols = $request['cols'];
      $rack->levels = $request['levels'];
      $rack->notes = $request['notes'];
      $rack->save();

      $rack_id = $rack->rack_id;

      $capacity = $rack->rows*$rack->cols*$rack->levels;

      for($i = 1; $i< $capacity+1; $i++)
      {
        $slot = new Slot();
        $slot->slot_id = $i;  //added on 2-Jan-2022 after change in db
        $slot->rack_id = $rack_id;
        $slot->cage_id = 0;
        $slot->status = 'A';
        $slot->save();
      }
      */
      
      return redirect()->route('racks.index')
          ->with('flash_message',
           'rack'. $rack->rack_name.' added!');
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
        $rooms = Room::all();
        $rack = Rack::findOrFail($id);
        
        return view('facility.racks.edit')
          ->with('rooms',$rooms)
          ->with('rack', $rack);
     
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $purpose = $request['purpose'];
        
        $result = $this->editRackInformation($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
