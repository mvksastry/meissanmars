<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Issue;
use App\Models\Mortality;
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
			$pi_id = iaecproject::where('iaecproject_id', $project_id)->pluck('pi_id');
			

      $nbTable = $project_id."notebook";

      $cnotes = "";

      $appearance = $this->appearance;

      $numdead  = $this->numdead;
      $moribund = $this->moribund;
      $housing  = $this->housing;
      $xyz      = $this->xyz;
      $notes    = $this->notes;
			
			if($numdead == null)
			{
				$numdead = 0;
			}
			
			if($moribund == null)
			{
				$moribund = 0;
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
			
			$total_removed = $numdead + $moribund;
			
      if($total_removed > 0)
      {
				//reduce the animal number by that many
        $cageIdInfo->animal_number = $cageIdInfo->animal_number - $total_removed;
				
				if($cageIdInfo->animal_number == 0)
				{
					//check here if the cage empty i.e. animal_number is zero after
					//removal of dead animals.
					$cageIdInfo->end_date = date('Y-m-d');
					$cageIdInfo->ack_date = date('Y-m-d');
					$cageIdInfo->cage_status = "Finished";
					$cageIdInfo->notes = "Cage removed";

					$cageIdInfo->save();
					//dd($cageIdInfo);

					//rack information also need to be put here?
					$slotInfo = Slot::where('cage_id', intval($val))->first();

					$slotInfo->cage_id = 0;
					$slotInfo->status = 'A';

					$slotInfo->save();
				}
				else {
					$cageIdInfo->save();
				}

        $cnotes = $cnotes.'[ '.$total_removed." ] sacrificed/dead/moribund removed;";

        $input['usage_id'] = $cageIdInfo->usage_id;
        $input['cage_id'] = $cageIdInfo->cage_id;
        $input['staff_id'] = Auth::user()->id;
        $input['staff_name'] = Auth::user()->name;
        $input['entry_date'] = date('Y-m-d');
        $input['protocol_id'] = 0;
        $input['expt_date'] = date('Y-m-d');
        $input['expt_description'] = "Cage observation: [ ".$total_removed." ] dead, removed";
        $input['authorized_person'] = "PI";
        $input['signature'] = "Auto Entry-Signed";
        $input['remarks'] = "none";

        $result = DB::table($nbTable)->insert($input);
				
				//also make an entry in respective formD table.
				
				
				//now make an entry in mortality table
				
				$mort = new Mortality(); 
				$mort->species_id = $cageIdInfo->species_id;
				$mort->strain_id = $cageIdInfo->strain_id;
				$mort->project_id = $project_id;
				$mort->pi_id = $pi_id;
				$mort->number_dead = $total_removed;
				$mort->colony_info = "na";
				$mort->strain_incharge_id = "na";
				$mort->cage_id = $cageIdInfo->cage_id;
				$mort->slot_index = null;
				$mort->date_death = date('Y-m-d');
				$mort->cod = "not known";
				$mort->notes = $notes;
				$mort->posted_by = Auth::user()->name;
				$mort->date_posted = date('Y-m-d');
				
				$mort->save();
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