<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Building;
use App\Models\Floor;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class FloorController extends Controller
{
  	use HasRoles;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $floors = Floor::with('building')->with('rooms')->get();
      //dd($floors);
      return view('facility.floors.index')->with(['floors'=>$floors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $buildings = Building::all();
      return view('facility.floors.create')
              ->with('buildings',$buildings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      //$input = $request->all();
      //dd($input);
      //Validate name and permissions field
      $this->validate($request, [
        'building' => 'required|numeric|min:1',
        'floor' => 'required|alpha_dash|max:15',
        'notes' => 'nullable|alpha_dash|max:255'
      ]);

      $floor = new Floor();
      $floor->building_id = $request['building'];
      $floor->floor_name = $request['floor'];
      $floor->notes = $request['notes'];
      //dd($floor);
      $floor->save();

      return redirect()->route('floor.index')
                        ->with('flash_message',
                        'Floor'. $floor->floor_name.' added!');
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
