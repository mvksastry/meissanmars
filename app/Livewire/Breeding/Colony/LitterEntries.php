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

use App\Models\Breeding\Colony\Litter;
use Validator;

class LitterEntries extends Component
{
		public $litterEntries=[];
		
    public function render()
    {
				$this->litterEntries = Litter::all();
        return view('livewire.breeding.colony.litter-entries');
    }
}
