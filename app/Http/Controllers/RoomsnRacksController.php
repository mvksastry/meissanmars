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
use App\Models\Floor;
use App\Models\Room;
use App\Models\Rack;
use App\Models\Slot;

use App\Traits\DashAdminTrait;
use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class RoomsnRacksController extends Controller
{
  	use HasRoles;
    use DashAdminTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $buildings = Building::all();
        $floors = Floor::with('building')->get();
        $rooms = Room::with('building')->with('floor')->with('rack')->get();
        $racks = Rack::with('room')->get();
        $vacant = count(Slot::where('status', 'A')->get());
        $occupied = count(Slot::where('status', 'O')->get());
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
        
        
        
        return view('facility.roomsnracks.index')
                  ->with('buildings', $buildings)
                  ->with('floors', $floors)
                  ->with('rooms', $rooms)
                  ->with('racks', $racks)
                  ->with('vacant', $vacant)
                  ->with('occupied', $occupied)
                  ->with('rackInfo', $rackInfo);
    }
    
    public function newBuilding()
    {
      return view('roomsnracks.newbuildingForm');
    }

    public function newFloor()
    {
      return view('roomsnracks.newFloorForm');
    }

    public function newRoom()
    {
      return view('roomsnracks.newRoomForm');
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
