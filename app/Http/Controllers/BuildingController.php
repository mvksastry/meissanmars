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

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class BuildingController extends Controller
{
  	use HasRoles;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $buildings = Building::all();
      return view('facility.building.index')
      ->with('buildings', $buildings);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
      return view('facility.building.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      //Validate name and permissions field
        $this->validate($request, [
          'name' => 'required|alpha_dash|max:15',
          'notes' => 'nullable|alpha_dash|max:15'
       ]);

      $building = new Building();
      $building->building_name = $request['name'];
      $building->notes = $request['notes'];
      $building->save();

      return redirect()->route('roomsnracks.index')
            ->with('flash_message',
             'building'. $building->name.' added!');
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
