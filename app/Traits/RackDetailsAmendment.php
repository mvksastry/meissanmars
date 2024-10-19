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
		$rack_id = $input['rack_id'];
		$slotsDisabled = $input['slot'];
		
		unset($input["_method"]);
		unset($input["_token"]);
		unset($input["rack_id"]);
		unset($input['slot']);
		unset($input['purpose']);
		
		$matchThese = ['rack_id' => $rack_id];
		
		$result = Rack::where($matchThese)->update($input);
		
		$total = count($slotsDisabled);
		
		foreach($slotsDisabled as $row)
		{
			$matchThese2 = ['rack_id' => $rack_id, 'slot_id'=> $row];
					
			$result2 = Slot::where($matchThese2)->update(['status'=>"R"]);
		}
		
		return true;
	}


}