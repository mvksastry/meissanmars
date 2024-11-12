<?php

namespace App\Livewire\Common\Users;

use Livewire\Component;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Jantinnerezo\LivewireAlert\LivewireAlert;

//Models
//Research Projects
//use App\Models\Resproject;
//use App\Models\Resassent;

use App\Models\Iaecproject;
use App\Models\Iaecassent;

//use App\Models\Notebook;

use App\Models\User;

//Traits
use App\Traits\TCommon\AssignProject;
use App\Traits\TCommon\ProjectUsers;
use App\Traits\TCommon\ActiveUsers;
use App\Traits\TCommon\ResProjectQueries;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class OrganizeGroups extends Component
{
	// Traits
	use AssignProject;
	use ProjectUsers;
	use ActiveUsers;
	use ResProjectQueries;
	//
    use LivewireAlert;
	//
	
	// Form Variables 
	public $allUsers = [], $result, $message;
	public $panelTitle = "", $actives=[], $purpose = "";
	
	//variables
	public $users, $curUser, $activeHerds, $herdCount;
	public $user_id = [], $validity_ = [];
	public $asProj = [];	
	
	//panels
	public $showPanelGroupManage = false;
	
		
	public function render()
	{
		return view('livewire.common.users.organize-groups');
	}
	
	public function showResGroups()
	{
		$this->panelTitle = "Research Group";
		$this->purpose = "resproj";
        
		$this->actvProjs = Resproject::where('pi_id', Auth::id())->where('status', 'active')->get();
		$this->asProj = $this->projAssignments($this->actvProjs, $this->purpose);

		$this->showPanelGroupManage = true;
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Displayed all the users of research group');
	}
	
	public function showIaecGroups()
	{
		$this->panelTitle = "IAEC Group";
		$this->purpose = "iaecproj";
        
		$this->actvProjs = Iaecproject::where('pi_id', Auth::user())->where('status', 'active')->get();
		$this->asProj = $this->projAssignments($this->actvProjs, $this->purpose);
		
		$this->showPanelGroupManage = true;
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Displayed all the users of IAEC group');
		
	}
		
	public function userGroupUpdate()
	{
		$result = $this->groupUsersUpdate($this->validity_, $this->purpose);
		$this->message = "Users Accorded Project Permissins";
		
		if($this->purpose == "resproj")
		{
			$this->showResGroups();
		}
		if($this->purpose == "iaecproj")
		{	
		    $this->showIaecGroups();
		}
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updated Group Users');
	}
}
