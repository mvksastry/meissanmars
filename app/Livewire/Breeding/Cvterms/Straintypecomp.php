<?php

namespace App\Livewire\Breeding\Cvterms;

use App\Models\Breeding\CVStraintype;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Livewire\Component;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BCVTerms;


class Straintypecomp extends Component
{

    public $straintype;
    public function render()
    {
        $straintypes = CVStraintype::all();

        return view('livewire.breeding.straintypecomp')
                ->with('straintypes',$straintypes)
                  ->extends('layouts.breeding');
    }

    public function postEntry()
    {
        # code...
        $input['straintype'] = $this->straintype;

        //dd($input);
        
        $newstraintype = new CVStraintype();
        $newstraintype->strainType = $this->straintype;
        $newstraintype->version = 1;
        //dd($newstraintype);
        $newstraintype->save();
    }
}
