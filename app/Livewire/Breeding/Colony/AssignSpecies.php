<?php

namespace App\Livewire\Breeding\Colony;

use Livewire\Component;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Permissions\Speciesassent;



class AssignSpecies extends Component
{
		//variables
		public $allowedSpecies;
		
		//panels
		
		
    public function render()
    {
				$this->allowedSpecies = Speciesassent::with('species')
																					->with('handler')
																					->with('surrogater')
																					->get();
				//dd($this->allowedSpecies);
				
        return view('livewire.breeding.colony.assign-species');
    }
}
