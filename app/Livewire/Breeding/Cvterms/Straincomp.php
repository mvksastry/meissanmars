<?php

namespace App\Livewire\Breeding\Cvterms;

use App\Models\Breeding\Strain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Livewire\Component;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BCVTerms;

class Straincomp extends Component
{
    public $strainname, $strainstatus, $jrnum, $section, $cardcolor, $straintype, $straincomment;

    public function render()
    {
        $strains = Strain::all();
        return view('livewire.breeding.straincomp')
                ->with('strains',$strains)
                  ->extends('layouts.breeding');
    }

    public function postEntry()
    {
        # code...
        $input['strainname'] = $this->strainname;
        $input['strainstatus'] = $this->strainstatus;
        $input['jrnum'] = $this->jrnum;
        $input['section'] = $this->section;
        $input['cardcolor'] = $this->cardcolor;
        $input['straintype'] = $this->straintype;
        $input['straincomment'] = $this->straincomment;

        $newstrain = new Strain();
        $newstrain->strainName = $this->strainname;
        $newstrain->strainStatus = $this->strainstatus;
        $newstrain->jrNum = $this->jrnum;
        $newstrain->section_ = $this->section;
        $newstrain->cardColor = $this->cardcolor;
        $newstrain->strainType = $this->straintype;
        $newstrain->comment = $this->straincomment;
        $newstrain->_species_key = 1;
        $newstrain->save();
        
    }
}
