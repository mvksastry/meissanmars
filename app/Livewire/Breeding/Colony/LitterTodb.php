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

use App\Models\Breeding\Cvterms\CVProtocol;
use App\Models\Breeding\Cvterms\CVSpecies;

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

use Validator;

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
		public $matingEntryErrorMsg = null, $confirming="false";
		public $confirm1="false", $confirm2="false",$confirm3="false",$confirm4="false";
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
		public $litterId_contains, $weanFromDate, $weanToDate, $_generation_key="F00", $nm_gen_key="F00";
		
		public $protocols, $useScheduleTerms, $per_cage=10, $comment;
		public $baseMouseId, $protoKey, $useScheduleKeys;
		public $maleGroup=[], $femaleGroup=[], $numMalesPerCage, $numFemalesPerCage;
		public $cage_label, $mpairs=[], $fpairs=[];
		
		public $cagesM, $cagesF, $jsonCagesM, $jsonCagesF;
		
		public $matingId, $strainKey, $ownerWg;
		
		public $matSearchResults, $searchResultsMating, $mqryResult, $wean_time=0;
		public $fullLitterDetails=[], $matingReferenceID=null, $curLitterKey=null;
		
		public $rarray, $active_rack_id, $rarray1 = [], $rarray2 = [];
		
		public $rooms, $racks, $racksInRoom1 = [], $racksInRoom2 = [];

		public $room_id1, $room_id2, $rack_id1, $rack_id2, $slot_id1, $slot_id2;
		public $free_slots1, $free_slots2, $fslot_num1, $fslot_num2; 
		
		public $rackIdSlotArray = [];
		public $hideRoom1 = false, $hideRoom2 = false, $hideRack1 = false, $hideRack2 = false;
		
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
		public $showMatingEntryButton = false;
		public $matingGoFlag = false;
		
		//data entry flags
		public $litterUpdateFlag = false;
		public $cageUpdateFlag = false;
		
		//toast message body
		public $body=null;

		protected $rules = [
        'mating_date'         => 'required|date_format:Y-m-d',
				'wean_days'       		=> 'required|numeric',
				'wean_note'           => 'sometimes|nullable|regex:/^[\pL\s\- .,;0-9_]+$/u|max:500',
				'nm_gen_key'          => 'required|regex:/^[\pL\s\- .,;0-9_]+$/u|max:3',
				'mroom_id'            => 'required|numeric',
				'mrack_id'            => 'required|numeric',
				'mslot_id'            => 'required|numeric',
				'mating_comment'      => 'sometimes|nullable|regex:/^[\pL\s\- .,;0-9_]+$/u|max:500',
		]; 
		
		public function cancelEntry()
		{
			$this->confirming = "false";
		}
		
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
			
			if(count($this->openLitterEntries) > 0 )
			{
				$this->per_cage = 10;
				$this->panel5 = true;
			}
		}

    public function prepareDBEntryDataSure()
    {
      $this->confirm1 = "true";
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
					
			$f1a = array();
			$f2a = array();
			$fmales = array();
			$males = array();
			$i = 1;
			//$input['_mouse_key'] = $this->getMaxMouseKey(); // 
			if($this->baseMouseId != null || $this->baseMouseId != "")
			{
				if(count($this->rackIdSlotArray) > 0)
				{ 
					$maxSlotValue = max($this->rackIdSlotArray);
					$maxSlotRack_id = array_search(max($this->rackIdSlotArray), $this->rackIdSlotArray);
					ksort( $this->rackIdSlotArray);
					
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
					$this->sortMalesAndFemales($f2a);
				}
				else{
					$this->body = "Rack Not Selected";
					$this->dispatch('error');
				}
			}
			else {
				$this->body = "Base Mouse ID is Empty";
				$this->dispatch('error');
			}
		}

		public function sortMalesAndFemales($f2a)
		{
			$fmales = array();
			$males = array();
			//dd($f2a);
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
			
			$this->cagesM = ceil($maleCount/$this->per_cage);
			$this->cagesF = ceil($femaleCount/$this->per_cage);
			
			$this->numMalesPerCage   = $this->splitNumber($maleCount, $this->cagesM); //array
			$this->numFemalesPerCage = $this->splitNumber($femaleCount, $this->cagesF); //array
			
			$this->jsonCagesM = implode(" , ", $this->numMalesPerCage);
			$this->jsonCagesF = implode(" , ", $this->numFemalesPerCage);
			
			//dd($this->maleGroup, $this->femaleGroup);
			$this->mpairs = []; 
			$this->fpairs = [];
			$this->panel3 = true;
			$this->panel4 = true;
			$this->body = "For Mating, Select Equal Number of Males & Females";
			$this->dispatch('info');
		}
	
		public function putPupsToDBSure()
		{
			$this->confirm2 = "true";
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
				$totalCagesFM = $this->cagesM + $this->cagesF;
	
				$totalFreeSlots = $this->free_slots1 + $this->free_slots2;

				if($totalFreeSlots > $totalCagesFM)
				{					
					$mRes = $this->processPupsToDBEntries(
									$this->cagesM, 
									$this->numMalesPerCage, 
									$this->maleGroup, 
									$this->rackIdSlotArray
								);
					//remove the slot number already used earlier request
					//$this->rarray = array_slice($this->rarray, $this->cagesM);
								
					//process females first or males just swap the code.
					$fRes = $this->processPupsToDBEntries(
									$this->cagesF, 
									$this->numFemalesPerCage, 
									$this->femaleGroup, 
									$this->rackIdSlotArray
								);
					//remove the slot number already used earlier request
					//$this->rarray = array_slice($this->rarray, $this->cagesF);
					//logging at the end
					$msg = 'At End, Active rack id for mouse DB is [ '.$this->active_rack_id.' ] ';
					Log::channel('coding')->info($msg);
					$msg = 'At End, Active slot id for mouse DB is [ '.$this->rarray[0].' ] ';
					Log::channel('coding')->info($msg);
				}
				else {
					$this->body = "Not Enough Free Slots, Add Rack with slots";
					$this->dispatch('error');
				}					
			//now close the open litter entries status to 
			//closed and status_entry_date to current date
			
			if($this->cageUpdateFlag)
			{
				foreach($this->openLitterEntries as $row)
				{
					//dd($row);
					$matchThese = ['_litter_key' => $row->_litter_key, '_mating_key' => $row->_mating_key];
					$putThese = ['entry_status' => 'closed', 'entry_status_date' => date('Y-m-d') ];
					$result = Litter::where($matchThese)->update($putThese);
					$msgx5 = 'Litter entry staus closed for litter key [ '.$row->_litter_key.' ] ';
					array_push($this->success_box, $msgx5);
					$matchThese = []; $putThese = [];
					
					// now change cage_type from M to W meaning pups present in the cage
					$slot_index = Mating::where('_mating_key', $row->_mating_key)->value('suggestedPenID');
					$cage_id = Slot::where('slot_index', $slot_index)->value('cage_id');
					$cageInfo = Cage::where('cage_id', $cage_id)->first();
					$cageInfo->cage_type = 'M';
					$cageInfo->save();
				}
				//give open flag for mating entries
				$this->showMatingEntryButton = true;
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
			$this->active_rack_id = null; 
			$this->rarray = [];
			$this->room_id1 = null;
			$this->room_id2 = null;
			$this->rack_id1 = null;
			$this->rack_id2 = null;
			
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
			$this->confirming = "false";
			$this->confirm1 = "false";
			$this->confirm2 = "false";
			$this->confirm3 = "false";
			$this->confirm4 = "false";
		}

		// DB entry related rooms and racks
		public function room1Selected()
		{
			$room_id1 = $this->room_id1;
			$this->racksInRoom1 = Rack::where('room_id', $room_id1)->get();
			$this->hideRoom1=true;
		}		
		
		public function rack1Selected()
		{
			$rack_id1 = $this->rack_id1;
			$slots = Slot::where('rack_id', $this->rack_id1)->where('status','A')->get();
			$slotCount = $slots->count();
			//if no free slots available throw Message
			if($slotCount > 0)
			{
				if($this->rack_id1 != $this->rack_id2)
				{
					$this->sarray = $slots->toArray();
					//$this->rarray = [];
					foreach($this->sarray as $row)
					{
						$this->rarray1[] = $row['slot_id'];
					}
					$this->free_slots1 = $slotCount;
					$this->fslot_num1 = json_encode(array_slice($this->rarray1, 0, 5, true));

					$this->slot_id1 = $this->rarray1[0];
					$this->rackIdSlotArray[$this->rack_id1] = $this->rarray1;
					$this->hideRack1=true;
				}
				else {
					$this->body = "Rack Selected: Select Another";
					$this->dispatch('error');					
				}						
			}
			else {
				$this->body = "No Free slots in rack";
				$this->dispatch('error');
			}
		}		

		public function room2Selected()
		{
			$room_id2 = $this->room_id2;
			$this->racksInRoom2 = Rack::where('room_id', $room_id2)->get();
			$this->hideRoom2=true;
		}
		
		public function rack2Selected()
		{
			$rack_id2 = $this->rack_id2;
			$slots = Slot::where('rack_id', $this->rack_id2)->where('status','A')->get();
			$slotCount = $slots->count();
			//if no free slots available throw Message
			if($slotCount > 0)
			{
				if($this->rack_id1 != $this->rack_id2)
				{
					$this->sarray = $slots->toArray();
					$this->rarray2 = [];
					foreach($this->sarray as $row)
					{
						$this->rarray2[] = $row['slot_id'];
					}
					$this->free_slots2 = $slotCount;
					$this->fslot_num2 = json_encode(array_slice($this->rarray2, 0, 5, true));

					$this->slot_id2 = $this->rarray2[0]; 
					$this->rackIdSlotArray[$this->rack_id2] = $this->rarray2;
					$this->hideRack2=true;
				}
				else {
					$this->body = "Rack Selected: Select Another";
					$this->dispatch('error');
				}
			}
			else {
				$this->body = "No Free slots in rack";
				$this->dispatch('error');
			}
			//dd($this->rackIdSlotArray);
		}		
		
		////////////////////////////////////////
		//                                    //
		//                                    //
		//                                    //
		//                                    //
		////////////////////////////////////////

		//Selection and processing of mating side
		public function matingRoomSelected()	
		{
			$this->mfslot_num = "";
			//$this->mcageInfos = null;
			$this->mfree_slots = null;
			$this->mracksInRoom = Rack::where('room_id', $this->mroom_id)->get();		
			//dd($this->mracksInRoom);
		}
	
		public function matingRackSelected()
		{
			//$temp = $this->rackIdSlotArray;
			
			$cageArray = array($this->cagesM, $this->cagesF );
			
			$this->mrarray = [];
			$mrack_id = $this->mrack_id;
			//total cages male + female to be removed for selection
			$totalToBeRemoved = $this->cagesM + $this->cagesF;
			$totalNeeded = $totalToBeRemoved + count($this->dspair);
			
			$freeSlotsTotal = $this->free_slots1 + $this->free_slots2;

			//check here if the racks for stock and new mating are identical or not
			//if identical remove those slots filled thrugh the db entries.
			if(array_key_exists($mrack_id, $this->rackIdSlotArray))
			{
				if($freeSlotsTotal > $totalNeeded)
				{
					foreach($this->rackIdSlotArray as $key => $val1)
					{
						if(count($val1) >= $totalNeeded)
						{
							$this->mrarray[$key] = $val1;
							$this->mrarray[$key] = array_slice($this->mrarray[$key], $totalToBeRemoved);
							break;
						}
						elseif (count($val1) > $totalToBeRemoved)
						{
							$this->mrarray[$key] = $val1;
							$this->mrarray[$key] = array_slice($this->mrarray[$key], $totalToBeRemoved);
							break;								
						}
						else {
							$minVal = min($cageArray);
							$this->mrarray[$key] = $val1;
							
							$this->mrarray[$key] = array_slice($this->mrarray[$key], $minVal);
							unset($cageArray[array_search($minVal, $cageArray)]);
						}
					}
					$this->mrack_id = array_search(max($this->mrarray), $this->mrarray);
					$this->mrarray = $this->mrarray[$this->mrack_id];
					$this->mslot_id = $this->mrarray[0];
					//dd($this->rackIdSlotArray, $cageArray, $this->mrarray);
					$this->mfslot_num = json_encode(array_slice($this->mrarray, 0, 5, true));
					$this->mfree_slots = count($this->mrarray);
					
					$this->matingGoFlag = true;
					$this->body = "Green Flag for Mating Entry, Go";
					$this->dispatch('success');
				}
				else {
					//no slots available for mating set-up
					$this->mfslot_num = "Insufficient Free Slots";
					$this->body = "Insufficient Free Slots in Selected Racks";
					$this->dispatch('error');
				}
			}
			else {
				$slots = Slot::where('rack_id', $mrack_id)->where('status','A')->get();
				$this->mfree_slots = $slots->count();			
				//if no free slots available throw Message
				if($this->mfree_slots > count($this->dspair))
				{
					$this->msarray = $slots->toArray();
					$this->mrarray = [];
					foreach($this->msarray as $row)
					{
						$this->mrarray[] = $row['slot_id'];
					}
					//check here if the racks for stock and new mating are identical or not
					//if identical remove those slots filled thrugh the db entries.
					//if($this->rack_id == $this->mrack_id)
					//{
					//	$totalToBeRemoved = $this->cagesM + $this->cagesF;
					//	$this->mrarray = array_slice($this->mrarray, $totalToBeRemoved);
					//}
					$this->mfslot_num = json_encode(array_slice($this->mrarray, 0, 5, true));
					//dd($rarray, $sarray);
					$this->mslot_id = $this->mrarray[0];
					$this->matingGoFlag = true;
				}
				else {
					$this->mfslot_num = "No Free slots in rack";
					$this->body = "No Free slots in rack";
					$this->dispatch('error');
				}	
			}
		}
		
		public function postMatingEntryDataSure()
		{
			$this->confirm3 = "true";
		}
		
		public function postMatingEntryData()
		{
			/*
			1. Take dspairs, for each pair, add all mating table column data 
			2. take all the rest of the data and merge arrays which is the easiest
			3. Then make entries.
			4. Make sure you  retrive mouse keys from mouse table as dam sire keys will
				 not be available immediately. Must put pups first for this operation.
			*/
			//$this->validate();
			
			//$this->matingGoFlag = false;
			if(count($this->dspair) > 0)
			{
				if($this->matingGoFlag)
				{				
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
					
					$msg = 'Data collection for mating entries complete';
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
							
							$msg = 'Active rack id mating is [ '.$this->mrack_id.' ] ';
							Log::channel('coding')->info($msg);
							$msg = 'Active slot id mating is [ '.$this->mrarray[0].' ] ';
							Log::channel('coding')->info($msg);
							
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
							
							$msg = 'Mating entry for '.json_encode($acid).' completed';
							array_push($this->msgLTM, $msg);
							Log::channel('coding')->info($msg);
					
							//now remove the slot id from the array for next insertion.
							unset($this->mrarray[0]);
							$this->mrarray = array_values($this->mrarray);
						}
					}
					$this->resetDbMatingEntryForm();
					$this->panel2 = false;
					$this->panel5 = false;
					$this->panel6 = false;
					$this->confirm3 = "false";
				}
				else {
					$this->matingEntryErrorMsg = "Please select Room, Rack";
					$this->body = "Please select Room, Rack";
					$this->dispatch('error');
				}
			}
			else {
				$this->matingEntryErrorMsg = "Please select Mating Pairs";
				$this->body = "Please select Mating Pairs";
				$this->dispatch('error');
			}
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
			$matingRefID = Mating::where('_strain_key', $this->strainKey)->max('matingRefID') + 1;
			
			$males = $this->mpairs;  //obtained through check box in the form
			$fmales = $this->fpairs; //obtained through check box in the form
			
			if($males != null && $fmales != null)
			{
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
								$t1['parentID'] = $m[2];
								$t1['mRefID'] = $matingRefID;
								array_push($this->dspair, $t1);
								$t1 = array();
								$matingRefID = $matingRefID + 1;
							}
							break;
						}
						unset($fmales[$key2]);
						unset($males[$key1]);
						$t1 = array();
					}
					$this->mpairErrorMessage = "Matching Pairs Found";
				}
			}
			else {
				//$this->mpairErrorMessage = "Please select Mating Pairs";
				$this->body = "Please select Mating Pairs";
				$this->dispatch('error');
			}			
		}

		/*
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
		*/
}
