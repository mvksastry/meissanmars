<?php

namespace App\Livewire\Breeding\Colony;

use Livewire\Component;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Permissions\Speciesassent;
use App\Models\Permissions\Strainsassent;
use App\Models\User;
use App\Models\Species;
use App\Models\Strain;

class AssignSpecies extends Component
{
		//variables
		public $option, $activeSpecies, $allowedSpecies, $users;
		public $activeStrains, $allowedStrains;
		//form variables
		public $species_id, $strain_id, $handler_id, $backup_id;
		public $start_date, $end_date, $notes;
		
		//panels
		
    public function render()
    {
			$this->activeSpecies = Species::all();
			$this->activeStrains = Strain::all();
			
			$this->allowedSpecies = Speciesassent::with('species')
															->with('handler')->with('backup')->get();
															
			$this->allowedStrains = Strainsassent::with('strains')
															->with('handler')->with('backup')->get();
			$this->users = User::all();
				///$this->option = $value;
      return view('livewire.breeding.colony.assign-species');
    }
		
		public function updated($property, $value)
		{
			//dd($property, $value);
			$this->option = $value;
		}
		
		public function postPermForSpecies()
		{
			$input['strain_id'] = $this->strain_id;
			//$this->validate(['species_id' => 'required|alpha']);
			$input['handler_id'] = $this->handler_id;
			//$this->validate(['handler_id' => 'required|alpha']);
			$input['backup_id'] = $this->backup_id;
			//$this->validate(['backup_id' => 'required|alpha']);
			$input['start_date'] = $this->start_date;
			//$this->validate(['start_date' => 'required|alpha']);
			$input['end_date'] = $this->end_date;
			//$this->validate(['end_date' => 'required|alpha']);
			$input['notes'] = $this->notes;
			//$this->validate(['notes' => 'required|alpha']);
			
			$permSt = new Strainsassent();
			$permSt->strain_id = $input['strain_id'];
			$permSt->handler_id = $input['handler_id'];
			$permSt->backup_id = $input['backup_id'];
			$permSt->start_date = $input['start_date'];
			$permSt->end_date = $input['end_date'];
			$permSt->status = $input['notes'];
			//dd($permSt);
			$permSt->save();
			
			$this->resetForm();
		}
		
		public function resetForm()
		{
			$this->strain_id = null;
			$this->handler_id = null;
			$this->backup_id = null;
			$this->start_date = null;
			$this->end_date = null;
			$this->notes = null;
		}
}
