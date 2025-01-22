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

use App\Models\Breeding\Colony\Mouse;
use App\Models\Rack;
use Validator;

class MouseEntries extends Component
{
		public $mouseEntries=[];
		
    public function render()
    {
			$this->mouseEntries = Mouse::with('strainSelected')->with('rack')->get();
			//dd($this->mouseEntries);
			return view('livewire.breeding.colony.mouse-entries');
    }
}
