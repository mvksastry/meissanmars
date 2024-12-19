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

//use App\Models\Breeding\Cvterms\CVBirtheventstatus;
//use App\Models\Breeding\Cvterms\CVDiet;
//use App\Models\Breeding\Cvterms\CVLittertype;
//use App\Models\Breeding\Cvterms\CVOrigin;
use App\Models\Breeding\Cvterms\CVProtocol;
use App\Models\Breeding\Cvterms\CVSpecies;

//use App\Models\Breeding\Cvterms\Container;
//use App\Models\Breeding\Cvterms\Lifestatus;
//use App\Models\Breeding\Cvterms\Owner;

use App\Models\Breeding\Cvterms\Usescheduleterm;

use App\Models\Breeding\Colony\Litter;
use App\Models\Breeding\Colony\Mating;
use App\Models\Breeding\Colony\Mouse;
use App\Models\Breeding\Cvterms\CVGeneration;

// all traits here
use App\Traits\Breed\BContainer;
use App\Traits\Breed\BCVTerms;
//use App\Traits\Breed\BMatingSearch;
//use App\Traits\Breed\BManageLitter;
use App\Traits\Breed\BOpenLitterSearch;

use Illuminate\Support\Facades\Route;

class LitterTodb extends Component
{
		use BOpenLitterSearch;
		use BCVTerms;
		//form messages
		public $iaMessage;

		//panels
		public $panel1 = false, $panel2 = false, $panel3 = false, $panel4 = false;
		
		//compulsory information
		public $speciesName, $speciesKey, $purpose, $matKey, $generations;

		//Model objects
		public $openLitterEntries, $strains, $origins, $owners, $birthStatuses;

		//check boxes
		public $ppidb = false, $agmr = true, $autoDates=true, $femaleFirst = true, $lpimc = false;

		// form variables
		public $litterId_contains, $weanFromDate, $weanToDate, $_generation_key;
		
		public $protocols, $useScheduleTerms, $per_cage=10, $comment;
		public $baseMouseId, $protoKey, $useScheduleKeys;
		public $maleGroup=[], $femaleGroup=[];
		
		//public $origin="EAF-NCCS", $culledAtWean, $missAtWean, $cageId, $litterNum, $femalePerCage, $malePerCage;
		//public $litType=1, $dateBorn, $weanDate, $tagDate, $birthEventStatusKey="A", $coment;

		//public $matingId_contains, $matingId, $strainKey, $spKey, $lifeStatus, $ownerWg, $fromDate, $toDate;
		public $matSearchResults, $searchResultsMating, $mqryResult, $wean_time=0;
		public $fullLitterDetails=[], $matingReferenceID=null, $curLitterKey=null;
		
		public $roomId, $rackId;
		
		public $rooms, $racks;
		public $fslot_num,$free_slots,$racksInRoom=[], $rack_id, $room_id, $slot_id;
		
		//panels

	
	
	public function render()
	{
		//$this->pullAllOpenLitterEntries();
		return view('livewire.breeding.colony.litter-todb');
	}
	
  public function show($id)
	{
		if($id == 1) { $this->speciesName = "Mice"; $this->iaMessage = "Selected Mice"; }
		if($id == 4) { $this->speciesName = "Rat"; $this->iaMessage = "Selected Rat"; }

    $this->purpose = "New";
		$q1 = CVSpecies::where('_species_key', $id)->first();
		$this->generations = CVGeneration::all();
		$this->useScheduleTerms = UseScheduleTerm::all();
		$this->protocols = CVProtocol::where('_species_key', $id)->get();
		$this->speciesKey = $q1->_species_key;
		
		$this->strains = Strain::all();
		$this->rooms = Room::all();
		$this->racks = Rack::all();
		//$this->cageInfos = $this->suggestedCage();
		$this->panel1 = true;
	}	
	
	public function pullAllOpenLitterEntries()
	{

		$this->openLitterEntries = Litter::with('mating')->where('entry_status', 'open')->get();
		//dd($this->openLitterEntries);
    
    $this->panel2 = true;
  }
	
	
	public function pullSelectedLitterEntries()
	{
		dd("selected litter entries");
	}
		
		
	public function	prepareDBEntryData()
	{
	
		$input['exitDate'] = null;
		$input['cod'] = null;  
		$input['codNotes'] = null;
		$input['lifeStatus'] = 'A';
		$input['breedingStatus'] = 'U';
		$input['coatColor'] = NULL; 
		$input['diet'] = NULL;
		$input['owner'] = 'EAF-NCCS';
		$input['origin'] = 'EAF-NCCS';
		$input['sampleVialID'] = null;
		$input['sampleVialTagPosition'] = null;
		$input['version'] = 1;
		$input['cage_id'] = null;
		$input['rack_id'] = null;
		$input['slot_id'] = null;
		$input['_pen_key'] = $input['cage_id'];
		$input['protocol'] = $this->protoKey;
		$f1a['_mouse_key'] = $this->getMaxMouseKey(); // new mouse_key going to be created
		$input['newTag'] = null;
		$input['comment'] = $this->comment;
		
		//dd("reached");		
		$f1a = array();
		$f2a = array();
		$fmales = array();
		$males = array();
		$i = 1;
		
		foreach($this->openLitterEntries as $row)
		{
			$nFmales = $row->numFemale;
			for($x=0; $x < $nFmales; $x++)
			{
				$f1a['ID'] = $this->baseMouseId."-".$i;
				$f1a['RefID'] = $row->mating->matingRefID;
				$f1a['birthDate'] = $row->birthDate;
				$f1a['_litter_key'] = $row->_litter_key;	
				$f1a['sex'] = "M";
				$f1a['_species_key'] = $row->_species_key;
				$f1a['_strain_key'] = $row->_strain_key;
				
				
				$res = array_merge($f1a, $input);
				$i = $i + 1;
				array_push($f2a, $res);
				$f1a = array();
				$res = array();
			}
			
			$nMales = $row->numMale;
			for($x=0; $x < $nMales; $x++)
			{
				$f1a['ID'] = $this->baseMouseId."-".$i;
				$f1a['RefID'] = $row->mating->matingRefID;
				$f1a['birthDate'] = $row->birthDate;
				$f1a['_litter_key'] = $row->_litter_key;
				$f1a['sex'] = "F";
				$f1a['_species_key'] = $row->_species_key;
				$f1a['_strain_key'] = $row->_strain_key;
				
				
				$res = array_merge($f1a, $input);
				$i = $i + 1;
				array_push($f2a, $res);
				$f1a = array();
				$res = array();
			}
		}
		// separate the male group and female groups
		foreach($f2a as $row)
		{
			if($row['sex'] == "M")
			{ 
				array_push($males, $row);
			}
			else {
				array_push($fmales, $row);
			}
		}
		//
		$this->maleGroup = $males;
		$this->femaleGroup = $fmales;
		
		dd($this->maleGroup, $this->femaleGroup);
		$this->panel3 = true;
		
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
