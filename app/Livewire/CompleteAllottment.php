<?php

namespace App\Livewire;

use Livewire\Component;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;


use App\Models\User;
use App\Models\Usage;
use App\Models\Species;
use App\Models\Strain;
use App\Models\Cage;
use App\Models\Image;
use App\Models\Notebook;
use App\Models\Room;
use App\Models\Rack;
use App\Models\Slot;
use App\Models\B2p;
use App\Models\Project;
use App\Models\Projectstrains;

use App\Models\Breeding\Colony\Mouse;

use App\Traits\Base;
use App\Traits\IssueRequest;

use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;

use Validator;

use App\Traits\Notes;
use App\Traits\FormDEntryAdmin;

class CompleteAllottment extends Component
{
    use Base;
    use WithPagination;
    use IssueRequest;
		use Notes;
		use	FormDEntryAdmin;
	
		//objects for global access
		public $issueRequest;
	
    //alerts
    public $issueWarning = false, $issueSuccess = false;
    public $msg1, $msg2, $msg3, $msg4, $msg5, $msg6, $msg7;

    //mice ids to be issued related
    public $idmice=[], $mice_id=[], $total_mice_selected =0, $mc=0;

    //rack related
    public $racks, $rackid=[], $rack_id, $room_racks, $rackName;
    //room related
    public $rooms, $cages_alloted, $cagesGiven;

    //issue related
    public $issues,$usage_id=null, $issue_id, $iss_id, $issx_id=[];
		
    //public $age, $sex;
    public $srs2, $adr;
    public $updateMode;
    public $showAllotButton;
    public $alotButton=false;
		public $validateButton = false;
    //search form

    public $spcx, $stnx, $adate, $bdate, $xsex;
    public $age, $ageunit, $required_number, $req_cage_number;
    public $sql1 = "select * from mouse ";

    public $sql2, $sql3, $sql4, $sql5, $sql6, $sql7;

    //panels
    public $rackUpdate = false;
    public $layoutRack = false;
		public $cageInfos = false;
		public $irqMessage = "";

    public $rows, $cols, $levels, $rack_info;
    public $caInfos;
    
    public $strain_name;
    
    
    public function render()
    {
        if( Auth::user()->hasAnyRole(['manager','pient','investigator', 'researcher', 'veterinarian']) )
        {
            $this->rooms = Room::all();
            $this->racks = Rack::all();
            //  $roomsR = Room::with('rack')->get();
            //  $racksR = Rack::with('room')->get();
            //$vacant = count(Slot::where('status', 'A')->get());
            $occupied = count(Slot::where('status', 'O')->get());

            //this query also works
            $rackInfos = Slot::with('rack')
                      ->select('rack_id', DB::raw('count(status) as total'))
                      ->where('status', 'A')
                      ->groupBy('rack_id')
                      ->get();
											
						
						
            $this->liveCheckIssId($this->issx_id);
            $this->liveCheckRackId($this->rackid);
            $this->liveCheckedMice($this->idmice);
						$this->total_mice_selected = count($this->idmice);
            //get all approved issues and approved places.
            $this->issues = Usage::with('strain')->where('issue_status', 'approved')->get();
						
            return view('livewire.complete-allottment')
                        ->with('rooms', $this->rooms)
                        ->with('racks', $this->racks)
                        ->with('issues', $this->issues)
                        ->with('rackInfos', $rackInfos);
                        //->with('srs', $mcx);
              
        }
        else {
          return view('livewire.permError');
        }
    }

    public function liveCheckIssId($id)
    {
      $this->iss_id = $id;
    }

    public function liveCheckRackId($id)
    {
      $this->rack_id = $id;
    }
    
    public function liveCheckedMice($idmice)
    {
      $this->mice_id = $idmice;		
			$this->total_mice_selected = count($this->idmice);
    }
		
    public function dbQuery()
    {
      $this->issueWarning = false;
      $this->mc = 0;

      if( $this->spcx != null)
      {
         $this->sql2 = " where _species_key = ".$this->spcx." ";
      }
      if( $this->stnx != null)
      {
         $this->sql3 = " AND  _strain_key = ".$this->stnx."  ";
      }
      if( $this->adate != null)
      {
         $this->sql4 = " AND birthDate BETWEEN  '".$this->adate."'";
      }
      if( $this->bdate != null)
      {
         $this->sql5 = " AND '".$this->bdate."' ";
      }
      if( strtoupper($this->xsex) == "F" || strtoupper($this->xsex) == "M")
      {
         $this->sql6 = " AND sex = '".strtoupper($this->xsex)."' ";
      }
      else {
        $this->sql6 = "";
      }
      
      $this->sql7 = " AND exitDate IS NULL";

      $query = "select * from mouse".$this->sql2.$this->sql3.$this->sql4.$this->sql5.$this->sql6.$this->sql7;
      //dd($query);

      // Test Query for testing UI//take note, it is some how converting lower case mouse to Mouse and 
      //throwing an error.
      /*
      $query = "select * from mouse  where _species_key = 1
                AND  _strain_key = 6
                AND birthDate BETWEEN  '2021-09-15'
                AND '2022-06-26'
                AND exitDate IS NULL ";
      */
      $result = DB::select($query);
      //$result = DB::table('mouse')->select($query); //throwing error in linux not on windows pc
      
      
      $temp = [];
      $this->adr = [];

        if( count($result) != 0 )
        {
            foreach($result as $row){
                $temp["_mouse_key"] = $row->_mouse_key;
                $temp["_species_key"] = $row->_species_key;
                $temp["_strain_key"] = $row->_strain_key;
                $temp["ID"] = $row->ID;
                $temp["birthDate"] = $row->birthDate;
                $temp["sex"] = $row->sex;
                $temp["_pen_key"] = $row->_pen_key;
                $temp["diet"] = $row->diet;
                $temp["origin"] = $row->origin;
                $temp["comment"] = $row->comment;
                array_push($this->adr, $temp);
                $temp=[];
            }
						$this->validateButton = true;
        }
        else {
					$this->validateButton = false;
          //$this->alotButton = false;
          $this->msg1 = "No Query results, refine search criteria ";
          $this->issueWarning = true;
        }
    }


    public function selectForSearch($id)
    {   
        $this->usage_id = $id;
				$this->issx_id = $id;
        $irq = Usage::with('species')
                      ->with('user')
                      ->with('strain')
                      ->where('usage_id', $id)
                      ->first();
				$this->issueRequest = $irq;
        $this->iss_id = $id;
        $this->spcx = $irq->species_id;
        $this->stnx = $irq->strain_id;
        $this->strain_name = $irq->strain->strain_name;
        $this->xsex = $irq->sex;
        $this->age = $irq->age;
        $this->ageunit = substr($irq->ageunit, 0, 1);
				$this->required_number = $irq->number;
        $tDoB = $this->calcTbirthDate();
        $this->adate = date('Y-m-d', strtotime($tDoB) - 3*86400 );
        $this->bdate = date('Y-m-d', strtotime($tDoB) + 3*86400 );
        $this->srs2=null;
        //dd($this->iss_id, $this->spcx, $this->stnx);
        $this->updateMode = true;
    }

		public function doValidation()
		{
			$this->issueWarning = false;
			$ca = $this->cages_alloted;
			
			
			
			
			if( !empty($this->rack_id) )
      {
				$this->msg1 = "The Selected Rack ID: ".$this->rack_id[0];
				$rackId = $this->rack_id[0];
				//dd($this->rack_id);
				if( count($this->idmice) == $this->required_number )
				{	
					$this->msg7=null;
					$this->msg2 = "Total Mice Selected: ".$this->total_mice_selected;
					$freeSlots = $this->rackOccupancy($rackId);
					$issueId = $this->usage_id;
					
					if($issueId != null || $issueId >= 0)
					{
						$this->msg6 = "Issue ID Selected: ".$issueId;
						$irq = Usage::findOrFail($issueId);
						$reqCageNum = $irq->cagenumber;
									
						//dd($this->cages_alloted);
						if($this->cages_alloted > 0)
						{
							$this->cagesGiven = $this->cages_alloted;
						}
						else {
							$this->cagesGiven = $reqCageNum;
						}
									
						if($freeSlots >= $this->cagesGiven)
						{
							$this->msg3 = "Free slots in Rack ".$rackId." are ".$freeSlots.", Need ".$reqCageNum;
							$miceInfos = $this->idmice; // mice keys are here for issue
							if( count($miceInfos) >= $irq->number )
							{
								$this->msg4 = "";
								$this->msg5 = "Total Cages allotted: ".$this->cagesGiven;
								$this->alotButton = true;
							}              
							else {
								$this->msg4 = "Not enough mice selected for issue ";
								$this->issueWarning = true;
							}
						}
						else {
							$this->msg3 = "Not enough free slots in the selected Rack Id ".$rackId;
							$this->issueWarning = true;
						}
					}
					else {
						$this->msg6 = "Issue ID Not Selected ";
						$this->issueWarning = true;
					}
				}
				else {
					$this->msg7 = "Total Mice Selected: ".count($this->idmice);
					$this->msg2 = "Mice Not Selected or Required Mice Number Mismatch ";
				}	
			}
			else {
				$this->msg1 = "Rack Not Selected";
			}
		}

    public function alottComplete($id2x)
    {
			$this->issueWarning = false;
			if( count($this->rack_id) >= 0 )
			{
				if( count($this->idmice) !=0 )
				{
					// now implement the display of allotment button
					// steps as follows:
					// 1. check for numbers Requested
					// 2. check for rack space
					// if both conditions are satisfied, begin allottment
					// through the trait already present. only collect
					// keys of the mice and allott them into cages.
					//$irq = Issue::findOrFail($id);

					//check for space in the rack chosen
					$rackId = $this->rack_id[0];
					$freeSlots = $this->rackOccupancy($rackId);

					//check for number of cages Requested
					//$issueId = $this->issx_id[0];
					$issueId = $this->usage_id;
					$irq = Usage::findOrFail($issueId);
					//$reqCageNum = $irq->cagenumber; //added manual cage number modification.
					$reqCageNum = $this->cagesGiven;
					//dd($issueId, $this->cagesGiven);
					$miceInfos = $this->idmice; // mice keys are here for issue
					$miceInfosJson = json_encode($miceInfos); //convert whole array to json
					$npercage = intdiv($irq->number, $reqCageNum);

					$splitArray = $this->split($irq->number, $reqCageNum);
					array_unshift($splitArray, null);
					unset($splitArray[0]);

					if($freeSlots > $reqCageNum)
					{
						if( count($miceInfos) >= $irq->number )
						{
							for($k=1; $k<$reqCageNum+1; $k++)
							{
								$percage = $splitArray[$k];
								//first get the ids per cage from miceInfos array
								$mids = array_slice($miceInfos, 0, $percage);
								$miceInfos = array_slice($miceInfos, $percage);

								// gather data for cages table
								$cageInfo = new Cage();
								$cageInfo->usage_id = $issueId;
								$cageInfo->iaecproject_id = $irq->iaecproject_id;
								$cageInfo->requested_by = $irq->pi_id;
								$cageInfo->species_id = $irq->species_id;
								$cageInfo->strain_id = $irq->strain_id;
								$cageInfo->animal_number = $percage;
								$cageInfo->start_date = date('Y-m-d');
								$cageInfo->end_date = date('Y-m-d');
								$cageInfo->ack_date = date('Y-m-d');
								$cageInfo->cage_status = 'Active';
								$cageInfo->notes = 'Cage Issued '.json_encode($mids);
								$cageInfo->save();
								$cage_id = $cageInfo->cage_id;

								//now collect data for slots table
								//$sInput['rack_id'] = $rackId;
								$sInput['cage_id'] = $cage_id;
								$sInput['status'] = "O";

								$res = Slot::where('rack_id', $rackId)
															->where('status', 'A')
															->first();
															
								$matchThese = ['slot_id' => $res->slot_id, 'rack_id' => $rackId];
								$res = Slot::where($matchThese)->update($sInput);

								// now change occupancy status from occupied to vacant
								// for the breeding cages here.
								$res = Mouse::whereIn('ID', $mids)
															->update(['exitDate' => date('Y-m-d H:i:s'),
														'comment' => "Issued to project id ".$irq->iaecproject_id ]);
								//dd($percage, $mids, $miceInfos, $cageInfo, $res );
								
								//make notebook entry first time when cages are issued.
								
								$nb = $irq->iaecproject_id."notebook";
								$nbe['usage_id']          = $issueId;
								$nbe['cage_id']           = $cage_id;
								$nbe['protocol_id']       = 0;
								$nbe['av_info']           = "";
								$nbe['number_animals']    = $percage;
								$nbe['staff_id']          = Auth::user()->id;
								$nbe['staff_name']        = Auth::user()->name;
								$nbe['entry_date']        = date('Y-m-d');
								$nbe['expt_date']         = date('Y-m-d');
								$nbe['expt_description']  = 'Cage Issued '.json_encode($mids);
								$nbe['authorized_person'] = $irq->user->name;
								$nbe['signature']         = '[Auto Entry]';
								$nbe['remarks']           = 'Auto Entry by In-charge';                   
								$qry = DB::table($nb)->insert($nbe);
								
							}
							// issue table update
							$irq->issue_status = "issued";
							$irq->save();
							
							// Now implement the Form-D entry here
							//$input['usage_id'] = $issueId;
							//$input['remarks'] = $irq->remarks;
							$result = $this->enterFormD($this->issueRequest);
							
							// B2p table insert
							$nB2p = new B2p();
							$nB2p->species_id = $irq->species_id;
							$nB2p->strain_id = $irq->strain_id;
							$nB2p->issue_id = $issueId;
							$nB2p->number_moved = $irq->number;
							$nB2p->date_moved = date('Y-m-d');
							$nB2p->moved_by = Auth::id();
							$nB2p->moved_ids = $miceInfosJson;
							$nB2p->comment = "moved to project id [ ".$irq->iaecproject_id." ]";
							$nB2p->save();

							// show message and purge all objects.
							
							unset($nB2p);
							unset($irq);
							unset($cageInfo);
							unset($this->adr);
							$this->issueSuccess = true;
							$this->updateMode = false;
						}
						else {
							$this->msg1 = "Not enough mice selected for issue ";
							$this->issueWarning = true;
						}
					}
					else {
						$this->msg1 = "Not enough free slots in the selected Rack Id ".$rackId;
						$this->issueWarning = true;
					}
				}
				else {
					$this->msg1 = "Mice Not Selected ";
					$this->issueWarning = true;
				}
			}
			else {
				$this->msg1 = "Rack Not selected ";
				$this->issueWarning = true;
			}
      // check complete
      //dd($rackId, $this->iss_id, $this->rack_id, $this->issx_id, $this->idmice);
    }

    public function calcTbirthDate()
    {
        $mf = 0;
        if( strtolower($this->ageunit) == "w" )
        {
          $mf = 604800;
        }
        if( strtolower($this->ageunit) == "d")
        {
          $mf = 86400;
        }
        return date('Y-m-d', strtotime(date('Y-m-d')) - (intval($this->age)*$mf));
    }

    //queries
    public function rackOccupancy($id)
    {
      return count(Slot::where('rack_id', $id)->where('status', 'A')->get());
    }

    public function split($x, $n)
    {
        $narray = [];
        // If we cannot split the number into exactly 'N' parts
        if($x < $n){

        }
        else if ($x % $n == 0)
        {
            // If x % n == 0 then the minimum difference is 0 and
            // all numbers are x / n
              for($i = 0; $i < $n; $i++)
              {
                $narray[] = intval($x / $n);
              }
        }
        else
        {
            // upto n-(x % n) the values will be x / n
            // after that the values will be x / n + 1
            $zp = intval($n - ($x % $n));
            $pp = intval($x / $n);
            for ($i = 0; $i < $n; $i++)
            {
                if($i >= $zp)
                {
                    $narray[] = $pp + 1;
                }
                else
                {
                    $narray[] = $pp;
                }
            }
        }
        return $narray;
    }


	public function showRacks($id)
  {
		$this->rackUpdate = true;
		$this->layoutRack = false;
		$this->cageInfos = false;
		$this->irqMessage = "";
		//$this->irqMessage = $id;
		$room = Room::where('image_id', $id)->first();
		$this->room_racks = Rack::where('room_id', $room->room_id)->get();
	}

	public function rackLayout($id)
  {
   
		$this->rackUpdate = true;
		$this->layoutRack = false;
		$this->cageInfos = false;

		$rack_info = array();

		$rackInfos = Rack::where('rack_id', $id)->first();
		$this->rows = $rackInfos->rows;
		$this->cols = $rackInfos->cols;
		$this->levels = $rackInfos->levels;
		$this->rackName = $rackInfos->rack_name;

		$cageIds = Slot::where('rack_id', $id)->get();
    
		foreach($cageIds as $val)
		{
      $info['slot_id'] = $val->slot_id;
      $info['cage_id'] = $val->cage_id;
      $info['status'] = $val->status;
      array_push($rack_info, $info);
      $info = array();
		}

		$this->rack_info = $rack_info;
		$this->layoutRack = true;
	}

	public function cageinfo($id)
	{
		$this->layoutRack = true;
		$this->irqMessage = "Cage Selected is: ".$id;
		$caInfos = Cage::with('user')
						->with('strain')
						->where('cage_id', $id)->get();
		$this->caInfos = $caInfos;
		$this->cageInfos = true;
	}











}
