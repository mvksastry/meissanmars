<?php

namespace App\Livewire\Breeding\Colony;

use Livewire\Component;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Breeding\Cvterms\CVBirtheventstatus;
use App\Models\Breeding\Cvterms\CVDiet;
use App\Models\Breeding\Cvterms\CVLittertype;
use App\Models\Breeding\Cvterms\CVOrigin;
use App\Models\Breeding\Cvterms\CVProtocol;
use App\Models\Breeding\Cvterms\CVSpecies;

use App\Models\Breeding\Cvterms\Container;
use App\Models\Breeding\Cvterms\Lifestatus;
use App\Models\Breeding\Cvterms\Litter;
use App\Models\Breeding\Colony\Mating;
use App\Models\Breeding\Colony\Mouse;
use App\Models\Breeding\Cvterms\Owner;
use App\Models\Breeding\Cvterms\Room;
use App\Models\Breeding\Cvterms\Strain;
use App\Models\Breeding\Cvterms\Usescheduleterm;

// all traits here
use App\Traits\Breed\BContainer;
use App\Traits\Breed\BLitterSearch;
use App\Traits\Breed\BManageLitter;

use Illuminate\Support\Facades\Route;

class EditLitter extends Component
{

    use BLitterSearch, BManageLitter;

    public $iaMessage, $searchLitterEntryForm=false;

    //litter entry search form
    public $speciesName, $spKey, $strains, $strainKey, $lifestatus,
    $litterId_contains, $owners, $litterId, $matingId, $fromDate, $toDate, $ownerWg;

    public $purpose, $totalBorn, $baseMouseId, $bornDead, $protoKey, $numFemales, $numMales, $useScheduleKeys;
    public $origin, $culledAtWean, $missAtWean, $cageId, $litterNum, $femalePerCage, $malePerCage;
    public $litType, $dateBorn, $weanDate, $tagDate, $birthEventStatusKey, $coment;

    public $useScheduleTerms, $protocols, $origins, $litterTypes;
    public $birthStatuses, $matKey;

    public $litterCalculation;

    public $srchResForLitter, $litterSearchResults, $displayLitterForm;

    public $ppidb, $autoDates;


    public function render()
    {
        if($this->ppidb){ $this->doLitterCalc(); }
        if($this->autoDates){ $this->doDates(); }else { $this->weanDate="";}
        
        return view('livewire.breeding.colony.edit-litter');
    }


    public function doDates()
    {
        $dob = $this->dateBorn;
        if(strtotime($dob) == null || empty(strtotime($dob)))
        {
            $dob = date('Y-m-d');
            $this->dateBorn = $dob;
            $this->weanDate = date('Y-m-d', strtotime($dob.' + 18 days '));
            $this->tagDate = date('Y-m-d');
        }
        else{
            $this->weanDate = date('Y-m-d', strtotime($dob.' + 18 days '));
        }
    }

    public function doLitterCalc()
    {
        $qry = Litter::where('_mating_key', $this->matKey)->first();
        if(!empty($qry))
        {
            $total = $qry->totalBorn;
            $f = $qry->numFemale;
            $m = $qry->numMale;
            $bd = $qry->numberBornDead;
            $ncaw = $qry->numberCulledAtWean;
            $maw = $qry->numberMissingAtWean;

            if($total = $f+$m+$bd+$ncaw+$maw)
            {
                $this->litterCalculation = true;
            }
            else {
                $this->litterCalculation = false;
            }
        }
        else {
            $total = $this->totalBorn;
            $f = $this->numFemales;
            $m = $this->numMales;
            $bd = $this->bornDead;
            $ncaw = $this->culledAtWean;
            $maw = $this->missAtWean;

            if($total == $f+$m+$bd+$ncaw+$maw){

                $this->litterCalculation = true;
            }
            $this->litterCalculation = false;
        }
    }

    public function show($id)
    {
        switch ($id){
            case 1:
                $this->iaMessage = "Selected Mice";
                $this->speciesName = "Mice";
                $this->spKey = 1;
            break;
    		case 4:
                $this->iaMessage = "Selected Rat";
                $this->speciesName = "Rat";
                $this->spKey = 4;
            break;
            default:
            $this->iaMessage = "Whoops! I couldn't get any";
        }

        $this->strains = Strain::where('_species_key', $id)->get();
        $this->lifestatus = Lifestatus::all();
        $this->owners = Owner::all();
        //finally open the view
        $this->searchLitterEntryForm = true;
    }

    public function pullLitterEntries()
    {
        $input['speciesName']       = $this->speciesName;
        //$input['speciesKey']        = $this->spKey;
        $input['litterId_contains'] = $this->litterId_contains;
        $input['matingId']          = $this->matingId;
        $input['litterId']         = $this->litterId;
        $input['fromDate']          = $this->fromDate;
        $input['toDate']            = $this->toDate;
        $input['ownerWg']           = $this->ownerWg;

        $this->litterSearchResults = $this->searchLiiterEntries($input);

        $this->srchResForLitter=true;
    }

    public function edit($id)
    {
        $litInfo = Litter::where('litterID', $id)->first();


        $q1 = CVSpecies::where('_species_key', 1)->first();
        $this->speciesKey = $q1->_species_key;
        $this->useScheduleTerms = Usescheduleterm::all();
        $this->protocols = CVProtocol::where('_species_key', $this->speciesKey)->get();
        $this->lifestatus = Lifestatus::all();
        $this->origins = CVOrigin::all();
        $this->litterTypes = CVLittertype::all();
        $this->birthStatuses = CVBirtheventstatus::all();

        $this->purpose = "Edit";
        $this->matKey = $litInfo->_mating_key;

        $this->dateBorn = $litInfo->birthDate;
        $this->totalBorn = $litInfo->totalBorn;
        $this->bornDead = $litInfo->numberBornDead;
        $this->numFemales = $litInfo->numFemale;
        $this->numMales = $litInfo->numMale;
        $this->birthEventStatusKey = $litInfo->status;
        //$this->origin = $litInfo->origin;
        //$this->litterNum = $litInfo->litterNum;
        $this->culledAtWean = $litInfo->numberCulledAtWean;
        $this->missAtWean = $litInfo->numberMissingAtWean;
        $this->litType = $litInfo->_litterType_key;
        $this->weanDate = $litInfo->weanDate;
        $this->tagDate = $litInfo->tagDate;
        $this->coment = $litInfo->comment;

        $this->displayLitterForm=true;

    }

    public function update($id)
    {

    }


}
