<?php

namespace App\Traits\TCommon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\Resassent;
use App\Models\Resproject;
use App\Models\Iaecassent;
use App\Models\Iaecproject;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

trait AssignProject
{
	public function processGroupUserUpdate($input)
	{
		//separate the user id, project id and validity information
		$piId = $input['pi_id'];
		$userIds = $input['user_id'];
		$projectIds = $input['project_id'];

		//unset unwanted stuff from the array
		unset($input['_token']);
		unset($input['pi_id']);
		unset($input['user_id']);
		unset($input['project_id']);

		//safe keeping of the input
		$nbx = $input;

		//remove null values
		foreach($input as $key => $val)
		{
			if($val == null){
				unset($input[$key]);
			}
		}

		//add member to group.
		//foreach($userIds as $userId)
		//{
		//	$ia['pi_id'] = $piId;
		//	$ia['group_user_id'] = intval($userId);
		//	$res = $this->addPiGroupMember($ia);
		//}

		//next clean-up the input tags coming
		//from formd fields.

		$te1 = array();
		$te2 = array();

		foreach($input as $key => $val)
		{
			if (substr($key, 0, 3) === 'val')
			{
				$vx = str_replace("validity_", '', $key);
				$te1[$vx] = $val;
			}
			else {
				$xv = str_replace("nba_", '', $key);
				$te2[$xv] = $val;
			}
		}

		// now prepare the data for db assent.
		$te3= array();
		foreach($te2 as $key => $val)
		{
			if(in_array($key, $projectIds))
			{
				$xdf  = explode('_', $key);
				$dfx = $te2[$key];
				$nba = explode('_', $dfx);
				$fin['project_id'] = intval($xdf[1]);
				$fin['allowed_id'] = intval($xdf[0]);
				$fin['start_date'] = date('Y-m-d');
				$fin['end_date'] = $te1[$key];

				if( intval($nba[1]) === 1){
					//$fin['tablename'] = $fin['project_id'].'formd';
					$fin['tablename'] = $fin['project_id'].'notebook';
				}
				else{
					$fin['tablename'] = 'NULL';
				}
				$fin['status'] = 1;
				array_push($te3, $fin);
				$fin = array();
			}
			else
					{
				unset($te2[$key]);
			}
		}

		//the te2 is final for insertion into db.

		//dd($piId, $userIds, $projectIds, $te3);
		//first check whether the valid date is ealier than project
		//end date or not. if later ignore.

		$projInf = Project::where('pi_id', $piId)->first();

		//now loop through the $te3 and add to the db through the trait

		foreach($te3 as $input)
		{
			if( strtotime($projInf->end_date) > strtotime($input['end_date']) )
			{
				//prepare to give assent to the project.
				$res = $this->addMemberToProject($input);
			}
		}

		return true;
	}
		
	/**
     * Check file validity and move to uploads folder
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return boolean
     */
	public function addMemberToProject($input)
	{
		switch ($this->purpose) {
			case "resproj":
				//first check if he is already a member of this
				$resx = Resassent::where('resproject_id', $input['project_id'] )
										->where('allowed_id', $input['allowed_id'])
										->get();
				$newAssent = new Resassent();
				
			break;
			
			case "iaecproj":
				$resx = Iaecassent::where('iaecproject_id', $input['project_id'] )
										->where('allowed_id', $input['allowed_id'])
										->get();
				$newAssent = new Iaecassent();
			break;
		  
			default:
    
		}
		
		if($resx->count() == 0)
		{
			//no, rows, new insert query
			$newAssent->project_id = $input['project_id'];
			$newAssent->allowed_id = $input['allowed_id'];
			$newAssent->start_date = $input['start_date'];
			$newAssent->end_date   = $input['end_date'];
			$newAssent->tablename  = $input['tablename'];
			$newAssent->status     = $input['status'];
			$newAssent->save();
		}
		else {
			foreach($resx as $row)
			{
				if($input['purpose'] == "resproj")
				{
					Resassent::where('assent_id', $row->assent_id)->update($input);
					Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] group member added for Research project [ '.$input['project_id']."/".$input['allowed_id'].']');
				}
				
				if($input['purpose'] == "iaecproj" )
				{
					Iaecassent::where('assent_id', $row->assent_id)->update($input);
					Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] group member added for IAEC project [ '.$input['project_id']."/".$input['allowed_id'].']');
				}
			}
		}
		return true;
	}
}