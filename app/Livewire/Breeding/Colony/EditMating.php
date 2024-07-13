<?php

namespace App\Livewire\Breeding\Colony;

use Livewire\Component;

use App\Models\Breeding\Colony\Mouse;
use App\Models\Breeding\Cvterms\CVSpecies;
use App\Models\Breeding\Cvterms\Strain;
use App\Models\Breeding\Cvterms\CVGeneration;
use App\Models\Breeding\Cvterms\Lifestatus;
use App\Models\Breeding\Cvterms\Room;
use App\Models\Breeding\Cvterms\Mating;
use App\Models\Breeding\Cvterms\CVMatingtype;
use App\Models\Breeding\Cvterms\CVDiet;
use App\Models\Breeding\Cvterms\Owner;
use App\Models\Breeding\Cvterms\CVOrigin;
use App\Models\Breeding\Cvterms\Container;

//Traits
use App\Traits\Breed\BContainer;
use App\Traits\Breed\BMatingSearch;

class EditMating extends Component
{
  
    use BMatingSearch;

    public $showSearchMatingEntryForm=false, $searchResultsMating=false, $displayEditMatingForm=false;

    //message points
    public $iaMessage;

    public $species_name, $speciesName, $speciesKey, $strains, $lifestatus, $owners;
    public $matingId_contains, $matingId, $strainKey, $lifeStatus, $ownerWg, $fromDate, $toDate;
    public $matSearchResults, $purpose, $dam1Strain, $dam2Strain, $sireStrain, $dam1CageId, $dam2CageId;
    public $sireCageId, $dam1Diet, $dam2Diet, $sireDiet, $dam1Msg, $dam2Msg, $sireMsg, $diets, $matingType,
    $generations, $matQryResult, $NmatingId, $dam1Id, $dam2Id, $sireId, $matgType, $dietKey, $litGenKey,
    $genTypeNeed, $wgOwner, $matgDate, $weanTimeVal, $cagePenId, $weaNote, $coment, $dam1Name, $dam2Name,
    $sireName;

    public function render()
    {
        $this->dam1IdCheck($this->dam1Id);
        $this->dam2IdCheck($this->dam2Id);
        $this->sireIdCheck($this->sireId);

        return view('livewire.breeding.colony.edit-mating');
    }
    
    
    public function dam1IdCheck($dam1Id)
    {
        $qry = Mouse::with('strainSelected')->where('_mouse_key', $this->dam1Id)->where('sex', 'F')->first();

        if(!empty($qry))
        {
            $this->dam1Id = $qry->ID;
            //$this->dam1Key = $qry->_mouse_key;
            $qry2 = Mating::where('_dam1_key', $qry->_mouse_key)
                            ->orWhere('_dam2_key', $qry->_mouse_key)->get();
            $this->dam1Strain = $qry->strainSelected->strainName;
            $this->dam1CageId = $qry->_pen_key;
            $this->dam1Diet = $qry->diet;

            if(count($qry2) == 0 ){
                $this->dam1Msg = 'Yes; No Entries';
            }
            else {
                $this->dam1Msg = 'No; Part of other';
            }
        }
        else{
            $this->dam1Msg = "Not Found/Female";
        }
    }

    public function dam2IdCheck($dam2Id)
    {
        $qry = Mouse::with('strainSelected')->where('_mouse_key', $this->dam2Id)->where('sex', 'F')->first();

        if(!empty($qry)){
            $this->dam2Id = $qry->ID;
            //$this->dam2Key = $qry->_mouse_key;
            $qry2 = Mating::where('_dam1_key', $qry->_mouse_key)
                            ->orWhere('_dam2_key', $qry->_mouse_key)->get();
            $this->dam2Strain = $qry->strainSelected->strainName;
            $this->dam2CageId = $qry->_pen_key;
            $this->dam2Diet = $qry->diet;

            if(count($qry2) == 0 ){
                $this->dam2Msg = 'Yes; No Entries';
            }
            else {
                $this->dam2Msg = 'No; Part of other';
            }
        }
        else{
            $this->dam2Msg = "Not Found/Female";
        }
    }

    public function sireIdCheck($sireId)
    {
        $qry = Mouse::with('strainSelected')->where('_mouse_key', $this->sireId)->where('sex', 'M')->first();

        if(!empty($qry)){
            $this->sireId = $qry->ID;
            //$this->sireKey = $qry->_mouse_key;
            $qry2 = Mating::where('_sire_key', $qry->_mouse_key)->get();
            $this->sireStrain = $qry->strainSelected->strainName;
            $this->sireCageId = $qry->_pen_key;
            $this->sireDiet = $qry->diet;
            if(count($qry2) == 0 ){
                $this->sireMsg = 'Yes; No Entries';
            }
            else {
                $this->sireMsg = 'No; Part of other';
            }
        }
        else{
            $this->sireMsg = "Not Found/Male";
        }
    }

    public function show($id)
    {
        switch ($id){
            case 1:
                $this->iaMessage = "Selected Mice";
                $this->species_name = "Mice";
                $this->speciesKey = $id;
            break;
    		case 4:
                $this->iaMessage = "Selected Rat";
                $this->species_name = "Rat";
                $this->speciesKey = $id;
            break;
            default:
            $this->iaMessage = "Whoops! I couldn't get any";
        }

        $this->strains = Strain::where('_species_key', $id)->get();
        $this->lifestatus = Lifestatus::all();
        $this->owners = Owner::all();
        //finally open the view
        $this->showSearchMatingEntryForm = true;
    }

    public function pullMatingEntries(){

        $input['speciesName']       = $this->speciesName;
        $input['speciesKey']        = $this->speciesKey;
        $input['matingId_contains'] = $this->matingId_contains;
        $input['matingId']          = $this->matingId;
        $input['strainKey']         = $this->strainKey;
        $input['fromDate']          = $this->fromDate;
        $input['toDate']            = $this->toDate;
        $input['ownerWg']           = $this->ownerWg;

        $this->matSearchResults = $this->searchMatings($input);

        $this->searchResultsMating=true;
    }

    public function edit($id)
    {
        //the id you get is mating key
        $this->matQryResult = Mating::where('_mating_key', intval($id))->first();
        $_species_key = $this->matQryResult->_species_key;

        $this->strains = Strain::where('_species_key', $_species_key)->get();
        $this->generations = CVGeneration::all();
        $this->matingType = CVMatingtype::all();
        $this->diets = CVDiet::where('_species_key', $_species_key)->get();
        $this->owners = Owner::all();

        $this->speciesName = "Mice";
        $this->purpose = "Edit";
        $this->NmatingId = $this->matQryResult->matingID;

        $this->dam1Id = $this->matQryResult->_dam1_key;
        $this->dam2Id = $this->matQryResult->_dam2_key;
        $this->sireId = $this->matQryResult->_sire_key;

        $this->dietKey = $this->matQryResult->proposedDiet;
        $this->strainKey = $this->matQryResult->_strain_key;
        $this->matgType = $this->matQryResult->_matingType_key;

        $this->litGenKey = $this->matQryResult->generation;
        $this->genTypeNeed = $this->matQryResult->needsTyping;
        $this->wgOwner = $this->matQryResult->owner;

        $this->matgDate = $this->matQryResult->matingDate;
        $this->weanTimeVal = $this->matQryResult->weanTime;

        $this->cagePenId = $this->matQryResult->suggestedPenID;

        $this->weaNote = $this->matQryResult->weanNote;

        $this->coment = $this->matQryResult->comment;

        $this->showSearchMatingEntryForm = false;
        $this->searchResultsMating=false;
		$this->displayEditMatingForm = true;
    }

}
