<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Room;
use App\Models\Building;
use App\Models\Floor;

use File;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Traits\Fileupload;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

//use File;
use Validator;

//Uuid import class
use Illuminate\Support\Str;

class RoomController extends Controller
{
    use HasRoles;
    use Fileupload;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $rooms = Room::with('building')->with('floor')->get();
      //dd($rooms);
      return view('facility.rooms.index')->with(['rooms'=>$rooms]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $buildings = Building::all();
      $floors = Floor::all();
      return view('facility.rooms.create')
          ->with('buildings',$buildings)
          ->with('floors',$floors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'building_id' => 'required|regex:/(^[0-9]+$)+/|max:25',
        'floor_id' => 'required|regex:/(^[0-9]+$)+/|max:25',
        'room' =>  'required|regex:/(^[A-Za-z0-9 .,-_]+$)+/|max:25',
        'notes' => 'nullable|regex:/(^[A-Za-z0-9 .,-_]+$)+/|max:250',
        'imageFile' => 'required|image|mimes:jpeg,png,jpg|max:1048',
      ]);
        
      if( $request->hasFile('imageFile') )
      {
        $filename = $this->uploadRoomImageFile($request);

        /* Store $imageName name in DATABASE from HERE */
        $room = new Room();
        $room->uuid = Str::uuid()->toString();
        $room->building_id = $request['building_id'];
        $room->floor_id = $request['floor_id'];
        $room->room_name = $request['room'];
        $room->image_id = $filename;
        $room->notes = $request['notes'];
        $room->save();
      }  
        return redirect()->route('room.index')
        ->with('flash_message',
        'room'. $room->room_name.' added!');
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
