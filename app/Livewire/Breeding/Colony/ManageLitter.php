<?php

namespace App\Livewire\Breeding\Colony;

use Livewire\Component;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Strain;
use App\Models\Cage;
use App\Models\Rack;
use App\Models\Room;
use App\Models\Slot;

use App\Models\Breeding\Cvterms\CVBirtheventstatus;
use App\Models\Breeding\Cvterms\CVDiet;
use App\Models\Breeding\Cvterms\CVLittertype;
use App\Models\Breeding\Cvterms\CVOrigin;
use App\Models\Breeding\Cvterms\CVProtocol;
use App\Models\Breeding\Cvterms\CVSpecies;

use App\Models\Breeding\Cvterms\Container;
use App\Models\Breeding\Cvterms\Lifestatus;
use App\Models\Breeding\Cvterms\Owner;

use App\Models\Breeding\Cvterms\Usescheduleterm;

use App\Models\Breeding\Colony\Litter;
use App\Models\Breeding\Colony\Mating;
use App\Models\Breeding\Colony\Mouse;

// all traits here
use App\Traits\Breed\BContainer;
use App\Traits\Breed\BMatingSearch;
use App\Traits\Breed\BManageLitter;

use Illuminate\Support\Facades\Route;

class ManageLitter extends Component
{
	use BMatingSearch, BManageLitter;

  public $iaMessage;

  public $showLitterEntryForm=false, $showSearchMatingEntryForm, $litterCalculation;

  //compulsory information
  public $speciesName, $speciesKey, $purpose, $matKey, $xspecies_id, $xstrain_id;

  //Model objects
  public $useScheduleTerms, $protocols, $lifestatus, $litterTypes, $strains, $origins, $owners, $birthStatuses;

  //check boxes
  public $ppidb = false, $agmr = true, $autoDates=true, $femaleFirst = true, $lpimc = false;

  // form variables
  public $totalBorn, $baseMouseId, $bornDead, $protoKey, $numFemales, $numMales, $useScheduleKeys;
  public $origin="EAF-NCCS", $culledAtWean, $missAtWean, $cageId, $litterNum, $femalePerCage, $malePerCage;
  public $litType=1, $dateBorn, $weanDate, $tagDate, $birthEventStatusKey="A", $coment;

  public $matingId_contains, $matingId, $strainKey, $spKey, $lifeStatus, $ownerWg, $fromDate, $toDate;
  public $matSearchResults, $searchResultsMating, $mqryResult, $wean_time=0;
  public $fullLitterDetails=[], $matingReferenceID=null, $curLitterKey=null;
	
  public $roomId, $rackId;
	
	public $rooms, $racks;
	public $fslot_num,$free_slots,$racksInRoom=[], $rack_id, $room_id, $slot_id;
	
	//panels
	public $showLitterEntriesTillDate = false;
	
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
		return view('livewire.breeding.colony.manage-litter');
	}
		
  public function doDates()
  {
    $dob = $this->dateBorn;
		
		$wean_days = " + ".$this->wean_time." days";
		
    if(strtotime($dob) == null || empty(strtotime($dob)))
    {
        $dob = date('Y-m-d');
        $this->dateBorn = $dob;
        $this->weanDate = date('Y-m-d', strtotime($dob.$wean_days));
        $this->tagDate = date('Y-m-d');
    }
    else{
        $this->weanDate = date('Y-m-d', strtotime($dob.$wean_days));
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

  public function searchMates($speciesName)
  {
    if($speciesName == "Mice") { $this->spKey = 1; }
    if($speciesName == "Rat") { $this->spKey = 4; }

    $this->strains = Strain::where('species_id', $this->spKey)->get();
    $this->lifestatus = Lifestatus::all();
    $this->owners = Owner::all();

    $this->showSearchMatingEntryForm = true;
  }

  public function pullMatingEntries()
	{

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
		$this->resetLitterDetails();
    $qry = Mating::where('_mating_key', $id)->first();
		$this->matingReferenceID = $qry->matingRefID;
    $this->mqryResult = $qry;
		$this->wean_time = $qry->weanTime;
    $this->matKey = $id;
		$this->xstrain_id = $qry->_strain_key;
		$this->xspecies_id = $qry->_species_key;
		
		//latest litter details
		$matchThese = ['_mating_key' => $id, 'entry_status' => 'open'];
		$latLitEntry = Litter::where($matchThese)->latest()->first();
		
		// all litter details
		$this->fullLitterDetails = Litter::where('_mating_key', $id)->get();
		//dd($latLitEntry, $this->fullLitterDetails);
		if(!empty($latLitEntry) || $latLitEntry != null)
		{
			//litter entries exist
			$this->curLitterKey = $latLitEntry->_litter_key;
			$this->purpose = "Update";
			$this->dateBorn = date('Y-m-d', strtotime($latLitEntry->birthDate));
			$this->totalBorn = $latLitEntry->totalBorn;
			$this->bornDead = $latLitEntry->numberBornDead;
			$this->numFemales = $latLitEntry->numFemale;
			$this->numMales = $latLitEntry->numMale;
			//$this->birthEventStatusKey = $latLitEntry->;
			//$this->origin = $latLitEntry->;
			//$this->litterNum = $latLitEntry->;
			$this->culledAtWean = $latLitEntry->numberCulledAtWean;
			$this->missAtWean = $latLitEntry->numberMissingAtWean;
			$this->litType = $latLitEntry->_litterType_key;
			$this->weanDate = $latLitEntry->weanDate;
			$this->tagDate = $latLitEntry->tagDate;
			$this->coment = $latLitEntry->comment;
		
			// in this case I should populate the form with latest data??
		}
		else {
			// no litter entries found and we need to populate the field?
			$this->purpose = "New";
		}
		
		//dd($this->fullLitterDetails);
    //$this->showSearchMatingEntryForm = false;
    //$this->searchResultsMating = false;
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
		//$this->diets = CVDiet::where('_species_key', $id)->get();
		$this->origins = CVOrigin::all();
    $this->litterTypes = CVLittertype::all();
    $this->birthStatuses = CVBirtheventstatus::all();
		//$this->containerId = Container::max('containerID');
		$this->rooms = Room::all();
		$this->racks = Rack::all();
		//$this->cageInfos = $this->suggestedCage();
		$this->showLitterEntryForm = true;
	}	

  public function enterLitter()
  {
		if($this->purpose == "New" || $this->purpose == "Update")
		{
			$input['xspecies_id'] = $this->xspecies_id;
			$input['xstrain_id'] = $this->xstrain_id;
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

			$msg = $this->addLitterData($this->purpose, $input);
			
			// now change cage_type from M to W meaning pups present in 
			// the cage
			$slot_index = Mating::where('_mating_key', $this->matKey)->value('suggestedPenID');
			$cage_id = Slot::where('slot_index', $slot_index)->value('cage_id');
			$cageInfo = Cage::where('cage_id', $cage_id)->first();
			//dd($this->matKey, $slot_index, $cage_id, $cageInfo);
			$cageInfo->cage_type = 'W';
			$cageInfo->save();
			
			if($msg)
			{
				$this->resetLitterDetails();
			}
		}
		else {
			$this->iaMessage = "Refresh Form, Pick Mating ID";
		}
  }

	public function resetLitterDetails()
	{
		$this->purpose = "";
		$this->matingReferenceID = null;
		$this->dateBorn = date('Y-m-d');
		$this->mqryResult = null;
		$this->wean_time = null;
    $this->matKey = null;
    $this->totalBorn= null;
    $this->bornDead = null;
    $this->numFemales = null;
    $this->numMales = null;
    $this->birthEventStatusKey = null;
    $this->origin = null;
    $this->litterNum = null;
    $this->culledAtWean = null;
    $this->missAtWean = null;
    $this->litType = null;
    $this->weanDate = null;
    $this->tagDate = null;
    $this->coment = null;
		
	}
	public function roomSelected()
	{
		$this->fslot_num = "";
		$this->cageInfos = null;
		$this->free_slots = null;
		$room_id = $this->room_id;
		$this->racksInRoom = Rack::where('room_id', $room_id)->get();
		//dd($room_id, $this->racksInRoom);
	}	

	public function rackSelected()
	{
		$rack_id = $this->rack_id;
		$slots = Slot::where('rack_id', $rack_id)->where('status','A')->get();
		$this->free_slots = $slots->count();
		//if no free slots available throw Message
		if($this->free_slots > 0)
		{
			$this->sarray = $slots->toArray();
			$this->rarray = [];
			foreach($this->sarray as $row)
			{
				$this->rarray[] = $row['slot_id'];
			}
			$this->fslot_num = json_encode(array_slice($this->rarray, 0, 5, true));
			//dd($rarray, $sarray);
			$this->cageInfos = $this->rarray[0];
			$this->slot_id = $this->rarray[0];
			//dd($this->cageInfos);
			//$this->validateOnly($this->cageInfos);
			//$this->slotSelectFlag = true;
			//$this->cageCreateFlag = true;
		}
		else {
			$this->fslot_num = "No Free slots in rack";
		}
	}
	
}
