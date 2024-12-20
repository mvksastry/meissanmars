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
use App\Traits\Breed\BAddCageInfo;

use Validator;

class AddEntry extends Component
{
   
	// display panels/divisions default state
	use BAddMice, BContainer, BAddCageInfo;

	public $iaMessage;

	//class variables
	public $speciesKey, $speciesId, $speciesName, $useScheduleTerms, $protocols;
	public $strains, $generations, $phenotypes, $lifestatus, $rooms, $deflimit=5;
	public $coatcolors, $diets, $owners, $origins, $seachCage, $seachPen, $speciesIdcode;

	public $showEntryForm, $purpose="New", $_protocol_key, $containerId;
	public $usescheduleterm_key, $_litter_key, $_strain_all, $_strain_key;
	public $_generation_key, $dob, $_sex_key, $_lifeStatus_key='A', $_breedingStatus_key='U', $cage_id,
	$_room_key, $_coatColor_key, $_diet_key, $_owner_key='EAF-NCCS', $_origin_key='EAF-NCCS', $cmsg,
	$replacement_tag, $comments, $cage_card, $automiceid=true, $usenextid=true, $count=0,
	$_phenotype_key, $pad=3, $aumIdFlag = false, $lastIdVal=1, $cage_code;
	
	public $racks, $racksInRoom=[], $free_slots, $fslot_num, $rack_id, $room_id, $slotID, $slotval;

	public $cageIdx,  $cageInfos, $idx, $cageNumSuggestion, $newTag, $tagMsg;

	public $countx=0, $cmsg1="", $cmsg2="", $cmsg3="", $cmsg4="", $cmsg5="", $newCageId;
	public $tagBase, $nt, $origTag, $mice_ids = [], $mice_idx=[];

	//slot id information retrieved
	public $sarray=[], $rarray=[];
	
	//all flags here
	public $cageCreateFlag, $addToCageFlag, $strainMixingFlag, $genderMixingFlag;
	public $mouseIdFlag=false, $mouseTagFlag=false, $slotSelectFlag=false;
	public $displayPTandUS=false;


	public $strainDB, $genderDB, $LiveNewTagCheck, $idsearch, $runner;

	protected $rules = [
				'speciesIdcode'       => 'required|alpha_dash',
        'runner'              => 'required|numeric',
				'_protocol_key'       => 'sometimes|nullable|numeric',
				'_litter_key'         => 'sometimes|nullable|numeric',
				'_strain_key'         => 'required|numeric',
				'_generation_key'     => 'required|alpha_num',
				'dob'                 => 'required|date_format:Y-m-d',
				'_sex_key'            => 'required|alpha',
				'_lifeStatus_key'     => 'required|alpha',
				'_breedingStatus_key' => 'required|alpha',
				'_coatColor_key'      => 'sometimes|nullable|alpha_dash',
				'_diet_key'           => 'sometimes|nullable|numeric',
				'_owner_key'          => 'required|alpha_dash',
				'_origin_key'         => 'required|alpha_dash',
				'tagBase'             => 'required|alpha_dash',
			//'replacement_tag'     => 'alpha_dash',
				'cage_card'           => 'sometimes|nullable|regex:/^[\pL\s\- .,;0-9_]+$/u|max:500',
				'phenotypes'          => 'sometimes|nullable|array',
				'usescheduleterm_key' => 'sometimes|nullable|array',
				'comments'            => 'sometimes|nullable|regex:/^[\pL\s\- .,;0-9_]+$/u|max:500',
				'room_id'             => 'required|numeric',
			//'cage_id'             => 'required|numeric',
				'cageInfos'						=> 'required|numeric'
  ];
		
  public function render()
  {
    $this->liveMiceIdCheck($this->speciesIdcode);
    $this->liveCageMonitor($this->cageInfos);
    //$this->cmsg = $this->cageInfos;
    $this->LiveNewTagCheck($this->tagBase);

    return view('livewire.breeding.colony.add-entry');
  }
	
	public function validateFormInputs()
	{
		$this->validate();
		//dd($this->mouseIdFlag);
		
		if($this->mouseIdFlag && $this->mouseTagFlag)
		{
			if($this->slotSelectFlag)
			{
				$this->addToCageFlag = true;
			}
		}
		else {
			$this->addToCageFlag = false;
		}
	}
	
	public function updatedSpeciesIdcode($speciesIdcode)
	{
		$this->validateOnly($speciesIdcode);
	}
	
	public function updatedRunner($runner)
	{
		$this->validateOnly($runner);
	}

	public function updatedDob($dob)
	{
		$this->validateOnly($dob);
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
		//$this->cageInfos = $this->suggestedCage(); // original line
		$this->cageInfos = "Not Selected";
		//$this->cageNumSuggestion = $this->cageInfos;
		//$this->cage_code = $this->containerId;
		$this->addToCageFlag = false;
		$this->cageCreateFlag = false;
		$this->showEntryForm = true;
	}

	public function post()
	{
		
		//$this->validate(['_protocol_key' => 'sometimes|numeric']);
		//$this->validate(['_litter_key' => 'sometimes|numeric']);
		//$this->validate(['_strain_all' => 'required|numeric']);
		//$this->validate(['_generation_key' => 'required|numeric']);
		//$this->validate(['dob' => 'required|date_format:Y-m-d']);
		//$this->validate(['_sex_key' => 'required|numeric']);
		//$this->validate(['lifeStatus' => 'required|numeric']);
		//$this->validate(['_breedingStatus_key' => 'required|numeric']);
		//$this->validate(['_coatColor_key' => 'required|numeric']);
		//$this->validate(['_diet_key' => 'required|numeric']);
		//$this->validate(['_owner_key' => 'required|numeric']);
		//$this->validate(['_origin_key' => 'required|numeric']);
		//$this->validate(['replacement_tag' => 'required|numeric']);
		//$this->validate(['cage_card' => 'required|numeric']);
		//$this->validate(['phenotypes' => 'required|numeric']);
		//$this->validate(['usescheduleterm_key' => 'required|numeric']);
		//$this->validate(['cage_id' => 'required|numeric']);
		//$this->validate(['_room_key' => 'required|numeric']);
		//$this->validate(['comments' => 'required|numeric']);
		
		$this->validate();
		
		$this->iaMessage = "Welcome, Pay attention to fields";
    //dd($this->iaMessage);
		$input['speciesName'] = $this->speciesName;
		$input['purpose'] = $this->purpose;
		$input['_protocol_key'] = $this->_protocol_key;	
		$input['_litter_key'] = $this->_litter_key;
		$input['_strain_key'] = $this->_strain_key;
		$input['_generation_key'] = $this->_generation_key;
		$input['dob'] = $this->dob;
		$input['_sex_key'] = $this->_sex_key;
		$input['_lifeStatus_key'] = $this->_lifeStatus_key;
		$input['_breedingStatus_key'] = $this->_breedingStatus_key;
		$input['_coatColor_key'] = $this->_coatColor_key;
		$input['_diet_key'] = $this->_diet_key;
		$input['_owner_key'] = $this->_owner_key;
		$input['_origin_key'] = $this->_origin_key;
		$origTag = $this->tagBase;
		$input['replacement_tag'] = $this->tagBase.'-'.strval($this->runner);
		$this->replacement_tag = $this->tagBase.'-'.strval($this->runner);
		$input['cage_card'] = $this->cage_card;
		$input['_phenotype_key'] = $this->_phenotype_key;
		$input['usescheduleterm_key'] = $this->usescheduleterm_key;
		$input['comments'] = $this->comments;
		$input['speciesId'] = $this->speciesIdcode.'-'.strval($this->runner);

		//check cage selected is correct and ok for strian and gender
		$input['_room_key'] = $this->room_id; // changed by ks
		$input['rack_id'] = $this->rack_id;
		$input['slot_id'] = $this->cageInfos; //This is slot id
		$input['_strain_key'] = $input['_strain_key'];
		$input['_species_key'] = $this->speciesKey;
		// the line below should set the flag for going ahead

		//dd($input);

		//$this->liveCageMonitor($this->cageInfos);

		// at this stage data collection is complete, check also complete
		if($this->addToCageFlag)
		{
			$this->count = $this->count + 1;

			if($this->count > $this->deflimit )
			{
				$this->cmsg2 = "Note: Default limit breached";
			}

			
			//input data preparation for cage rack slot info tables;
			array_push($this->mice_idx, $input['speciesId']);
			//now add to db here
			$result = $this->addMice($input);
			//$result = true;
			//For test comment above result and set result to true.
			// else opposite. comment out $result = true;
			
			//$result = "check container tables";
			$this->iaMessage = $result;
			//after addition to db go to next mice id
			//create mice id based on auto id values for incrementing
			$this->runner = $this->runner + 1;

			if($this->usenextid)
			{
				if($this->count == intval($this->deflimit) )
				{
					//this means default limit added and hence make the 
					//entries in the rack, slot, cage ids.
					//dd($this->mice_ids, $this->mice_idx);
					$input['animal_count'] = $this->count;
					$input['mice_ids'] = $this->mice_idx;
					$result = $this->updateRackSlotCageInfo($input);

					//remove the slot_id from the array as the next one
					//will get selected later on.
					unset($this->rarray[0]);
					
					if(count($this->rarray) != 0)
					{
						$this->rarray = array_values($this->rarray);
						//$this->cageInfos = $this->cageInfos + 1; //this should be next available slot.
						$this->cageInfos = $this->rarray[0];
						// disable for testing enable for live
						
						//select next available slot id here if no slots available
						//close the flag.
						//dd($this->cageInfos);
						/*
						if($this->createCage($this->cageInfos))
						{
							$this->addToCageFlag = true;
						}
						else {
							$this->addToCageFlag = false;
						}
						*/
						$this->mice_idx = [];
					}
					else {
						$this->cageInfos = null;
						$this->cageInfos = "Select New Rack";
						$this->addToCageFlag = false;
					}
					$this->count = 0;
				}
			}
			else {
				$this->addToCageFlag = false;
			}
		}
		else{
			$this->iaMessage = "See Messages for any issue";
		}
	}
	
/*
	public function suggestedCage()
	{
		$maxContainerID = Container::max('containerID');
		$cage_id = $maxContainerID + 1;
		$this->cageCreateFlag = true;
		return $cage_id;
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
*/

	public function LiveNewTagCheck($newTag)
	{
		$rows = Mouse::where('newTag', $newTag)->get();
		if(count($rows) != 0 )
		{
			$this->tagMsg = "Invalid Tag, already used";
		}
		else{
			$this->tagMsg = "";
			$this->mouseTagFlag = true;
		}
	}

	public function liveMiceIdCheck($speciesIdcode){
		$value = $this->speciesIdcode.'-'.strval($this->runner);
	  //$rows = Mouse::where('ID', 'LIKE',"%{$speciesIdcode}%")->get();
		$rows = Mouse::where('ID', $value)->get();

		if(count($rows) != 0 || count($rows) != null){
			$this->cmsg4 = "Code exists, choose another";
			//$this->addToCageFlag = false;
			$this->mouseIdFlag = false;
		}
		else {
			$this->cmsg4 = "";
				if($value != "-")
				{
					$this->cmsg5 = $value;
					$this->cmsg4 = "New Code Valid";
					$this->mouseIdFlag = true;
				}
				else {
					$this->cmsg5 = "";
					$this->mouseIdFlag = false;
				}
		}
	}

	public function liveCageMonitor($cageIdx)
	{

	}

/*
	public function checkGenderStrain($slot_id)
	{
		//$rows = Mouse::with('strainSelected')->where('_pen_key', $cageId)->get();
		$cageidr = Slot::where('slot_id', $slot_id)
										->where('rack_id', $this->rack_id)
										//->where('status','O')
										->first();
										
		if($cageidr->cage_id != 0)
		{
			$str = Mouse::where('_pen_key', $cageId)->first();
			if($str->sex == $this->_sex_key && $str->_strain_key == intval($this->_strain_key))
			{
				$this->cmsg1 = $str->ID;
				$this->cmsg2 = "Ok to Proceed";
				$this->slotSelectFlag = true;
			}
			else {
				$this->cmsg2 ="Strain/Gender Mixing Possibility";
			}
		}
		else{
			$this->cmsg1 = "";
			return "Occupied or Non-available slot";
		}
		
	}
*/
	public function showPhenTypesUseSch()
	{
		//dd("reached");
		$this->displayPTandUS = true;
	}
	
	public function offPhenTypesUseSch()
	{
		$this->displayPTandUS = false;
	}
	
	public function resetForm()
	{

	}
    
  public function roomSelected()
	{
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
			$this->validateOnly($this->cageInfos);
			$this->slotSelectFlag = true;
			$this->cageCreateFlag = true;
		}
		else {
			$this->fslot_num = "No Free slots in rack";
		}
	}	  
	
	
}
