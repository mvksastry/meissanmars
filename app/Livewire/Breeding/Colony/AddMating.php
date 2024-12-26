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

use App\Models\Breeding\Cvterms\CVSpecies;
use App\Models\Breeding\Cvterms\UseScheduleTerm;
use App\Models\Breeding\Cvterms\CVProtocol;
//use App\Models\Breeding\Cvterms\Strain;
use App\Models\Breeding\Cvterms\CVGeneration;
use App\Models\Breeding\Cvterms\CVPhenotype;
use App\Models\Breeding\Cvterms\Lifestatus;
use App\Models\Breeding\Cvterms\CVCoatcolor;
use App\Models\Breeding\Cvterms\CVDiet;
use App\Models\Breeding\Cvterms\Owner;
use App\Models\Breeding\Cvterms\CVOrigin;
use App\Models\Breeding\Cvterms\Container;
use App\Models\Breeding\Cvterms\CVMatingtype;
use App\Models\Breeding\Colony\Mouse;
use App\Models\Breeding\Colony\Mating;

use App\Models\Cage;
use App\Models\Rack;
use App\Models\Room;
use App\Models\Slot;
use App\Models\Strain;

// Traits below
use App\Traits\Breed\BEditMice;
use App\Traits\Breed\BContainer;
use App\Traits\Breed\BAddMating;
use App\Traits\Breed\BAddCageInfo;
use App\Traits\CageInfoUpdate;

use Validator;
use Livewire\Attributes\Validate;

class AddMating extends Component
{
    // display panels/divisions default state
    use BEditMice, BContainer, BAddMating, BAddCageInfo;
		use CageInfoUpdate;
		
    //message here
    public $iaMessage;

    //form state declarations
    public $showMatingEntryForm, $showEntrySearchForm = false; 
		public $formCageSelect =false, $formCageNew = false;
		
		//flags
		public $dam1flag=false, $dam2flag=false, $sireflag=false;
		public $allFlagsClear=false;

    public $strains, $generations, $diets, $strain_id;

		//selected objects meaning before form Entry
		public $selectedDam1, $selectedDam2, $selectedSire;
		
    public $speciesName, $purpose, $newMatingId, $newMatingRefID;
    public $dam1Key, $dam1Msg, $dam2Key, $dam2Msg, $sireKey, $sireMsg;
    public $dam1Id, $dam2Id, $sireId, $diet_key, $strain_key, $matgType=1, $generation_key;
    public $genotypeneed, $ownerwg="EAF-NCCS", $matingDate,  $weantime, $slot_id, $weannote, $comments;
    public $matingType, $species_name, $lifestatus, $owners, $dam1=1, $dam2=2, $sire=3;

    public $rooms, $cageChars, $cageParams, $cageName, $cageStatus, $cageRooms, $datex;
		
    public $cageCreateMessage="", $cageComment, $dam1CageId, $dam2CageId, $sireCageId;

    public $dam1Strain, $dam2Strain, $sireStrain, $dam1Diet, $dam2Diet, $sireDiet;

    public $asdam1, $asdam2, $assire, $iaSearchMessage, $searchFor;
    //status declarations
		
		//Rooms, Rack, and Slot selection variables
		public $racks, $racksInRoom=[], $free_slots, $fslot_num;
		public $rack_id, $room_id, $slotID, $slotval, $cageInfos;
		//public $showRacks=false;

	protected $rules = [

		'strain_key'     => 'required|numeric',
		'generation_key' => 'required|alpha_num',
		'ownerwg'        => 'required|alpha_dash',
		'matingDate'     => 'required|date',
		'weantime'       => 'required|numeric',
		'room_id'        => 'required|numeric',
		'rack_id'        => 'required|numeric',
		'slot_id'        => 'required|numeric',

		'diet_key'       => 'sometimes|nullable|numeric',
		'matgType'       => 'sometimes|nullable|numeric',		

		'genotypeneed'   => 'sometimes|nullable|boolean',
		'weannote'       => 'sometimes|nullable|regex:/^[\pL\s\- .,;0-9_]+$/u|max:500',
		'comments'       => 'sometimes|nullable|regex:/^[\pL\s\- .,;0-9_]+$/u|max:500',
		
  ];
	

	
    public function render()
    {
      $this->dam1IdCheck($this->dam1Id);
      $this->dam2IdCheck($this->dam2Id);
      $this->sireIdCheck($this->sireId);
			$this->rackSelCheck($this->cageRooms);
      return view('livewire.breeding.colony.add-mating');
    }

		public function clearAllFlagsForEntry()
		{
			$this->allFlagsClear = false;
			$this->validate();
			
			if($this->dam1flag || $this->dam2flag)
			{
				if($this->sireflag)
				{
					$this->allFlagsClear = true;
				}
			}
		}
		
		public function changeStrainInfos()
		{
			
			
		}
		
		public function rackSelCheck($room_id)
		{
			//$this->racksInRoom = Rack::where('room_id', $room_id)->get();
			//dd($racksInRooms);
		}

    public function dam1IdCheck($dam1Id)
    {
			//dd($dam1Id);
      $qry = Mouse::with('strainSelected')->where('ID', $this->dam1Id)->where('sex', 'F')->first();
			if(!empty($qry))
      {
          $this->dam1Key = $qry->_mouse_key;
          $qry2 = Mating::where('_dam1_key', $qry->_mouse_key)
                          ->orWhere('_dam2_key', $qry->_mouse_key)->get();
          if(count($qry2) == 0 ){
							//$this->selectedDam1 = $qry;
              $this->dam1Strain = $qry->strainSelected->strain_name;
              $this->dam1CageId = $qry->_pen_key;
              $this->dam1Diet = $qry->diet;
              $this->dam1Msg = 'Yes; No Entries';
							$this->dam1flag = true;
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
      $qry = Mouse::with('strainSelected')->where('ID', $this->dam2Id)->where('sex', 'F')->first();
      if(!empty($qry)){
          $this->dam2Key = $qry->_mouse_key;
          $qry2 = Mating::where('_dam1_key', $qry->_mouse_key)
                          ->orWhere('_dam2_key', $qry->_mouse_key)->get();
          if(count($qry2) == 0 ){
							//$this->selectedDam2 = $qry;
              $this->dam2Strain = $qry->strainSelected->strainName;
              $this->dam2CageId = $qry->_pen_key;
              $this->dam2Diet = $qry->diet;
              $this->dam2Msg = 'Yes; No Entries';
							$this->dam2flag = true;
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
      $qry = Mouse::with('strainSelected')->where('ID', $this->sireId)->where('sex', 'M')->first();
      if(!empty($qry)){
          $this->sireKey = $qry->_mouse_key;
          $qry2 = Mating::where('_sire_key', $qry->_mouse_key)->get();
          if(count($qry2) == 0 ){
							//$this->selectedSire = $qry;
              $this->sireStrain = $qry->strainSelected->strainName;
              $this->sireCageId = $qry->_pen_key;
              $this->sireDiet = $qry->diet;
              $this->sireMsg = 'Yes; No Entries';
							$this->sireflag = true;
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
      if($id == 1) { $speciesName = "Mice"; $this->iaMessage = "Selected Mice"; }
      if($id == 4) { $speciesName = "Rat";  $this->iaMessage = "Selected Rat"; }
			$this->speciesName = $speciesName;
			$this->strains = Strain::where('species_id', $id)->get();
			$this->generations = CVGeneration::all();
			$this->matingType = CVMatingtype::all();
			$this->diets = CVDiet::where('_species_key', $id)->get();
			$this->owners = Owner::all();
			$this->purpose = "New";
			$this->rooms = Room::all();
			$this->racks = Rack::all();
      $this->showMatingEntryForm = true;
    }

    public function search($speciesName)
    {
      $exr = explode('_', $speciesName);

      $this->species_name = $speciesName;
			
      if( $exr[0] == "Mice" )     { $_species_key = 1; }
      if( $exr[0] == "Rat" )      { $_species_key = 2; }
      if( $exr[0] == "Rabbit" )   { $_species_key = 3; }
      if( $exr[0] == "Guinea_Pig"){ $_species_key = 4; }
      
      $this->searchFor = $exr[1];
      $this->strains = Strain::where('species_id', $_species_key)->get();
			//dd($this->strains);
      $this->generations = CVGeneration::all();
      $this->matingType = CVMatingtype::all();
      $this->lifestatus = Lifestatus::all();
      $this->owners = Owner::all();

      $this->showEntrySearchForm = true;
    }

    public function post()
    {
      $this->iaMessage = "Welcome, Pay attention to fields";

      $input['speciesName'] = $this->speciesName;
      $input['purpose'] = $this->purpose;
			$input['matingRefID'] = $this->newMatingRefID;
      $input['dam1Id'] = $this->dam1Id;
      $input['dam1Key'] = $this->dam1Key;
      $input['dam2Id'] = $this->dam2Id;
      $input['dam2Key'] = $this->dam2Key;
      $input['sireId'] = $this->sireId;
      $input['sireKey'] = $this->sireKey;
      $input['diet_key'] = $this->diet_key;
      $input['_strain_key'] = $this->strain_key;
      $input['matgType'] = $this->matgType;
      $input['generation_key'] = $this->generation_key;
      $input['genotypeneed'] = $this->genotypeneed;
      $input['ownerwg'] = $this->ownerwg;
      $input['matingDate'] = $this->matingDate;
      $input['weantime'] = $this->weantime;
      $input['cage_id'] = $this->slot_id; //this is not cage but slot_index.
      $input['weannote'] = $this->weannote;
      $input['comments'] = $this->comments;
      //dd($input);
      $result = $this->addMating($input);
			//$result = true; //for testing uncomment this, comment above
			//now update cage information
			if($result)
			{
				$ac = 0; $acid = [];
				if($this->dam1Id != null)
				{
					$ac = $ac + 1;
					$acid[] = $this->dam1Id;
					$dam1Info = Mouse::where('ID', $this->dam1Id)->first();
					$dam1Cage_id = $dam1Info->cage_id;
					$dam1slot_id = $dam1Info->slot_id;
					$dam1rack_id = $dam1Info->rack_id;
					$rex = $this->updateAnimalNumber($this->dam1Id, $dam1Cage_id, $dam1slot_id, $dam1rack_id);
					/*
					//$rexy = $this->removeIDFromCage($this->dam1Id, $dam1Cage_id);
					$cageRes = Cage::where('cage_id', $dam1Cage_id)->first();
					$cageMiceIDs = json_decode($cageRes->mouse_ids);
					if (($key = array_search($this->dam1Id, $cageMiceIDs)) !== false) 
					{
						unset($cageMiceIDs[$key]);
					}
					$cageMiceIDsMice = json_encode($cageMiceIDs);
					$cageRes->mice_ids = $cageMiceIDsMice;
					$cageRes->save();
					dd($cageMiceIDs, $cageRes);
					*/
				}
				
				if($this->dam2Id != null)
				{
					$ac = $ac + 1;
					$acid[] = $this->dam2Id;
					$dam2Info = Mouse::where('ID', $this->dam2Id)->first();
					$dam2Cage_id = $dam2Info->cage_id;
					$dam2slot_id = $dam2Info->slot_id;
					$dam2rack_id = $dam2Info->rack_id;
					$rex = $this->updateAnimalNumber($this->dam2Id, $dam2Cage_id, $dam2slot_id, $dam2rack_id);
				}				
				
				if($this->sireId != null)
				{
					$ac = $ac + 1;
					$acid[] = $this->sireId;
					$sireInfo = Mouse::where('ID', $this->sireId)->first();
					$sireCage_id = $sireInfo->cage_id;
					$sireslot_id = $sireInfo->slot_id;
					$sirerack_id = $sireInfo->rack_id;
					$rex = $this->updateAnimalNumber($this->sireId, $sireCage_id, $sireslot_id, $sirerack_id);
				}				
				
				//for creating the mating cage, anew id is created.
				$input['_species_key'] = $this->getSpeciesKeyBySpeciesName($this->speciesName);
				$input['animal_count'] = $ac;
				$input['mice_ids'] = $acid;
				$input['rack_id'] = $this->rack_id;
				$input['slot_id'] = $this->slot_id;
				//dd($input);
				$final_res = $this->updateRackSlotCageInfo($input);
				
				//now update the slot index in the mating table for column suggestedPenID
				$matchThese = ['slot_id' => $this->slot_id, 'rack_id' => $this->rack_id];
				$slot_index = Slot::where($matchThese)->value('slot_index');

				$matchThis = ['_mating_key' => $this->newMatingId];
				$putThis = ['suggestedPenID' => $slot_index];
				$result = Mating::where($matchThis)->update($putThis);
				//now reduce the mice number by the 
				//number transferred to mating cage.
				
				
				$this->allFlagsClear = false;
				$this->clearMatingForm();
				$this->iaMessage = "Mating Entry Creation Success";
			}      
    }

		public function clearMatingForm()
		{
			$this->speciesName = "Mice";
      $this->purpose = "New";
      $this->dam1Id = null;
      $this->newMatingRefID = null;
      $this->dam2Id = null;
      //$this->dam2Key = null;
      $this->sireId = null;
      //$this->sireKey = null;
      $this->diet_key = null;
      $this->strain_key = null;
      $this->matgType = null;
      $this->generation_key = null;
      $this->genotypeneed = false;
      $this->ownerwg = null;
      $this->matingDate = null;
      $this->weantime = null;
      //$this->cage_id = null; 
			$this->room_id = null;
			$this->rack_id = null;
      $this->weannote = null;
      $this->comments = null;
			
			$this->fslot_num = "";
			$this->cageInfos = null;
			$this->free_slots = null;
			$this->slot_id = null;
			$this->iaMessage = "Mating Entry Creation Success: Refresh page for new Mating Entry";
			
			$this->dam1flag = false;
			$this->dam2flag = false;
			$this->sireflag = false;
			
			$this->sireStrain = null;
      $this->sireCageId = null;
      $this->sireDiet = null;
      $this->sireMsg = null;
			
			$this->dam2Strain = null;
      $this->dam2CageId = null;
      $this->dam2Diet = null;
      $this->dam2Msg = null; 
			
			$this->dam1Strain = null;
      $this->dam1CageId = null;
      $this->dam1Diet = null;
      $this->dam1Msg = null;
			
		}
		
    public function pick($id)
    {
      $ix = explode('_', $id);
      if($ix[0] === "Dam1"){
          $this->dam1Id = $ix[1];
      }
      if($ix[0] === "Dam2"){
          $this->dam2Id = $ix[1];
      }
      if($ix[0] === "Sire"){
          $this->sireId = $ix[1];
      }
      $this->entrySearchResult = false;
      $this->showEntrySearchForm = false;
    }


	/*
		protected $validationAttributes = [
        'slot_id' => 'Slot ID'
    ];
		
		protected $message = [
				'slot_id.required' => 'The Email Address cannot be empty.',
        'slot_id.numeric' => 'The Slot ID is number only.',
		];

    public function cageSearch()
    {
      $this->rooms = Room::all();
      $this->formCageSelect = true;
    }

    public function searchCage()
    {
      $input['cageParams'] = $this->cageParams;
      $input['cageChars'] = $this->cageChars;
      $input['cageName'] = $this->cageName;
      $input['cageStatus'] = $this->cageStatus;
      $input['cageRooms'] = $this->cageRooms;

      dd($input);
    }

    // make an entry in container table and a
    // corresponding entry in containerhistory
    public function cageNew()
    {
      $this->cageChars = Container::max('containerID') + 1;
      $this->datex = date('Y-m-d');
      $this->rooms = Room::all();
      $this->formCageNew = true;
    }

    public function addNewCage()
    {
      if($this->nextCageId){
          $input['cage_id'] = $this->cageChars + 1;
      }
      else {
          $input['cage_id'] = $this->cageChars;
      }

      $input['cageName'] = $this->cageName;
      $input['cageStatus'] = $this->cageStatus[0];
      $input['datex'] = $this->datex;
      $input['cageRooms'] = $this->cageRooms[0];
      $input['cageComment'] = $this->cageComment;

      // all info collection complete, go for db entry
      $newCageId = $this->addNew($input); // finish creating new cage

      //now set the new cage to the form field
      $this->cage_id = $newCageId;

      $this->cageCreateMessage = "New cage Id [ ".$newCageId." ] created";
    }

    public function closeSearchCage()
    {
      $this->formCageSelect = false;
    }

    public function closeNewCage()
    {
      $this->formCageNew = false;
    }

    public function resetform()
		{

    }
	*/

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
