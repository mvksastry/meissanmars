<?php

namespace App\Livewire\Breeding\Colony;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Permissions\Strainsassent;

class ColonyAuthorizations extends Component
{
	public $strainAuths;
	
    public function render()
    {
			$this->strainAuths = Strainsassent::with('strains')
																					->with('handler')
																					->with('backup')
																					->get();
																					
      return view('livewire.breeding.colony.colony-authorizations');
    }
}
