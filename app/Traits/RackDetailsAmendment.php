<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Slot;
use App\Models\Rack;

use App\Traits\Base;
use App\Traits\Notes;


trait RackDetailsAmendment
{
  use Base, Notes;
  
	public function amendRackInformation($input)
	{
		//frst collect info and decide whether any cages are present
		// in the rack, only convert all checked slots to "reserved"
		//"R" status.
		$slotsDisabled = [];
		$slotsReEnabled = [];
		
		unset($input["_method"]);
		unset($input["_token"]);		
		
		$rack_id = $input['rack_id'];
		unset($input["rack_id"]);
		
		if(array_key_exists("slot", $input))
		{
			$slotsDisabled = $input['slot'];
			unset($input['slot']);
			foreach($slotsDisabled as $row)
			{
				$matchThese2 = ['rack_id' => $rack_id, 'slot_id'=> $row];
				$result2 = Slot::where($matchThese2)->update(['status'=>"R"]);
			}
		}
		
		if(array_key_exists("slotR", $input))
		{		
			$slotsReEnabled = $input['slotR'];
			unset($input['slotR']);
			foreach($slotsReEnabled as $row)
			{
				$matchThese2 = ['rack_id' => $rack_id, 'slot_id'=> $row];
				$result3 = Slot::where($matchThese2)->update(['status'=>"A"]);
			}	
		}

		unset($input['purpose']);
		
		$matchThese = ['rack_id' => $rack_id];
		
		$result = Rack::where($matchThese)->update($input);
		
		//$total = count($slotsDisabled);
		
		/*
		if(count($slotsDisabled) > 0 )
		{
			foreach($slotsDisabled as $row)
			{
				$matchThese2 = ['rack_id' => $rack_id, 'slot_id'=> $row];
				$result2 = Slot::where($matchThese2)->update(['status'=>"R"]);
			}
		}

		if(count($slotsDisabled) > 0 )
		{		
			foreach($slotsReEnabled as $row)
			{
				$matchThese2 = ['rack_id' => $rack_id, 'slot_id'=> $row];
				$result3 = Slot::where($matchThese2)->update(['status'=>"A"]);
			}		
		}
		*/
		return true;
	}


}