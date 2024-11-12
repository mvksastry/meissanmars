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

use App;
use Illuminate\Support\Facades\Hash;

use App\Models\Iaecproject;
use App\Models\Iaecassent;
use App\Models\User;
use App\Models\Team;

//Traits
use App\Traits\Base;
use App\Traits\Groupidentity;

//uuid
use Illuminate\Support\Str;


use Validator;

use File;

class CreateUser extends Component
{
	use Base, Groupidentity;
	
	//form variables
	public $name, $email, $role, $start_date, $end_date, $agree;
	
	//render view variables
	public $own_group;
	
	//panels
	public $new_user_panel = true;
	public $edit_user_panel = false;
	
	//messages
	public $userAddMessageSuccess = null;
	
	public function render()
	{
			$this->own_group = Team::with('members')->where('leader_id', Auth::user()->id)->get();
			
			//dd(Auth::user()->id, $this->own_group);
			return view('livewire.common.users.create-user');
	}
	
	public function resetAddUserForm()
	{
		$this->name = null;
		$this->email = null;
		$this->role = null;
		$this->start_date = null;
		$this->end_date = null;
		$this->agree = null;
	}
	
	public function addNewUser()
	{
		//dd("reached");
		
		//$this->validate(['name' => 'required|alpha']);
		$input['name'] = $this->name;
    $input['role'] = $this->role;
    $input['email'] = $this->email;
		$input['start_date'] = $this->start_date;
		$input['end_date'] = $this->end_date;
		
		//$this->validate(['role' => 'required|alpha']);
		//$this->validate(['name' => 'required|regex:/^[\pL\s]+$/u|max:50']);
		//$this->validate(['email' => 'required|email']);
		//$this->validate(['start_date' => 'required|date']);
		//$this->validate(['end_date' => 'required|date|after:start_date']);
							
		Validator::make($input, [
				'name' => ['required', 'string', 'max:50'],
				'email' => ['required', 'string', 'email', 'max:55', 'unique:users'],
				'start_date' => ['required', 'date'],
				'end_date' => ['required', 'after:start_date'],
				'role' => ['required', 'string', 'max:30'],
		])->validate();
		
		$input['folder'] = $this->generateCode(15); //added by ks
  
    //$input['password'] = $this->generateCode(10);
    $input['password'] = "secret1234"; //should be loggable
    $input['uuid'] = Str::uuid()->toString();
		
		//dd($input);
		
		$newUserResult = User::create([
            'name'        => $input['name'],
            'email'       => $input['email'],
            'password'    => Hash::make($input['password']),
            'folder'      => $input['folder'],
            'role'        => $input['role'],
            'uuid'        => $input['uuid'],
            'start_date'  => $input['start_date'],
            'expiry_date' => $input['end_date'],
          ]);
		
		// now assign Role
    $newUserResult->assignRole($input['role']);
		
		//now send mail to the newly registered user using registered event
    event(new Registered($newUserResult));
		
		//add new member to group
		$groupInfo['pi_id'] = Auth::user()->id;
		$groupInfo['member_id'] = $newUserResult->id;
				
		$groupMem = Team::create([
			'leader_id' => $groupInfo['pi_id'],
			'member_id' => $groupInfo['member_id'],
		]);
		
		$this->userAddMessageSuccess = "Added New User [ ".$input['name']." ]";
		//reset user creation form.
		$this->resetAddUserForm();
		
	}
	
	public function editUser($id)
	{
		
		dd("not implemented yet");
		
	}
	
}
