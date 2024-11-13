<?php

namespace App\Traits\TCommon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Models\User;
use App\Models\Team;
use App\Models\Resassent;
use App\Models\Iaecassent;

use App\Traits\TCommon\ResProjectQueries;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

trait ActiveUsers
{
	use ResProjectQueries;

	public function activeUsers ()
	{
		return Team::with('members')->where('leader_id', Auth::user()->id)->get();
		//return User::where('role','<>', 'supadmin')->get()->sortBy('role');
	}

	//add expiry dates to query
	public function groupMembers()
	{
		return Team::with('members')->where('leader_id', Auth::user()->id)->get();
		//return User::where('role', '<>','supadmin')->get()->sortBy('role');
	}
	
	/**
     * Check file validity and move to uploads folder
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return boolean
     */
	public function projAssignments($actvProjs, $purpose)
	{
		//first get list of group members
		$lo = array(); 
		$lm = array(); 
		$lx = array();

		$gM = $this->groupMembers();

		foreach($gM as $val)
		{
			foreach($val->members as $row)
			{
				$lo['member_id'] = $row->id;
				$lo['name'] = $row->name;
				//dd($lo);
				if(count($actvProjs) > 0) 
				{
					foreach($actvProjs as $rowx)
					{
						switch ($purpose) {
							case "resproj":
								$perm = $this->fetchResprojPermInfos($rowx->resproject_id, $val->id);
							break;
							
							case "iaecproj":
								$perm = $this->fetchIeacprojPermInfos($rowx->iaecproject_id, $row->id);
							break;
							
							default:
							$perm = null;
						}					
						//dd($perm);
						if($perm != null)
						{
							//now check whether the user has permission or not
							$lx['project_id'] = $rowx->iaecproject_id;
							$lx['title'] = "Proj-".$rowx->iaecproject_id." : ".$rowx->title;
							$lx['title'] = $this->truncateString($lx['title'], 8); 
						
							foreach($perm as $valx)
							{
								$lx['tenure_start_date'] = $valx->start_date;
								$lx['tenure_end_date'] = $valx->end_date;
								$lx['notebook'] = $valx->notebook;
								$lx['tenure_status'] = $valx->status;
							}
							$lx['allowed'] = "yes";
							array_push($lo, $lx);
							unset($lx);
							//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] permissions processed for [ '.$row->resproject_id.']');
						}
						else {
								$lx['project_id'] = $rowx->iaecproject_id;
								$lx['title'] = "Proj-".$rowx->iaecproject_id." : ".$rowx->title;
								$lx['title'] = $this->truncateString($lx['title'], 8); 
								$lx['tenure_start_date'] = null;
								$lx['tenure_end_date'] = null;
								$lx['tenure_status'] = null;
								$lx['notebook'] = null;
								$lx['allowed'] = "no";
								array_push($lo, $lx);
								unset($lx);
							//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] permissions processed for [ '.$row->resproject_id.']');
						}
					}
					array_push($lm, $lo);
					unset($lo);
				}
			}
		}
		//dd($lm);
		return $lm;
	}


	private function truncateString($phrase, $max_words) 
	{
		$phrase_array = explode(' ',$phrase);
		
		if(count($phrase_array) > $max_words && $max_words > 0)
			$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).' ...';
		return $phrase;
	}



	public function groupUsersUpdate($input, $purpose)
	{
		//dd($input, $purpose);
		//remove null values
		foreach($input as $key => $val)
		{
			if($val == null)
			{
				unset($input[$key]);
			}
		}

		// now prepare the data for db assent.
		$fin = array();
		
		foreach($input as $key => $val)
		{
			$xdf  = explode('_', $key);
			
			switch ($purpose) {
				case "resproj":
					$fin['start_date'] = date('Y-m-d');
					$fin['end_date'] = $val;
					$fin['formd'] = intval($xdf[1])."formd";
					$fin['notebook'] = intval($xdf[1])."notebook";
					$fin['status'] = "active";
					//first check if he is already a member of this									
					$matchThese = [ 'resproject_id'=> intval($xdf[1]),'allowed_id'=>intval($xdf[0]) ];
					$result = Resassent::updateOrCreate($matchThese,
														['start_date'=>$fin['start_date'], 
														'end_date'=> $fin['end_date'],
														'notebook' => $fin['notebook'],
														'status'=> $fin['status'] ]);
				break;
				
				case "iaecproj":
					$fin['start_date'] = date('Y-m-d');
					$fin['end_date'] = $val;
					$fin['formd'] = intval($xdf[1])."formd";
					$fin['notebook'] = intval($xdf[1])."notebook";
					$fin['status'] = "active";
					//first check if he is already a member of this									
					$matchThese = ['iaecproject_id'=> intval($xdf[1]),'allowed_id'=>intval($xdf[0]) ];
					$result = Iaecassent::updateOrCreate($matchThese,
														['start_date'=> $fin['start_date'], 
														'end_date'=> $fin['end_date'],
														'formd' => $fin['formd'],
														'notebook' => $fin['notebook'],
														'status'=> $fin['status'] ]);
				break;
				
				default:
				$perm = null;
			}
		}
		return true;
	}

/////////////////////////////////////////////////////////
	/**
     * Check file validity and move to uploads folder
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return boolean
     */
	public function projsGroupUsers()
	{
		//first get list of group members
		$lo = array(); 
		$lm = array(); 
		$lx = array();

		$gM = $this->groupMembers();

		foreach($gM as $val)
		{
			$lo['member_id'] = $val->id;
			$lo['name'] = $val->name;
			
			//do a query in assents table and get project info
			$herd = Resassent::with('herd')->where('allowed_id', $val->id)->get();

			if(count($herd) > 0) 
			{
				foreach($herd as $row)
				{
					$lx['title'] = "Herd-".$row->herd_id." : ".$row->herd->description;
					$lx['proj_end_date'] = $row->end_date;
					$lx['tenure_start_date'] = $row->start_date;
					$lx['tenure_end_date'] = $row->end_date;
					$lx['notebook'] = $row->notebook;
					$lx['tenure_status'] = $row->status;
					array_push($lo, $lx);
					unset($lx);
				}

				array_push($lm, $lo);
				unset($lo);
			}
		}
		//dd($lm);
		return $lm;
	}
	/**
     * Check file validity and move to uploads folder
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return boolean
     */
	public function addPiGroupMember($input)
	{
		//first check if he is already a member of this

		$qr = Group::where('pi_id', $input['pi_id'])
									->where('member_id', $input['group_user_id'])
									->count();
		if($qr == 0)
		{
			$newMember = new Group();

			$newMember->pi_id = $input['pi_id'];
			$newMember->member_id = $input['group_user_id'];
			$newMember->save();
			//now change the user status in users table to
			//$userRoleUpdate = User::find($input['group_user_id']);
			//$userRoleUpdate->role = "researcher";
			//$userRoleUpdate->save();
			return true;
		}
		else {
			//this means user is already
			// a member of the group
			return false;
		}
	}
}
