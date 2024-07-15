<?php

namespace App\Livewire\Breeding\Colony;

use Livewire\Component;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Permissions\Speciesassent;
use App\Models\User;
use App\Models\Species;

class AssignSpecies extends Component
{
		//variables
		public $activeSpecies, $allowedSpecies, $users;
		
		//form variables
		public $species_id, $handler_id, $backup_id, $start_date, $end_date, $notes;
		
		//panels
		
    public function render()
    {
			$this->activeSpecies = Species::all();
			$this->allowedSpecies = Speciesassent::with('species')
																					->with('handler')
																					->with('backup')
																					->get();
			$this->users = User::all();
			//dd($this->allowedSpecies);
				
      return view('livewire.breeding.colony.assign-species');
    }
		
		public function postPermForSpecies()
		{
			$input['species_id'] = $this->species_id;
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
			
			$permSp = new Speciesassent();
			$permSp->species_id = $input['species_id'];
			$permSp->handler_id = $input['handler_id'];
			$permSp->backup_id = $input['backup_id'];
			$permSp->start_date = $input['start_date'];
			$permSp->end_date = $input['end_date'];
			$permSp->notes = $input['notes'];
			//dd($permSp);
			$permSp->save();
			
			$this->resetForm();
		}
		
		public function resetForm()
		{
			$this->species_id = null;
			$this->handler_id = null;
			$this->backup_id = null;
			$this->start_date = null;
			$this->end_date = null;
			$this->notes = null;
		}
}
