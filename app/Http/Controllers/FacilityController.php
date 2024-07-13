<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\User;
use App\Models\Project;
use App\Models\Room;
use App\Models\Rack;

use App\Traits\DashAdminTrait;


use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class FacilityController extends Controller
{
  	use HasRoles;
		use DashAdminTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rooms = count(Room::all());
        $racks = count(Rack::all());
        $occupied = $this->occupiedSlots();
        $totalAvailable = $this->availableSlots();
        $racksTotal = $this->totalRacksInFacility();
        $freeStrains = $this->freeStrains();
        $ownerStrains = $this->ownerStrains();
        $cageAssigns = $this->cageAssignmentPending();
        $totInfraItems = $this->totalInfraItems();

        return view('facility.facility.index')
            ->with('rooms', $rooms)
            ->with('racks', $racks)
            ->with('occupied', $occupied)
            ->with('totalAvailable', $totalAvailable)
            ->with('racksTotal', $racksTotal)
            ->with('freeStrains', $freeStrains)
            ->with('ownerStrains', $ownerStrains)
            ->with('totInfraItems', $totInfraItems)
            ->with('cageAssigns', $cageAssigns);
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
