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

use App\Traits\Base;
use App\Traits\Notes;


trait CageInspections
{
  use Base, Notes;
  
  	public function postCageInspectionReport($idcg)
  	{
      $cageIdInfo = Cage::where('cage_id', intval($idcg))->first();

      //$cnInfo = Cagenote::where('cage_id', intval($idcg))->get();

      $project_id = $cageIdInfo->iaecproject_id;

      $nbTable = $project_id."notebook";

      $cnotes = "";

      $appearance = $this->appearance;

      $numdead  = $this->numdead;
      $moribund = $this->moribund;
      $housing  = $this->housing;
      $xyz      = $this->xyz;
      $notes    = $this->notes;

      if($numdead > 0)
      {
        $cageIdInfo->animal_number = $cageIdInfo->animal_number - $numdead;

        $cageIdInfo->save();
        //reduce the animal number by that many
        $cnotes = $cnotes.'[ '.$numdead." ] dead removed;";

        $input['usage_id'] = $cageIdInfo->usage_id;
        $input['cage_id'] = $cageIdInfo->cage_id;
        $input['staff_id'] = Auth::user()->id;
        $input['staff_name'] = Auth::user()->name;
        $input['entry_date'] = date('Y-m-d');
        $input['protocol_id'] = 0;
        $input['expt_date'] = date('Y-m-d');
        $input['expt_description'] = "Cage observation: [ ".$numdead." ] dead, removed";
        $input['authorized_person'] = "PI";
        $input['signature'] = "Auto Entry-Signed";
        $input['remarks'] = "none";

        $result = DB::table($nbTable)->insert($input);
      }

      if($moribund > 0)
      {
        //reduce the animal number by that many
        //$cageIdInfo->animal_number = $cageIdInfo->animal_number - $moribund;
        $cnotes = $cnotes.'[ '.$moribund." ] moribund state removed;";
      }

      if($housing)
      {
        $cnotes = $cnotes."Cage changed with new bedding;";
      }

      if($xyz)
      {
        $cnotes = $cnotes."Xyz;";
      }

      if($notes != "")
      {
        $notes = $cnotes.$notes;
      }

      $res = Cagenote::updateOrCreate(
            ['cage_id' => intval($idcg),
            'date' => date('Y-m-d'),
            'posted_by' => Auth::user()->name,
            'notes'=>$notes]);
      
      $this->resetCageObservations();
      $this->cageInfos = false;
  	}


  	public function resetCageObservations()
  	{
      $this->numdead = "";
      $this->moribund = "";
      $this->housing = "";
      $this->xyz = "";
      $this->notes = "";
  	}
}