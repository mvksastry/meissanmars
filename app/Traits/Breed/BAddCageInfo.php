<?php

namespace App\Traits\Breed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BCVTerms;

use App\Models\Slot;
use App\Models\Breeding\Bcage;
use App\Models\Cage;
use App\Models\Breeding\Colony\Mouse;

use App\Models\Breeding\Cvterms\Phenotypemouselink;
use App\Models\Breeding\Cvterms\Usescheduleterm;
use App\Models\Breeding\Cvterms\Useschedule;

use Illuminate\Support\Facades\Log;

trait BAddCageInfo
{
    use BBase;

    use BCVTerms;
		
	public function updateRackSlotCageInfo($binput)
	{
		//3. enter the cage details instead of container entries earlier. modified by ks
		//   on 16-Nov-2024.
				//$species_key         = $this->getSpeciesKeyBySpeciesName($binput['_species_key']);
				
				// gather data for cages table
				$cageInfo = new Cage();
				$cageInfo->entered_by = Auth::id();
				$cageInfo->species_id = $binput['_species_key'];
				$cageInfo->strain_id = $binput['_strain_key'];
				$cageInfo->animal_number = $binput['animal_count'];
				$cageInfo->mouse_ids = json_encode($binput['mice_ids']);
				$cageInfo->start_date = date('Y-m-d');
				$cageInfo->end_date = date('Y-m-d');
				$cageInfo->ack_date = date('Y-m-d');
				$cageInfo->cage_status = 'Active';
				$cageInfo->notes = 'Cage created ';
				$cageInfo->cage_type = $binput['cage_type'];
				$cageInfo->cage_label = $binput['cage_label'];
				//dd($cageInfo);
				$cageInfo->save();
				$cage_id = $cageInfo->cage_id;
				$msgx3 = 'New Cage [ '.$cage_id.'] creation success';
				Log::channel('coding')->info($msgx3);
				
				$rack_id = $binput['rack_id'];
				$slot_id = $binput['slot_id'];
				
				//now collect data for slots table
				$sInput['cage_id'] = $cage_id;
				$sInput['status'] = "O";
															
				$matchThese = ['slot_id' => $slot_id, 'rack_id' => $rack_id];
				$res = Slot::where($matchThese)->update($sInput);
				$msgx4 = 'Slot Table update success';
				Log::channel('coding')->info($msgx4);
				
				//Now update the mice table for cage_slot_rack id here.
				$mInput['_pen_key'] = $cage_id;
				$mInput['cage_id'] = $cage_id;
				$mInput['rack_id'] = $rack_id;
				$mInput['slot_id'] = $slot_id;
				
				foreach($binput['mice_ids'] as $val)
				{
					$matchThis = ['ID' => $val];
					$res = Mouse::where($matchThis)->update($mInput);
					$msgx4 = 'Mice location info [ '.$val.' ] update success';
					Log::channel('coding')->info($msgx4);
				}
				
				return true;
	}	
		
		
		

}