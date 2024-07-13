<?php

namespace App\Traits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Webpatser\Uuid\Uuid;

use App\Models\Committee;
use App\Models\Group;
use App\Models\Teams;
use App\Models\Panel;
use App\Models\User;
use App\Models\Teamusers;

use App\Traits\Queries;
use App\Traits\Userpermissions;

trait Groupidentity
{
	// all these are not id numbers from users table
	// these are role id in roles table. authority is by role
	public function groupLeaderId($id)
	{
    $team_id = Teamusers::where('user_id', $id)
                  ->pluck('team_id')
                  ->first();
    
    return Teamusers::where('team_id', $team_id)->Where('role', 'team_leader')
                  ->pluck('user_id')
                  ->first();
                  
    /*
		return Group::where('member_id', $id)
						->pluck('groupleader_id')
						->first();
    */
	}
	
	public function makeGroup($input)
	{
		//get array of researchers and id of the supervisor
		//take review of this delete statement. it will delete all rows of the
		//group leader. ideally because groups of supervisors are done from
		//two places one is dean who makes researchers and supervisors
		//second is admin makes supervisors and staff. so admin should only 
		//delete staff id and dean should delete only researchers ids.
		//the delete statement has to be refined for both roles.
		
		//Groupx::where('groupleader_id',$input['groupleader'])->delete();
			
			$ia['groupleader_id'] = $input['groupleader'];
			
			foreach($input['members'] as $val)
			{
					$ia['member_id'] = $val;
					Group::Create($ia);					
			}			
	} 

	public function makeCommittee($input)
	{
		if(array_key_exists('uuid', $input) > 0 )
		{
			$committee = Committee::where('uuid', $input['uuid'])->first();

			$committee_id = $committee->committee_id;
			//delete all old panel members
			$res = Panel::where('committee_id', $committee_id)->delete();
		}
		else {
			// this means new committe to be formed
			$uuid = Uuid::generate()->string;
			$committee = new Committee();
			$committee->uuid = $uuid;
		}

		$committee->title = $input['title'];
		$committee->mandate = $input['mandate'];
		$committee->start_date = $input['start_date'];
		$committee->end_date = $input['end_date'];
		$committee->frequency = 1;
		$committee->status = 1;
		
		$result = $committee->save();
	
		$result = $this->addPanelMembers($committee->committee_id, $input['panel_members']);
		
		return true;
	}	
	
	public function addPanelMembers($committee_id, $panel_members)
	{
		foreach($panel_members as $com_member_role => $val)
		{
			foreach($val as $row)
			{
				$employee_id = $row;
				$role = Role::where('name', ucfirst(str_replace("'", "", $com_member_role)))->first();
				$panel = new Panel();
				$panel->committee_id = $committee_id;
				$panel->employee_id = $employee_id;
				$panel->role_id = $role->id;
				
				$result = $panel->save();
			
				// assign role as selected
				$user = User::find($employee_id);
				$user->assignRole($role->name);
			}
		}
		return true;
	}	

	public function uniqueMemberCheck($input)
	{
		foreach($input as $val)
		{
			if(is_array($val))
			{
				foreach($val as $row)
				{
					if(is_numeric($row))
					{
						$uqCheck[] = $row;
					}
				}
			}
			else {
				if(is_numeric($val))
				{
					$uqCheck[] = $val;
				}
			}
		}
		
		if( count($uqCheck) === count(array_unique($uqCheck)) )
		{
			return true;
		}
		else {
			return false;
		}			
	}	
}