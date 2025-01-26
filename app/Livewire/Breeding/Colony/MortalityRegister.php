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

use App\Models\Mortality;

use Validator;

class MortalityRegister extends Component
{
		public $mortalities;
		
    public function render()
    {
				$this->mortalities = Mortality::with('species')->with('strain')->get();
        return view('livewire.breeding.colony.mortality-register');
    }
}
