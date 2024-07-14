<?php

namespace App\Livewire\Breeding\Colony;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Permissions\Strainsassent;

class AssignStrain extends Component
{
		public $allowedStrains;
		
    public function render()
    {
			$this->allowedStrains = Strainsassent::with('strains')
																					->with('handler')
																					->with('backup')
																					->get();
				//dd($this->allowedStrains);
        return view('livewire.breeding.colony.assign-strain');
    }
}
