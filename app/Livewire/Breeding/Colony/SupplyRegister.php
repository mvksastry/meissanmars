<?php

namespace App\Livewire\Breeding\Colony;

use Livewire\Component;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Support\Facades\Route;

use App\Models\B2p;
use App\Models\Species;
use Validator;

class SupplyRegister extends Component
{
		public $supplyRegister = [];
	
    public function render()
    {
				$this->supplyRegister = B2p::with('species')->with('strain')->with('movedby')->get();
				//dd($this->supplyRegister);
        return view('livewire.breeding.colony.supply-register');
    }
}
