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
use App\Traits\SplitNumberIntoParts;
//use App\Traits\Breed\BManageLitter;
use App\Traits\Breed\BOpenLitterSearch;
use App\Traits\Breed\BAddCageInfo;

use Illuminate\Support\Facades\Route;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class LitterTodb extends Component
{
		use BOpenLitterSearch;
		use BCVTerms;
		use SplitNumberIntoParts;
		use BAddCageInfo;
		
		
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
		public $maleGroup=[], $femaleGroup=[], $numMalesPerCage, $numFemalesPerCage;
		
		public $cagesM, $cagesF, $jsonCagesM, $jsonCagesF;
		
		//public $origin="EAF-NCCS", $culledAtWean, $missAtWean, $cageId, $litterNum, $femalePerCage, $malePerCage;
		//public $litType=1, $dateBorn, $weanDate, $tagDate, $birthEventStatusKey="A", $coment;

		//public $matingId_contains, $matingId, $strainKey, $spKey, $lifeStatus, $ownerWg, $fromDate, $toDate;
		public $matSearchResults, $searchResultsMating, $mqryResult, $wean_time=0;
		public $fullLitterDetails=[], $matingReferenceID=null, $curLitterKey=null;
		
		public $roomId, $rackId;
		
		public $rooms, $racks;
		public $fslot_num,$free_slots,$racksInRoom=[], $rack_id, $room_id, $slot_id;
		
		//panels
		public $slot_error_msg=null;
	
	
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
	
		//standard common info for mouse entries
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
		$input['_pen_key'] = 0;
		$input['protocol'] = $this->protoKey;
		//
		$input['newTag'] = null;
		$input['comment'] = $this->comment;
		$input['generation'] = $this->_generation_key;
		
		//dd("reached");		
		$f1a = array();
		$f2a = array();
		$fmales = array();
		$males = array();
		$i = 1;
		//$input['_mouse_key'] = $this->getMaxMouseKey(); // 
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

		//set the Male and Female arrays
		$this->maleGroup = $males;
		$this->femaleGroup = $fmales;	
		
		//calculate cages required 10 per cage
		$maleCount = count($males);
		$femaleCount = count($fmales);
		
		$this->cagesM = ceil($maleCount/10);
		$this->cagesF = ceil($femaleCount/10);
		
		$this->numMalesPerCage   = $this->splitNumber($maleCount, $this->cagesM); //array
		$this->numFemalesPerCage = $this->splitNumber($femaleCount, $this->cagesF); //array
		
		$this->jsonCagesM = implode(" , ", $this->numMalesPerCage);
		$this->jsonCagesF = implode(" , ", $this->numFemalesPerCage);
		
		//dd($this->maleGroup, $this->femaleGroup);
		$this->panel3 = true;
		
	}
	
	public function putPupsToDB()
	{
		
		/*
		1. This is an irreversible operation once done, done
		2. We have made arrays of mouse info for all males and females
		3. This is stored in $this->maleGroup and $this-femaleGroup.
		4. Ensure Room, Rack, cage and slot infos are already selected
		5. How to split the new mice into number of cages and per cage done above
		6. This info is available in total cages required in $this->cagesM and $this->cagesF
		7. How many to be put into each is available in $this->numMalesPerCage, $this->numFemalesPerCage
		8. Once every array is put into mouse db, that corresponding litter key status to be closed.
		9. $this->openLitterEntries contains the open litter entries in the litter table.
		10. The sequence of operations is very similar to compelte allotment done earlier.
		
			A. Take each array  begin with Females.
				
			B. Take each row (complete mouse info)
				a. create a mice id array for the cage 
				b. Add the rack, cage, slot info to each mouse row.
				c. Create a new Cage
				d. Once the number of mice reached as per cage info array,
						save the cage.
		*/

		$lk = 0;
		for($k=0; $k < $this->cagesF; $k++)
		{
			$mice_idx = array();
			$numberF = $this->numFemalesPerCage[$k];

			for($i=0; $i < $numberF; $i++)
			{
				$miceArrayInfo = $this->femaleGroup[$lk]; //first mice entry in the array
				
				unset($miceArrayInfo['RefID']);
				
				array_push($mice_idx, $miceArrayInfo['ID']);
				
				$miceArrayInfo['_mouse_key'] = $this->getMaxMouseKey();
				//perfect untill here.
				//dd($mice_idx, $miceArrayInfo);
				Log::channel('coding')->info('Data collection for [ '.$miceArrayInfo['ID'].'] insert array complete');

				//now insert into db here using try catch to revert if any error
				
				try {
							//$result = Mouse::UpdateOrCreate($miceArrayInfo);
							Log::channel('coding')->info('Mating Id [ '.$miceArrayInfo['ID'].' ] creation success');
				}

				catch (\Illuminate\Database\QueryException $e ) {
                $result = DB::rollback();
                $eMsg = $e->getMessage();
								Log::channel('coding')->info('Entry ID [ '.$eMsg.' ] creation fail');
                //dd($eMsg);
                $result = false;
				}
				
				//before loop restarts, no need to unset the key you are done with
				//as we are using for loop, loop will pick running index value
				$lk = $lk + 1;
			}
			
			//dd($mice_idx);
			$miceArrayInfo['animal_count'] = $numberF;
			$miceArrayInfo['mice_ids'] = $mice_idx;
			$miceArrayInfo['rack_id'] = $this->rack_id;
			$miceArrayInfo['slot_id'] = $this->slot_id;
			
			$result = $this->updateRackSlotCageInfo($miceArrayInfo);
			//before the loop goes back
			//prepare for cage insertion
			unset($this->rarray[0]);
			$this->mice_idx = [];
			if(count($this->rarray) != 0)
			{
				$this->rarray = array_values($this->rarray);
				$this->slot_id = $this->rarray[0];
			}
			else {
				$this->slot_error_msg = "Select New Rack";
			}
		}
		
		
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
