<?php

namespace App\Livewire\Breeding\Colony;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Permissions\Strainsassent;
use App\Models\User;
use App\Models\Strain;

class AssignStrain extends Component
{
		// page related infos
		public $allowedStrains, $curUsers, $activStrains;
		
		//messages
		public $iaMessage;
		
		// form variables
		public $strain_ids=[], $ph_id, $start_date, $end_date, $auto_ext;
		public $notes;
		
		
    public function render()
    {
			$this->curUsers = User::where('role', 'guest')->get();
			$this->activStrains = Strain::all();
			
			//$this->allowedStrains = Strainsassent::with('strains')
			//																		->with('handler')
		  //																	->with('backup')
			//																	->get();
			//dd($this->curUsers);
      return view('livewire.breeding.colony.assign-strain');
    }
		
		public function postStrainPerms()
		{
			$this->iaMessage = "Welcome, Pay attention to fields";
        
			//$input['strain_ids'] = $this->strain_ids;
			//$this->validate(['speciesName' => 'required|alpha']);
			//$input['ph_id'] = $this->ph_id;
			//$this->validate(['ph_id' => 'required|numeric']);
			//$input['start_date'] = $this->start_date;
			//$this->validate(['start_date' => 'required|date']);
			//$input['end_date'] = $this->end_date;
			//$this->validate(['end_date' => 'required|date|after:start_date']);
			//$input['notes'] = $this->notes;
			if(count($this->strain_ids) > 0)
			{
				foreach($this->strain_ids as $val)
				{
					$perm = new Strainsassent();
					$perm->strain_id = $val;
					$perm->handler_id = $this->ph_id;
					$perm->backup_id = null;
					$perm->start_date = $this->start_date;
					$perm->end_date = $this->end_date;
					$perm->status = 'active';
					$perm->notes = $this->notes;
					//dd($perm);
					$perm->save();
				}
			}
			else {
				$this->iaMessage = "Select Strains";
			}
			$this->strainsPermForm();
		}
		
		public function strainsPermForm()
		{
			$this->strain_ids = [];
			$this->ph_id = null;
			$this->start_date = null;
			$this->end_date = null;
			$this->notes = null;
		}
}
