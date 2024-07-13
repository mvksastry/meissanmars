<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Models\User;
use App\Models\Iaecproject;
use App\Models\Strain;
use App\Models\Species;
use App\Models\Projectstrains;
use App\Models\Usage;

use App\Traits\Base;
use App\Traits\StrainConsumption;

trait IssueRequest
{
	use Base;
	
	use StrainConsumption;
	
  public function postIssueRequest($input)
  {
    $projectInfo = Iaecproject::where('iaecproject_id', $input['project_id'])->first();
      
    $end_date = $projectInfo->end_date;

    $start_date = $projectInfo->start_date;
      
    // check whether the project expired or not.
    //if expired lock permanently.
    if($end_date >= date("Y-m-d"))
    {
      $balance = $this->fetchStrainBalance($input);

      $yearly_limit = $this->strainWiseCurrentYearLimit($input['species_id'], $input['strain_id'], $start_date, $input['project_id']);

      $strain_consumed = $this->strainConsumed($input);
        
      //make a comment if it is exceeding current year limig
      if (($strain_consumed + $input['number']) > $yearly_limit)
      {
        $remarks = "Note: Current year limit exceed for the strain";
      }
        
      $input['issue_status'] = $this->fetchStatus($input);

      //proceed only if balance is positive i.e. higher than $number
      if ($balance >= $input['number'])
      {
        $result = $this->saveIssueRequest($input);
                      
        if($result)
        {
          return true;
        }
        else {
          return false;
        }
      }
      else {
        return "Whoops! Strain Balance nil";
      }
    }
    else{
      $result = $this->postStatusExpired($input['project_id']);
      $msg = "Whoops ! Project ['".$project_id."'] expired";
      return $msg;
    }
  }
				
	public function strainConsumed($input)
	{
		$result = Usage::where('species_id', $input['species_id'])
                   ->where('strain_id', $input['strain_id'])
                   ->where('iaecproject_id', $input['project_id'])
                   ->where('issue_status', 'Approved')
                   ->sum('number');
		return $result;
	}
		
	public function fetchStrainBalance($input)
	{
    $allYearsSanctioned = Projectstrains::where('species_id', $input['species_id'])
                                                 ->where('strain_id', $input['strain_id'])
                                                 ->where('iaecproject_id', $input['project_id'])
                                                 ->sum('allyearstotal');														 
		$xcv = $this->strainConsumed($input);
    $balance = $allYearsSanctioned - $xcv;
		return $balance;
	}
		
	public function fetchStatus($input)
	{
		if ( Auth::id() == $input['pi_id'] )
    {
      $status = 'confirmed';
    }
    else {
      $status = 'submitted';
    }		
		return $status;
	}
		
	public function saveIssueRequest($input)
	{
    $issueRequest['iaecproject_id']   = $input['project_id'];
    $issueRequest['pi_id']        = $input['pi_id'];
    $issueRequest['species_id']   = $input['species_id'];
    $issueRequest['strain_id']    = $input['strain_id'];
    $issueRequest['sex']          = $input['sex'];
    $issueRequest['age']          = $input['age'];
    $issueRequest['ageunit']      = $input['ageunit'];
    $issueRequest['number']       = $input['number'];
    $issueRequest['cagenumber']   = $input['cagenumber'];
    $issueRequest['termination']  = $input['termination'];
    $issueRequest['duration']     = $input['duration'];
    $issueRequest['duration_unit']= "weeks";
    $issueRequest['expt_desc']    = $input['expt_desc'];
    $issueRequest['products']     = $input['products'];
    $issueRequest['remarks']      = $input['remarks'];
    $issueRequest['status_date']  = $input['status_date'];
    $issueRequest['issue_status'] = $input['issue_status'];
			                      										
    if($input['usage_id'] != null)
		{
			$result = Usage::where('usage_id', $input['usage_id'])->update($issueRequest);
		}
		else {
			$result = Usage::create($issueRequest);
		}
		return $result;
	}
		
	public function postStatusExpired($project_id)
	{
		$result = Iaecproject::where('iaecproject_id', $project_id)->update($sql1);
		$old = $result->comments;
		$result->status = "Expired";
		$result->comments = $old.";;; [".date('Y-m-d')."] No more issue possible.";
		$result->update();
    return true;
	}
}






