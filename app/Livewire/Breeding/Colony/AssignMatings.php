<?php

namespace App\Livewire\Breeding\Colony;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Breeding\Colony\Mating;

class AssignMatings extends Component
{
    public function render()
    {
        return view('livewire.breeding.colony.assign-matings');
    }
}
