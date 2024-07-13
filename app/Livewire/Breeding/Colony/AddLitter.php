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
use App\Models\Breeding\Cvterms\Owner;
use App\Models\Breeding\Cvterms\Strain;
use App\Models\Breeding\Cvterms\Usescheduleterm;

use App\Models\Breeding\Colony\Litter;
use App\Models\Breeding\Colony\Mating;
use App\Models\Breeding\Colony\Mouse;

use App\Models\Room;

// all traits here
use App\Traits\Breed\BContainer;
use App\Traits\Breed\BMatingSearch;
use App\Traits\Breed\BManageLitter;

use Illuminate\Support\Facades\Route;

class AddLitter extends Component
{
  use BMatingSearch, BManageLitter;

  public $iaMessage;

  public $showLitterEntryForm=false, $showSearchMatingEntryForm, $litterCalculation;

  //compulsory information
  public $speciesName, $speciesKey, $purpose, $matKey;

  //Model objects
  public $useScheduleTerms, $protocols, $lifestatus, $litterTypes, $strains, $origins, $owners, $birthStatuses;

  //check boxes
  public $ppidb = false, $agmr = true, $autoDates=true, $femaleFirst = true, $lpimc = false;

  // form variables
  public $totalBorn, $baseMouseId, $bornDead, $protoKey, $numFemales, $numMales, $useScheduleKeys;
  public $origin, $culledAtWean, $missAtWean, $cageId, $litterNum, $femalePerCage, $malePerCage;
  public $litType, $dateBorn, $weanDate, $tagDate, $birthEventStatusKey, $coment;

  public $matingId_contains, $matingId, $strainKey, $spKey, $lifeStatus, $ownerWg, $fromDate, $toDate;
  public $matSearchResults, $searchResultsMating, $mqryResult;
  
  public $roomId, $rackId;
    
  public function render()
  {
    if($this->ppidb)
    { 
      $this->doLitterCalc(); 
    }

    if($this->autoDates)
    { 
      $this->doDates(); 
    } else { 
      $this->weanDate="";
    }
    return view('livewire.breeding.colony.add-litter');
  }
    
  public function doDates()
  {
    $dob = $this->dateBorn;
    if(strtotime($dob) == null || empty(strtotime($dob)))
    {
        $dob = date('Y-m-d');
        $this->dateBorn = $dob;
        $this->weanDate = date('Y-m-d', strtotime($dob.' + 21 days '));
        $this->tagDate = date('Y-m-d');
    }
    else{
        $this->weanDate = date('Y-m-d', strtotime($dob.' + 21 days '));
    }
  }

  public function doLitterCalc(){
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

  public function searchMates($speciesName)
  {
    if($speciesName == "Mice") { $this->spKey = 1; }
    if($speciesName == "Rat") { $this->spKey = 4; }

    $this->strains = Strain::where('_species_key', $this->spKey)->get();
    $this->lifestatus = Lifestatus::all();
    $this->owners = Owner::all();

    $this->showSearchMatingEntryForm = true;
  }

  public function pullMatingEntries(){

    $input['speciesName']       = $this->speciesName;
    $input['speciesKey']        = $this->spKey;
    $input['matingId_contains'] = $this->matingId_contains;
    $input['matingId']          = $this->matingId;
    $input['strainKey']         = $this->strainKey;
    $input['fromDate']          = $this->fromDate;
    $input['toDate']            = $this->toDate;
    $input['ownerWg']           = $this->ownerWg;

    $this->matSearchResults = $this->searchMatings($input);

    $this->searchResultsMating=true;
  }

  public function pick($id)
  {
    $qry = Mating::where('_mating_key', $id)->first();

    $this->mqryResult = $qry;
    $this->matKey = $id;

    $this->showSearchMatingEntryForm = false;
    $this->searchResultsMating = false;
  }

  public function show($id)
	{
		if($id == 1) { $this->speciesName = "Mice"; $this->iaMessage = "Selected Mice"; }
		if($id == 4) { $this->speciesName = "Rat"; $this->iaMessage = "Selected Rat"; }

    $this->purpose = "New";
		$q1 = CVSpecies::where('_species_key', $id)->first();
		$this->speciesKey = $q1->_species_key;
		$this->useScheduleTerms = Usescheduleterm::all();
		$this->protocols = CVProtocol::where('_species_key', $id)->get();
		$this->lifestatus = Lifestatus::all();
		//$this->rooms = Room::all();
		//$this->diets = CVDiet::where('_species_key', $id)->get();
		$this->origins = CVOrigin::all();
    $this->litterTypes = CVLittertype::all();
    $this->birthStatuses = CVBirtheventstatus::all();
		//$this->containerId = Container::max('containerID');
		$this->cageInfos = $this->suggestedCage();
		$this->showLitterEntryForm = true;
	}

  public function suggestedCage()
	{
		$maxContainerID = Container::max('containerID');
		$cage_id = $maxContainerID + 1;
		$this->cageCreateFlag = true;
		return $cage_id;
	}

  public function enterLitter()
  {
    $input['purpose'] = "New";
    $input['matKey'] = $this->matKey;
    $input['dateBorn'] = $this->dateBorn;
    $input['totalBorn'] = $this->totalBorn;
    $input['bornDead'] = $this->bornDead;
    $input['numFemales'] = $this->numFemales;
    $input['numMales'] = $this->numMales;
    $input['birthEventStatusKey'] = $this->birthEventStatusKey;
    $input['origin'] = $this->origin;
    $input['litterNum'] = $this->litterNum;
    $input['culledAtWean'] = $this->culledAtWean;
    $input['missAtWean'] = $this->missAtWean;
    $input['litType'] = $this->litType;
    $input['weanDate'] = $this->weanDate;
    $input['tagDate'] = $this->tagDate;
    $input['coment'] = $this->coment;

    $msg = $this->addLitterData($input);
    $this->iaMessage = $msg;
  }

}
