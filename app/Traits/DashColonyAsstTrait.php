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
use App\Models\Cage;
use App\Models\Infrastructure;
use App\Models\Maintenance;
use DateTime;

use App\Models\Tempproject;
use App\Models\Iaecproject;
use App\Models\Permissions\Strainsassent;


trait DashColonyAsstTrait
{

  public function strainPermsForColonyAssistants()
  {
		return Strainsassent::where('handler_id', Auth::id())->get();
  }
  
  public function racksForAssignedStrains()
	{
		$strain_ids = Strainsassent::where('handler_id', Auth::id())
																	->pluck('strain_id')
																	->toArray();
		
		$cage_ids = Cage::whereIn('strain_id', $strain_ids)->pluck('cage_id')->toArray();
		
		$rack_idx = Slot::whereIn('cage_id', $cage_ids)->pluck('rack_id')->toArray();

		$rack_ids = array_unique($rack_idx);

		return $rack_ids;
	}
}
