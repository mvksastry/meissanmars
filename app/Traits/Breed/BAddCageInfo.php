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
				$bcageInfo = new Bcage();
				$bcageInfo->entered_by = Auth::id();
				$bcageInfo->species_id = $binput['_species_key'];
				$bcageInfo->strain_id = $binput['_strain_key'];
				$bcageInfo->animal_number = $binput['animal_count'];
				$bcageInfo->mouse_ids = json_encode($binput['mice_ids']);
				$bcageInfo->start_date = date('Y-m-d');
				$bcageInfo->end_date = date('Y-m-d');
				$bcageInfo->ack_date = date('Y-m-d');
				$bcageInfo->cage_status = 'Active';
				$bcageInfo->notes = 'Cage created ';
				//dd($bcageInfo);
				$bcageInfo->save();
				$bcage_id = $bcageInfo->bcage_id;
				
				$rack_id = $binput['rack_id'];
				$slot_id = $binput['slot_id'];
				
				//now collect data for slots table
				$sInput['cage_id'] = $bcage_id;
				$sInput['status'] = "O";
															
				$matchThese = ['slot_id' => $slot_id, 'rack_id' => $rack_id];
				$res = Slot::where($matchThese)->update($sInput);
				
				//Now update the mice table for cage_slot_rack id here.
				$mInput['_pen_key'] = $bcage_id;
				$mInput['bcage_id'] = $bcage_id;
				$mInput['rack_id'] = $rack_id;
				$mInput['slot_id'] = $slot_id;
				
				foreach($binput['mice_ids'] as $val)
				{
					$matchThis = ['ID' => $val];
					$res = Mouse::where($matchThis)->update($mInput);
				}
				
				
				return true;
	}	
		
		
		

}