<?php

namespace App\Traits;

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

trait CageInfoUpdate
{
	public function updateAnimalNumber($mice_id, $cage_id, $slot_id, $rack_id)
	{
		$cageObj = Cage::where('cage_id', $cage_id)->first();
		$cageObj->animal_number = $cageObj->animal_number - 1;
		$this->removeIDFromCage($mice_id, $cage_id);
		if($cageObj->animal_number == 0)
		{
			$this->updateCageClosure($cage_id, $slot_id, $rack_id, $cageObj);
		}
		//dd($cageObj);
		$cageObj->save();
		return true;
	}

	public function updateCageClosure($cage_id, $slot_id, $rack_id, $cageObj)
	{
		$cageObj->end_date = date('Y-m-d');
		$cageObj->ack_date = date('Y-m-d');
		$cageObj->cage_status = "Finished";
		$cageObj->notes = "Cage closed";
		//now free up the slot from the rack.
		$cInput['cage_id'] = 0; // default value
		$cInput['status'] = "A"; //available for use
		$matchThese = ['slot_id' => $slot_id, 'rack_id' => $rack_id];
		$res = Slot::where($matchThese)->update($cInput);
		return $cageObj;
	}

	public function removeIDFromCage($mice_id, $cage_id)
	{
		$cageRes = Cage::where('cage_id', $cage_id)->first();
		$cageMiceIDs = json_decode($cageRes->mouse_ids);
		if (($key = array_search($mice_id, $cageMiceIDs)) !== false) 
		{
			unset($cageMiceIDs[$key]);
			$cageMiceIDsMice = json_encode($cageMiceIDs);
			$cageRes->mouse_ids = $cageMiceIDsMice;
			$cageRes->save();
		}
	}
}