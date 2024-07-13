<?php

namespace App\Traits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
//use App\Traits\Groupidentity;

use App\Models\Hop;
use App\Models\Path;
use App\Models\User;

trait Nexthop
{
		//
  /**
   * Check file validity and move to uploads folder
   *
   * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
   * @return boolean
   */
  public function stepId($uuid)
  {
    return (Hop::where('uuid', $uuid)->max('step_id')) + 1;
  }
		
	public function makeNewHopEntry($controller, $uuid)
	{
		$defPath = json_decode($this->defaultPath($controller), true);

		$defPath['Employee']['id'] = Auth::id();
		$defPath['Employee']['status'] = "complete";	
		$defPath['Supervisor']['id'] = $this->groupLeaderId(Auth::id());
		
		$nextStepKey = $this->defaultNextStepKey($defPath);
		
		$hopInput = new Hop();
		$hopInput->uuid = $uuid;
		$hopInput->step_id = $defPath[$nextStepKey]['step_id'];
		$hopInput->from_id = Auth::id();
		$hopInput->next_id = $defPath[$nextStepKey]['id'];
		$hopInput->path = json_encode($defPath, true);

		$resp = $hopInput->save();
		
		if($resp)
		{
			return $resp;
		}
		else {
			return false;
		}
	}
		
	public function changeHopPath($newPath, $uuid)
	{
		$nextStepKey = $this->defaultNextStepKey($newPath);
		
		$hopInput = new Hop();
		$hopInput->uuid = $uuid;
		$hopInput->step_id = $newPath[$nextStepKey]['step_id'];
		$hopInput->from_id = Auth::id();
		$hopInput->next_id = $newPath[$nextStepKey]['id'];
		$hopInput->path = json_encode($newPath, true);
		
		$resp = $hopInput->save();
		
		if($resp)
		{
			return true;
		}
		else {
			return false;
		}
	}
						
}





