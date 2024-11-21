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
use App\Traits\RackDetailsAmendment;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class RackController extends Controller
{
  use HasRoles, SlotCreation, RackDetailsAmendment;
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
          $blocked = 0;
					
          $slots = $rack->slots;
					
					foreach($slots as $row)
					{
						if($row->status == 'O')
						{
							$occupied = $occupied + 1; 
						}
						if($row->status == 'R')
						{
							$blocked = $blocked + 1;
						}
							$vacant = count($slots)-$occupied - $blocked;
					}
            $rack->occupied = $occupied;
            $rack->blocked = $blocked;
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
			/*
      $this->validate($request, [
        'room_id'   => 'required|numeric|min:1',
        'rack_name' => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/|max:50',
        'rows'      => 'required|numeric|max:2',
        'cols'      => 'required|numeric|max:10',
        'levels'    => 'required|numeric|max:8',
        'notes'     => 'nullable|regex:/(^[A-Za-z0-9 -_]+$)+/|max:250'
      ]);
			*/
			
      $result = $this->inductNewRack($request);
            
      return redirect()->route('rack.index')
          ->with('flash_message',
           'rack'. $result.' added!');
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
				$rStatus = Slot::whereStatus('O')->get();
				$rStat = Slot::where('rack_id', $id)->get();
				//dd($rStatus, $rmsg);
				if(count($rStatus) > 0)
				{
					$edit = true;
					$msg = "Rack Not Empty: Rows, Columns, Shelfs can not be edited";
					
				}
				else {
					$edit = false;
					$msg = "Rack Empty: Rows, Columns, Shelfs can be edited";
				}
        return view('facility.racks.edit')
          ->with('rooms',$rooms)
          ->with('rack', $rack)
					->with('rStat', $rStat)
					->with('msg',$msg)
					->with('edit', $edit);
     
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $purpose = $request['purpose'];
				
        $input = $request->all();
				
				$input['rack_id'] = intval($id);
	
	//dd($input);
        $result = $this->amendRackInformation($input);
				
				return redirect()->route('rack.index')
          ->with('flash_message', 'rack'. $result.' added!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
