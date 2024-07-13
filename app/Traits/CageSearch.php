<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Issue;
use App\Models\Slot;
use App\Models\Cage;
use App\Models\Cagenote;
use App\Models\Rack;
use App\Models\Project;
use App\Traits\Base;
use App\Traits\Notes;


trait CageSearch
{
	use Base;

	use Notes;

	public function showPiCageDetails()
	{
    $tables = $this->setDB();
    $investigatorId =  Auth::id();
    $cageInfo = $tables->table('cages')
                          ->leftJoin('slots', 'slots.cage_id', '=', 'cages.cage_id')
                          ->leftJoin('projects', 'projects.project_id', '=', 'cages.project_id')
                          ->where('projects.pi_id', Auth::id())
                          ->where('cages.status', '=', 'Active')
                          ->where('slots.status', '=', 'O')
                          ->get();
    return $cageInfo;
  }

	public function getAllCagesMatchingIssueId($issue_id)
	{
		$cageInfo = Cage::with('slots')-> where('issue_id', $issue_id)->get();

	}

	public function showCageDetailsByCageId($cage_id)
  {
    $tables = $this->setDB();

    $cageInfo = $tables->table('cages')
                        ->leftJoin('slots', 'slots.cage_id', '=', 'cages.cage_id')
                        ->leftJoin('occupancies', 'occupancies.rack_id', '=', 'slots.rack_id')
                        ->where('cages.cage_id', $cage_id)
                        //->where('cagedetails.cage_status', '=', 'Active')
                        //->where('slotdetails.status', '=', 'O')
                        ->get();

    return $cageInfo;

  }

	public function showPiCageDetailsById($pi_id)
  {
    $tables = $this->setDB();

    $cageInfo = $tables->table('cages')
                        ->leftJoin('slots', 'slots.cage_id', '=', 'cages.cage_id')
                        ->leftJoin('projects', 'projects.project_id', '=', 'cages.project_id')
                        ->leftJoin('projpermissions', 'projpermissions.project_id', '=', 'cagedetails.project_id')
                        ->leftJoin('occupancies', 'occupancies.rack_id', '=', 'slots.rack_id')
                        ->where('projpermissions.allowed_id', $pi_id)
                        ->where('cages.status', '=', 'Active')
                        ->where('slots.status', '=', 'O')
                        ->get();

    return $cageInfo;

  }
		
  public function showCageInfoByCageId($cage_id)
  {
    return Cage::where('cage_id', $cage_id)->get();

  }

}
