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
use Validator;

class ColonyReview extends Component
{
		public $mouseEntries=[];
		
    public function render()
    {
      return view('livewire.breeding.colony.colony-review');
    }
		
		public function mouseDBReview()
		{
			//dd("reached");
			return view('livewire.breeding.colony.mouse-entries');
		}

		public function matingDBReview()
		{
			return view('livewire.breeding.colony.mating-entries');
		}	
		
		public function litterDBReview()
		{
			return view('livewire.breeding.colony.litter-entries');
		}
}
