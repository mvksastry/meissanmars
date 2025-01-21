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

use App\Models\Breeding\Colony\Mating;
use Validator;

class MatingEntries extends Component
{
		public $matingEntries=[];
    public function render()
    {
			$this->matingEntries = Mating::all();
        return view('livewire.breeding.colony.mating-entries');
    }
}
