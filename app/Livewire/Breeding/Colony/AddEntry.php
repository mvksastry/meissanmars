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

use App\Models\Slot;
use App\Models\Rack;
use App\Models\Room;

use App\Models\Breeding\Cvterms\CVSpecies;
use App\Models\Breeding\Cvterms\Usescheduleterm;
use App\Models\Breeding\Cvterms\CVProtocol;
//use App\Models\Breeding\Cvterms\Strain;
use App\Models\Strain;
use App\Models\Breeding\Cvterms\CVGeneration;
use App\Models\Breeding\Cvterms\CVPhenotype;
use App\Models\Breeding\Cvterms\Lifestatus;
//use App\Models\Breeding\Room;
use App\Models\Breeding\Cvterms\CVCoatcolor;
use App\Models\Breeding\Cvterms\CVDiet;
use App\Models\Breeding\Cvterms\Owner;
use App\Models\Breeding\Cvterms\CVOrigin;
use App\Models\Breeding\Cvterms\Container;
use App\Models\Breeding\Colony\Mouse;

use App\Traits\Breed\BAddMice;
use App\Traits\Breed\BContainer;


class AddEntry extends Component
{
   
	// display panels/divisions default state
	use BAddMice, BContainer;

	public $iaMessage;

	//class variables
	public $speciesKey, $speciesId, $speciesName, $useScheduleTerms, $protocols;
	public $strains, $generations, $phenotypes, $lifestatus, $rooms, $deflimit=5;
	public $coatcolors, $diets, $owners, $origins, $seachCage, $seachPen, $speciesIdcode;

	public $showEntryForm, $purpose="New", $_protocol_key, $containerId;
	public $usescheduleterm_key, $_litter_key, $_strain_all, $_strain_key;
	public $_generation_key, $dob, $_sex_key, $_lifeStatus_key, $_breedingStatus_key, $cage_id,
	$_room_key, $_coatColor_key, $_diet_key, $_owner_key, $_origin_key, $cmsg,
	$replacement_tag, $comments, $cage_card, $automiceid, $usenextid, $count=0,
	$_phenotype_key, $pad=3, $aumIdFlag = false, $lastIdVal=1, $cage_code;
	
	public $racks,  $rack_id, $room_id, $slotID, $slotval;

	public $cageIdx,  $cageInfos, $idx, $cageNumSuggestion, $newTag, $tagMsg;

	public $countx=0, $cmsg1="", $cmsg2="", $cmsg3="", $cmsg4="", $newCageId, $tagBase, $nt, $origTag;

	//all flags here
	public $cageCreateFlag, $addToCageFlag, $strainMixingFlag, $genderMixingFlag;

	public $strainDB, $genderDB, $LiveNewTagCheck, $idsearch, $runner;

  public function render()
  {
    $this->liveMiceIdCheck($this->speciesIdcode);
    $this->liveCageMonitor($this->cageInfos);
    //$this->cmsg = $this->cageInfos;
    $this->LiveNewTagCheck($this->tagBase);

        return view('livewire.breeding.colony.add-entry');
  }

	public function show($id)
	{
		if($id == 1) { $this->iaMessage = "Selected Mice"; }
		if($id == 4) { $this->iaMessage = "Selected Rat"; }
    if($id == 3) { $this->iaMessage = "Selected Rabbit"; }
		if($id == 5) { $this->iaMessage = "Selected Guniea Pig"; }
    
		$q1 = CVSpecies::where('_species_key', $id)->first();
		$this->speciesKey = $q1->_species_key;
		$this->speciesName = $q1->species;
		$this->useScheduleTerms = UseScheduleTerm::all();
		$this->protocols = CVProtocol::where('_species_key', $id)->get();
		$this->strains = Strain::where('species_id', $id)->get();
		$this->generations = CVGeneration::all();
		$this->phenotypes = CVPhenotype::where('_species_key', $id)->get();
		$this->lifestatus = Lifestatus::all();
		$this->rooms = Room::all();
		$this->racks = Rack::all();
		$this->coatcolors = CVCoatcolor::where('_species_key', $id)->get();
		$this->diets = CVDiet::where('_species_key', $id)->get();
		$this->owners = Owner::all();
		$this->origins = CVOrigin::all();
		//disable this and find the next available cage id that is empty
		$this->containerId = Container::max('containerID');
		$this->cageInfos = $this->suggestedCage();
		//$this->cageNumSuggestion = $this->cageInfos;
		//$this->cage_code = $this->containerId;
		$this->showEntryForm = true;
	}

	public function suggestedCage()
	{
		$maxContainerID = Container::max('containerID');
		$cage_id = $maxContainerID + 1;
		$this->cageCreateFlag = true;
		return $cage_id;
	}

	public function post()
	{
		$this->iaMessage = "Welcome, Pay attention to fields";
        //dd($this->iaMessage);
		$input['speciesName'] = $this->speciesName;
		//$this->validate(['speciesName' => 'required|alpha']);
		$input['purpose'] = $this->purpose;
		//$this->validate(['purpose' => 'required|alpha']);
		$input['_protocol_key'] = $this->_protocol_key;
		//$this->validate(['purpose' => 'required|numeric']);
		$input['_litter_key'] = $this->_litter_key;
		//$this->validate(['_litter_key' => 'required|numeric']);
		$input['_strain_all'] = $this->_strain_all;
		//$this->validate(['_strain_all' => 'required|numeric']);
		$input['_strain_key'] = $this->_strain_key;
		//$this->validate(['_strain_key' => 'required|numeric']);
		$input['_generation_key'] = $this->_generation_key;
		//$this->validate(['_generation_key' => 'required|numeric']);
		$input['dob'] = $this->dob;
		//$this->validate(['dob' => 'required|date_format:Y-m-d']);
		$input['_sex_key'] = $this->_sex_key;
		//$this->validate(['_sex_key' => 'required|numeric']);
		$input['_lifeStatus_key'] = $this->_lifeStatus_key;
		//$this->validate(['lifeStatus' => 'required|numeric']);
		$input['_breedingStatus_key'] = $this->_breedingStatus_key;
		//$this->validate(['_breedingStatus_key' => 'required|numeric']);
		$input['cage_id'] = $this->cage_id;
		//$this->validate(['cage_id' => 'required|numeric']);
		$input['_room_key'] = $this->room_id; // changed by ks
		//$this->validate(['_room_key' => 'required|numeric']);
		$input['_coatColor_key'] = $this->_coatColor_key;
		//$this->validate(['_coatColor_key' => 'required|numeric']);
		$input['_diet_key'] = $this->_diet_key;
		//$this->validate(['_diet_key' => 'required|numeric']);
		$input['_owner_key'] = $this->_owner_key;
		//$this->validate(['_owner_key' => 'required|numeric']);
		$input['_origin_key'] = $this->_origin_key;
		//$this->validate(['_origin_key' => 'required|numeric']);
		$origTag = $this->tagBase;
		$input['replacement_tag'] = $this->tagBase.'-'.strval($this->runner);
		$this->replacement_tag = $this->tagBase.'-'.strval($this->runner);
		//$this->validate(['replacement_tag' => 'required|numeric']);
		$input['cage_card'] = $this->cage_card;
		//$this->validate(['cage_card' => 'required|numeric']);
		$input['_phenotype_key'] = $this->_phenotype_key;
		//$this->validate(['phenotypes' => 'required|numeric']);
		$input['usescheduleterm_key'] = $this->usescheduleterm_key;
		//if($input['usescheduleterm_key'] == null) { $input['usescheduleterm_key'] = array(); }
		//$this->validate(['usescheduleterm_key' => 'required|numeric']);
		$input['comments'] = $this->comments;
		//$this->validate(['comments' => 'required|numeric']);
		$input['speciesId'] = $this->speciesIdcode.'-'.strval($this->runner);
		//check cage selected is correct and ok for strian and gender
		$input['cage_id'] = $this->cageInfos;
		// the line below should set the flag for going ahead
		$this->liveCageMonitor($this->cageInfos);

		if($this->createCageFlag){
			$this->createCage($this->cageInfos);
			$this->addToCageFlag = true;
		}


		// at this stage data collection is complete, check also complete
		if($this->addToCageFlag)
		{
			$this->count = $this->count + 1;

			if($this->count > $this->deflimit )
			{
				$this->cmsg2 = "Note: Default limit breached";
			}

			//now add to db here
			$result = $this->addMice($input);
			//$result = "check container tables";
			$this->iaMessage = $result;
			//after addition to db go to next mice id
			//create mice id based on auto id values for incrementing
			$this->runner = $this->runner + 1;

			if($this->usenextid)
			{
				if($this->count == intval($this->deflimit) )
				{
					$this->cageInfos = $this->cageInfos + 1;
					// disable for testing enable for live
					if($this->createCage($this->cageInfos)){
						$this->addToCageFlag = true;
					}
					else {
						$this->addToCageFlag = false;
					}
					$this->count = 0;
				}
			}
		}
		else{
			$this->iaMessage = "See Messages for any issue";
		}
	}


	public function createCage($cage_id)
	{
		$input['cage_id'] = $cage_id;
		$input['cageName'] = $this->speciesIdcode;
		$input['cageStatus'] = 2; //suppose 2 refers Active, 3 Proposed, 4 Retired
		$input['datex'] = date('Y-m-d');
		$input['_room_key'] = $this->room_id; //ks changed iton 26may2024
		$input['cageComment'] = "New Cage Id [ ".$input['cage_id']." ] Inserted";
 
		if($this->addNew($input))
		{
		    //check for empty slot first before returning true
		    $this->slotval = $this->liveCheckEmptySlot();
			return true;
		}
		else {
			return false;
		}

	}
	
	public function liveCheckEmptySlot()
	{
	    $eres = Slot::select('slot_id')
	                    ->where('status', 'A')
	                    ->where('rack_id', $this->rack_id )
	                    ->first();
	   return $eres->slot_id;
	}

	public function LiveNewTagCheck($newTag)
	{
		$rows = Mouse::where('newTag', $newTag)->get();
		if(count($rows) != 0 )
		{
			$this->tagMsg = "Invalid Tag, already used";
			$this->addToCageFlag = false;
		}
		else{
			$this->tagMsg = "";
			$this->addToCageFlag = true;
		}
	}

	public function liveMiceIdCheck($speciesIdcode){
		$value = $this->speciesIdcode.'-'.strval($this->runner);
	  //$rows = Mouse::where('ID', 'LIKE',"%{$speciesIdcode}%")->get();
		$rows = Mouse::where('ID', $value)->get();
		if(count($rows) != 0 || count($rows) != null){
			$this->cmsg4 = "Code exists, choose another";
			$this->addToCageFlag = false;
		}
		else {
			$this->cmsg4 = "";
			$this->addToCageFlag = true;
		}
	}

	public function liveCageMonitor($cageIdx)
	{
		$result = Container::where('containerID', $cageIdx)->get();

		if( count($result) == 0 || $result == null) {
			$this->countx = 0;
			$this->cmsg2 = "Cage Not Found";
			$this->createCageFlag = true;
			$this->addToCageFlag = false;
		}
		else {
			$this->checkGenderStrain($cageIdx);
			$this->createCageFlag = false;
		}
	}

	public function checkGenderStrain($cageId)
	{
		$rows = Mouse::with('strainSelected')->where('_pen_key', $cageId)->get();
		$str = Mouse::where('_pen_key', $cageId)->first();

		$this->countx = count($rows);

		if($this->countx > 0)
		{
			if($str->sex == $this->_sex_key && $str->_strain_key == intval($this->_strain_key))
			{
				$this->cmsg1 = $str->ID;
				$this->cmsg2 = "Ok to Proceed";
				$this->addToCageFlag = true;
				$this->createCageFlag = false;
			}
			else {
				$this->addToCageFlag = false;
				$this->cmsg2 ="Strain/Gending Mixing Possibility";
				$this->createCageFlag = false;
			}
		}
		else{
			$this->cmsg1 = "None";
			$this->cmsg2 = "Empty Cage";
			$this->addToCageFlag = true;
			$this->createCageFlag = false;
		}
	}

	public function resetForm()
	{

	}
    
    
    
    
}
