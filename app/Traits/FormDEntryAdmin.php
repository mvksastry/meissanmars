<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\Issue;
use App\Models\Iaecproject;
use App\Models\Projectstrains;
use App\Models\Usage;

use App\Traits\Base;
use App\Traits\Notes;

trait FormDEntryAdmin
{
	public function enterFormD($issueRequest)
	{
		foreach($issueRequest as $row)
		{
			$iaecproject_id = $issueRequest->iaecproject_id;
			$formD['usage_id'] = $issueRequest->usage_id;
      $formD['staff_id'] = $issueRequest->pi_id;
			
			$formD['entry_date'] = date('Y-m-d');
			$formD['req_anim_number'] = $issueRequest->number;
			$formD['species'] = $issueRequest->species->species_id;
			$formD['strain'] = $issueRequest->strain->strain_id;
			$formD['sex'] = $issueRequest->sex;
			$formD['age'] = $issueRequest->age;
			$formD['ageunit'] = $issueRequest->ageunit;
			$formD['breeder_add'] = "EAF, NCCS, Pune-411007";
			$formD['approval_date'] = date('Y-m-d');
			$formD['expt_start_date'] = date('Y-m-d');
      $formD['expt_desc'] = $issueRequest->expt_desc;
      $formD['expt_end_date'] = $this->addWeeksToDate($issueRequest->duration);
      //dates and description
      			
			$formD['remarks'] = $issueRequest->remarks;
			$res = Iaecproject::with('user')->where('iaecproject_id',$iaecproject_id)->first();
			foreach($res as $x)
			{
        $tableFormD = $res->formD;
				$formD['staff_name'] = $res->user->name;
				$formD['authorized_person'] = "[ Auto Entry For ] ".$res->user->name;
				$formD['authorized_signature'] = $res->user->name;
			}
			//$tableFormD = $row->project_id."nformd";
      //dd($tableFormD, $formD);
			$qry = DB::table($tableFormD)->insert($formD);

			if( $qry)
			{
	      return true;
			}
			else {
	      return false;
			}
		}
	}
}
