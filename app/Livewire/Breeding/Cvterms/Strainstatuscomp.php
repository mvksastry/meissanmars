<?php

namespace App\Livewire\Breeding\Cvterms;

use App\Models\Breeding\CVStrainstatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Livewire\Component;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BCVTerms;


class Strainstatuscomp extends Component
{

    public $strainstatus, $strainstatusdescription;

    public function render()
    {

        $strainstatuses = CVStrainstatus::all();

        return view('livewire.breeding.strainstatuscomp')
                ->with('strainstatuses',$strainstatuses)
                ->extends('layouts.breeding');
    }

    public function postEntry()
    {
        # code...
        $input['strainstatus'] = $this->strainstatus;
        $input['strainstatusdescription'] = $this->strainstatusdescription;
        
        $newstrainstatus = new CVStrainstatus;
        $newstrainstatus->strainStatus = $this->strainstatus;
        $newstrainstatus->description = $this->strainstatusdescription;
        $newstrainstatus->save();
    }   
}
