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
use App\Traits\Breed\BLitterToMating;
use App\Traits\Breed\BOpenLitterSearch;
use App\Traits\Breed\BAddCageInfo;
use App\Traits\Breed\BPutPupsToDB;
use App\Traits\CageInfoUpdate;

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
		use BPutPupsToDB;
		use BLitterToMating;
		use CageInfoUpdate;
		
		//form messages
		public $iaMessage, $mpairErrorMessage = null;

		//panels
		public $panel1 = false, $panel2 = false, $panel3 = false, $panel4 = false;
		public $panel5 = false, $panel6 = false;
		
		//compulsory information
		public $speciesName, $speciesKey, $purpose, $matKey, $generations;

		//Model objects
		public $openLitterEntries, $strains, $origins, $owners, $birthStatuses;

		//check boxes
		public $ppidb = false, $agmr = true, $autoDates=true, $femaleFirst = true, $lpimc = false;

		// form variables
		public $litterId_contains, $weanFromDate, $weanToDate, $_generation_key, $nm_gen_key;
		
		public $protocols, $useScheduleTerms, $per_cage=10, $comment;
		public $baseMouseId, $protoKey, $useScheduleKeys;
		public $maleGroup=[], $femaleGroup=[], $numMalesPerCage, $numFemalesPerCage;
		public $cage_label, $mpairs=[], $fpairs=[];
		
		public $cagesM, $cagesF, $jsonCagesM, $jsonCagesF;
		
		public $matingId, $strainKey, $ownerWg;
		
		//public $origin="EAF-NCCS", $culledAtWean, $missAtWean, $cageId, $litterNum, $femalePerCage, $malePerCage;
		//public $litType=1, $dateBorn, $weanDate, $tagDate, $birthEventStatusKey="A", $coment;

		//public $matingId_contains, $matingId, $strainKey, $spKey, $lifeStatus, $ownerWg, $fromDate, $toDate;
		public $matSearchResults, $searchResultsMating, $mqryResult, $wean_time=0;
		public $fullLitterDetails=[], $matingReferenceID=null, $curLitterKey=null;
		
		public $roomId, $rackId, $rarray=[];
		
		public $rooms, $racks;
		public $fslot_num,$free_slots,$racksInRoom=[], $rack_id, $room_id, $slot_id;
		
		//panels
		public $slot_error_msg=null, $error_box=[], $success_box=[], $msgLTM=[];
	
		//Mating setup panel related variables
		public $mfslot_num = "", $mcageInfos = null, $mfree_slots = null, $mroom_id = null;
		public $mrack_id = null, $mslot_id=null, $mracksInRoom=[], $mrarray=[], $msaaray=[];
		
		public $femalePartner = false, $malePartner = false, $dspair=[];
		
		//mating form variables
		public $agmatingr=true, $matingRefId, $mating_date;
		public $wean_days = 28, $mgen_key, $wean_note, $mating_comment;
		
		//flags
		public $newMatingFlag = false;
		

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
		//dd($this->rooms);
		$this->panel2 = true;
		
    if(count($this->openLitterEntries) > 0 )
		{
			$this->panel5 = true;
		}
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
			$this->strainKey = $row->_strain_key;
			
			$nFmales = $row->numFemale;
			for($x=0; $x < $nFmales; $x++)
			{
				$f1a['ID'] = $this->baseMouseId."-".$row->mating->matingRefID."-".$i;
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
			
			$nMales = $row->numMale;
			for($x=0; $x < $nMales; $x++)
			{
				$f1a['ID'] = $this->baseMouseId."-".$row->mating->matingRefID."-".$i;
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
		
		//dd($this->maleGroup, $this->femaleGroup);
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
		$this->mpairs = []; 
		$this->fpairs = [];
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
						
			All this lifting is done by the trait BPutPupsToDB.
		*/
		
		//process males first or females just swap the code.
		$mRes = $this->processPupsToDBEntries(
							$this->cagesM, 
							$this->numMalesPerCage, 
							$this->maleGroup, 
							$this->rack_id, 
							$this->rarray
						);

		//remove the slot number already used earlier request
		$this->rarray = array_slice($this->rarray, $this->cagesM);
						
		//process females first or males just swap the code.
		$fRes = $this->processPupsToDBEntries(
							$this->cagesF, 
							$this->numFemalesPerCage, 
							$this->femaleGroup, 
							$this->rack_id, 
							$this->rarray
						);
		//now close the open litter entries status to 
		//closed and status_entry_date to current date
		foreach($this->openLitterEntries as $row)
		{
			//dd($row);
			$matchThese = ['_litter_key' => $row->_litter_key, '_mating_key' => $row->_mating_key];
			$putThese = ['entry_status' => 'closed', 'entry_status_date' => date('Y-m-d') ];
			$result = Litter::where($matchThese)->update($putThese);
			$msgx5 = 'Litter entry staus closed for litter key [ '.$row->_litter_key.' ] ';
			array_push($this->success_box, $msgx5);
			$matchThese = []; $putThese = [];
			
			// now change cage_type from M to W meaning pups present in 
			// the cage
			$slot_index = Mating::where('_mating_key', $row->_mating_key)->value('suggestedPenID');
			$cage_id = Slot::where('slot_index', $slot_index)->value('cage_id');
			$cageInfo = Cage::where('cage_id', $cage_id)->first();
			$cageInfo->cage_type = 'M';
			$cageInfo->save();
		}
	
		//$this->newMatingFlag = true;
		
	}
		
	public function resetDbMatingEntryForm()
	{
		$this->cagesF = null;
		$this->cagesM = null;
		$this->maleGroup = null;
		$this->femaleGroup = null;	
		$this->numMalesPerCage   = null; //array
		$this->numFemalesPerCage = null; //array
		
		$this->jsonCagesM = null;
		$this->jsonCagesF = null;
		$this->protoKey;
		//
		$this->comment = null;
		$this->_generation_key = null;
		$this->rack_id = null; 
		$this->rarray = null;
		$this->rooms = null;
		$this->racks = null;
		
		$this->mating_comment = null;
		$this->mslot_id = null;
		$this->mfslot_num = null;
		$this->mfree_slots = null;
		$this->mrack_id = null;
		$this->mroom_id = null;
		$this->nm_gen_key = null;
		$this->wean_note = null;
		$this->wean_days = null;
		$this->mating_date = null;
		$this->agmatingr = null;
	}

		
	// DB entry related rooms and racks
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
		}
		else {
			$this->fslot_num = "No Free slots in rack";
		}
	}		
		
	public function matingRoomSelected()	
	{
		$this->mfslot_num = "";
		$this->mcageInfos = null;
		$this->mfree_slots = null;
		$this->mracksInRoom = Rack::where('room_id', $this->mroom_id)->get();		
		//dd($this->mracksInRoom);
	}
	
	
	public function matingRackSelected()
	{
		//dd($this->mrack_id);
		$mrack_id = $this->mrack_id;
		$slots = Slot::where('rack_id', $mrack_id)->where('status','A')->get();
		$this->mfree_slots = $slots->count();
		//if no free slots available throw Message
		if($this->mfree_slots > 0)
		{
			$this->msarray = $slots->toArray();
			$this->mrarray = [];
			foreach($this->msarray as $row)
			{
				$this->mrarray[] = $row['slot_id'];
			}
			//check here if the racks for stock and new mating are identical or not
			//if identical remove those slots filled thrugh the db entries.
			if($this->rack_id == $this->mrack_id)
			{
				$totalToBeRemoved = $this->cagesM + $this->cagesF;
				$this->mrarray = array_slice($this->mrarray, $totalToBeRemoved);
			}
			$this->mfslot_num = json_encode(array_slice($this->mrarray, 0, 5, true));
			//dd($rarray, $sarray);
			$this->mcageInfos = $this->mrarray[0];
			$this->mslot_id = $this->mrarray[0];
		}
		else {
			$this->mfslot_num = "No Free slots in rack";
		}		
	}
		
		
	public function prepareMatingEntryData()
	{
			/*
			1. Take dspairs, for each pair, add all mating table column data 
			2. take all the rest of the data and merge arrays which is the easiest
			3. Then make entries.
			4. Make sure you  retrive mouse keys from mouse table as dam sire keys will
				 not be available immediately. Must put pups first for this operation.
			*/
			$base['purpose'] = "new";
			$base['version'] = 1;
			$base['_mating_key'] = null;
			$base['_species_key'] = $this->speciesKey;
			$base['_matingType_key'] = 1;
			$base['_strain_key'] = $this->strainKey;
			$base['matingID'] = $base['_mating_key'];
			$base['matingRefID'] = null;
			$base['suggestedPenID'] = null;
			$base['generation_key'] = $this->nm_gen_key;
			$base['weanTime'] = $this->wean_days;
			$base['matingDate'] = $this->mating_date;
			$base['retiredDate'] = null;
			$base['generation'] = $this->mgen_key;
			$base['ownerwg'] = "EAF-NCCS";
			$base['weanNote'] = $this->wean_note;
			$base['needsTyping'] = 0;
			$base['comment'] = $this->mating_comment;
			$base['proposedDiet'] = null;
			
			foreach($this->dspair as $row)
			{
				$finalMatArray[] = array_merge($row, $base);
			}
			
			$msg = 'Data collection for mating entries seems to be complete';
			array_push($this->msgLTM, $msg);
			Log::channel('coding')->info($msg);
			
			//dd($finalMatArray);	
			
			foreach($finalMatArray as $val)
			{
				$matingKey = $this->addMatingThroughLitter($val);
				
				//now change mice id cage, rack and slot details in mouse table

				if($matingKey != null )
				{
					$ac = 0; $acid = [];
					if($val['dam1ID'] != null)
					{
						$ac = $ac + 1;
						$acid[] = $val['dam1ID'];
						$dam1Info = Mouse::where('ID', $val['dam1ID'])->first();
						$dam1Cage_id = $dam1Info->cage_id;
						$dam1slot_id = $dam1Info->slot_id;
						$dam1rack_id = $dam1Info->rack_id;
						$rex = $this->updateAnimalNumber($val['dam1ID'], $dam1Cage_id, $dam1slot_id, $dam1rack_id);
					}
					
					if($val['dam2ID'] != null)
					{
						$ac = $ac + 1;
						$acid[] = $val['dam2ID'];
						$dam2Info = Mouse::where('ID', $val['dam2ID'])->first();
						$dam2Cage_id = $dam2Info->cage_id;
						$dam2slot_id = $dam2Info->slot_id;
						$dam2rack_id = $dam2Info->rack_id;
						$rex = $this->updateAnimalNumber($val['dam2ID'], $dam2Cage_id, $dam2slot_id, $dam2rack_id);
					}				
					
					if($val['sireID'] != null)
					{
						$ac = $ac + 1;
						$acid[] = $val['sireID'];
						$sireInfo = Mouse::where('ID', $val['sireID'])->first();
						$sireCage_id = $sireInfo->cage_id;
						$sireslot_id = $sireInfo->slot_id;
						$sirerack_id = $sireInfo->rack_id;
						$rex = $this->updateAnimalNumber($val['sireID'], $sireCage_id, $sireslot_id, $sirerack_id);
					}				
					
					//create the mating cage, a new id is created for the mating
					$newMatingObj = Mating::where('_mating_key', $matingKey)->first();
					$matingRefID = $newMatingObj->matingRefID;
					
					$input['_species_key'] = $newMatingObj->_species_key;
					$input['_strain_key'] = $newMatingObj->_strain_key;
					$input['animal_count'] = $ac;
					$input['mice_ids'] = $acid;
					$input['rack_id'] = $this->mrack_id;
					$input['slot_id'] = $this->mrarray[0];
					$input['cage_type'] = 'M';
					$input['cage_label'] = $matingRefID;
					//dd($input);
					$final_res = $this->updateRackSlotCageInfo($input);
					
					//now update the slot index in the mating table for column suggestedPenID
					$matchThese = ['slot_id' => $this->mrarray[0], 'rack_id' => $this->mrack_id];
					$slot_index = Slot::where($matchThese)->value('slot_index');

					$matchThis = ['_mating_key' => $matingKey];
					$putThis = ['suggestedPenID' => $slot_index];
					$result = Mating::where($matchThis)->update($putThis);
					//now reduce the mice number by the 
					//number transferred to mating cage.
					
					$msg = 'Mating entry for '.json_encode($acid).' seems to be complete';
					array_push($this->msgLTM, $msg);
					Log::channel('coding')->info($msg);
			
					//now remove the slot id from the array for next insertion.
					unset($this->mrarray[0]);
					$this->mrarray = array_values($this->mrarray);
					
				}
			}
			
		$this->resetDbMatingEntryForm();
		
	}		
		
	public function fPartnerSelected()
	{
		$this->femalePartner = true;
		$this->openPanel6();
	}
	
	public function mPartnerSelected()
	{
		$this->malePartner = true;
		$this->openPanel6();
	}	

	public function openPanel6()
	{
		if($this->femalePartner == true && $this->malePartner = true)
		{
			$this->mating_date = date('Y-m-d');
			$this->panel6 = true;
		}
	}
	
	public function prepareMatingSetup()
	{
		$this->dspair = [];
		//prepare the pairs and select them
		$t1=array(); 
		
		$males = $this->mpairs;
		$fmales = $this->fpairs;
		
		if(count($males) == count($fmales))
		{
			foreach($males as $key1 => $row)
			{
				$m = explode("&&", $row);
				//dd($m);
				foreach($fmales as $key2 => $val)
				{
					$f = explode("&&", $val);
					if($m[0] == $f[0])
					{
						$t1['dam1ID'] = $f[1];
						$t1['dam2ID'] = null;
						$t1['sireID'] = $m[1];
						array_push($this->dspair, $t1);
						$t1 = array();
					}
					break;
				}
				unset($fmales[$key2]);
				unset($males[$key1]);
				$t1 = array();
			}
			$this->mpairErrorMessage = "Matching Pairs Found";
		}
		else {
			$this->mpairErrorMessage = "Mismatched Pairs, select equal numbers from Males and females";
		}			
		//dd($this->dspair);
	}

	public function freeSlotsByRackId()
	{
		//dd($this->mrack_id);
		$mrack_id = $this->mrack_id;
		$slots = Slot::where('rack_id', $mrack_id)->where('status','A')->get();
		$this->mfree_slots = $slots->count();
		//if no free slots available throw Message
		if($this->mfree_slots > 0)
		{
			$this->msarray = $slots->toArray();
			$this->mrarray = [];
			foreach($this->msarray as $row)
			{
				$this->mrarray[] = $row['slot_id'];
			}
			$this->mfslot_num = json_encode(array_slice($this->mrarray, 0, 5, true));
			//dd($rarray, $sarray);
			$this->mcageInfos = $this->mrarray[0];
			$this->mslot_id = $this->mrarray[0];
		}
		else {
			$this->mfslot_num = "No Free slots in rack";
		}		
	}
	
	
	
	
}
