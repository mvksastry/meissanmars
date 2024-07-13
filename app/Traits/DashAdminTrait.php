<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Building;
use App\Models\Floor;

use App\Models\Slot;
use App\Models\Rack;
use App\Models\Usage;
use App\Models\Room;
use App\Models\Strain;
use App\Models\Infrastructure;
use App\Models\Maintenance;
use DateTime;
use App\Models\Tempproject;
use App\Models\Iaecproject;



trait DashAdminTrait
{

  public function buldingName()
  {
    return Building::pluck('building_name')->first();
  }

  public function floorNames()
  {
    return Floor::all();
  }

  public function roomNames()
  {
    return Room::all();
  }
  
  public function totalRacksInFacility()  
  {
    return Rack::all()->count();
    
  }
  public function occupiedSlots()
  {
    return count(Slot::where('status', 'O')->get());
  }

  public function availableSlots()
  {
    return count(Slot::where('status', 'A')->get());
  }

  public function slotsAvailable() 
  {
    $qrys =  Slot::with('rack')->select('rack_id', DB::raw('count(status) as total'))
                ->where('status', 'A')->groupBy('rack_id')->get();

    if(count($qrys) > 0 )
    {
        foreach($qrys as $item)
        {
            $total = $item->total;
        } 
    }
    else {
        $total = 0;
    }
    return $total;
  }

  public function submittedProjectsForApproval()
  {
    return Tempproject::where('status', 'submitted')->get();
  }
  
  public function activeProjectsInFacility()
  {
    return Iaecproject::where('status', 'active')->get();
  }
  public function freeStrains()
  {
    return Strain::where('distributable', 'yes')->count();
  }

  public function ownerStrains()
  {
    return Strain::where('distributable', 'no')->count();
  }

  public function approvedIssues()
  {
    return Usage::with('strain')->where('issue_status', 'Approved')->count();
  }
  
  public function pendigIssues()
  {
    return Usage::where('issue_status', 'confirmed')->count();
  }

  public function cageAssignmentPending()
  {
    return Usage::where('issue_status', 'approved')->count();
  }

  public function totalInfraItems()
  {
    return Infrastructure::where('status', 'Active')->count();
  }
}
