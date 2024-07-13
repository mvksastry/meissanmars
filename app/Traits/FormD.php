<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Models\User;
use App\Models\Project;

use App\Traits\Base;
use App\Traits\StrainConsumption;

trait FormD
{
	use Base;
		
	public function postFormD($input)
  {
    //make a comment if it is exceeding current year limig
					
		$input['issue_status'] = $this->fetchStatus($input);
			
		$tablename = $input['formD'];

        $result = $this->saveFormDInfo($tablename, $input);
											
		if($result)
		{
			return true;
		}
		else {
			return false;
		}
			
  }
				
	public function saveFormDInfo($tablename, $input)
	{
		$formDInfo['project_id']   = $input['project_id'];
    $formDInfo['pi_id']        = $input['pi_id'];
    $formDInfo['species_id']   = $input['species_id'];
    $formDInfo['strain_id']    = $input['strain_id'];
    $formDInfo['sex']          = $input['sex'];
    $formDInfo['age']          = $input['age'];
    $formDInfo['ageunit']      = $input['ageunit'];
    $formDInfo['remarks']      = $input['remarks'];
     
    if($input['issue_id'] != null)
		{
			$result = DB::table($tablename)->where('formd_id', $input['formd_id'])->update($formDInfo);
		}
		else {
			$result = DB::table($tablename)->create($issueRequest);
		}
		return $result;
	}
	
}






