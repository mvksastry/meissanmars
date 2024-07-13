<?php

namespace App\Livewire\Usage;

use Livewire\Component;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Cage;
use App\Models\Usage;
use App\Models\Occupancies;
use App\Models\Project;
use App\Models\Projectstrains;
use App\Models\Rack;
use App\Models\Slot;
use App\Models\Species;
use App\Models\Strain;
use App\Models\User;
use App\Models\Cagenote;

use App\Traits\Base;
use App\Traits\IssueRequest;
use App\Traits\StrainConsumption;
use App\Traits\ProjectStrainsById;
use App\Traits\CageTermination;
use App\Traits\IssueRequestQueries;
use App\Traits\CageInspections;

use Validator;


class IaecUsage extends Component
{
    use ProjectStrainsById;
    use IssueRequest;
    use CageTermination;
    use IssueRequestQueries;
    use CageInspections;


    public $irqMessage;

    public $iaecproject_id,$usage_id, $psbi1;

    public $strain_name, $sex, $age, $ageunit, $number, $cagenumber;
    public $termination, $products, $remarks, $status_date;
    public $issue_status, $created_at, $updated_at, $psbi, $agree;
    public $duration, $duration_unit, $expt_desc;
    
    public $updateMode = false, $cageInfo, $cageAndLayout;

    public $rack_id, $cage_id, $ro_own, $slots, $occups, $rackInfo, $slotInfo, $layoutPiCage;

    public $cageTerm, $selCage, $markedCages, $cageDetailsPi, $caInfos;

    public $appearance, $numdead, $moribund, $housing, $xyz, $notes;

    public $transferCage, $animalnum, $cagenum, $racknum;

    public $cageInduction, $issInfos, $slotInfos, $cagesRequired;


    public function render()
    {
        if( Auth::user()->hasAnyRole('pisg','pient','investigator') )
        {
            if($this->cageInduction)
            { //find empty slots from slot table groupby rack id
              $this->slotInfos = Slot::where('status', 'A')->groupBy('rack_id')
                                  ->selectRaw('count(*) as total, rack_id')
                                  ->get();
            }
            $issueReqs = Usage::with('strain')->where('pi_id', Auth::id())->get();
        }

        if( Auth::user()->hasRole('researcher') )
        {
            $issueReqs = $this->issueRequestsAllowed();
            if($this->cageInduction)
            {
              //find empty slots from slot table groupby rack id
              $this->slotInfos = Slot::where('status', 'A')->groupBy('rack_id')
                                  ->selectRaw('count(*) as total, rack_id')
                                  ->get();
            }
        }

        if( Auth::user()->hasRole('facility_help') )
        {
            $issueReqs = $this->issueRequestsAllowed();
        }

        if( Auth::user()->hasRole('veterinarian') )
        {
            $issueReqs = $this->issueRequestsAllowed();
        }

        //return view('livewire.issues')->with(['issueReqs'=>$issueReqs]);
        return view('livewire.usage.iaec-usage')->with(['issueReqs'=>$issueReqs]);

        //return view('livewire.usage.iaec-usage');
    }
    
    private function resetInputFields()
  	{
  		$this->title = '';
  	}

  	public function update($id)
  	{
  		$this->updateMode = true;
  	}

  	public function edit($id)
  	{
      $this->irqMessage = "";
      $this->updateMode = true;
      $issueReq = Usage::with('strain')->where('usage_id', $id)->first();
      $this->usage_id = $id;
      $this->iaecproject_id = $issueReq->iaecproject_id;
      $this->strain_name = $issueReq->strain->strain_name;

      $this->sex = $issueReq->sex;
      $this->age = $issueReq->age;
      $this->ageunit = $issueReq->ageunit;
      $this->number = $issueReq->number;
      $this->cagenumber = $issueReq->cagenumber;
      $this->termination = $issueReq->termination;
      $this->duration = $issueReq->duration;
      $this->duration_unit = $issueReq->duration_unit;
      $this->expt_desc = $issueReq->expt_desc;
      $this->products = $issueReq->products;
      $this->remarks = $issueReq->remarks;
      $this->issue_status = $issueReq->issue_status;
      $this->status_date = $issueReq->status_date;

      $this->psbi = $this->fetchProjectStrainsById($issueReq->iaecproject_id);
  	}

  	public function store()
  	{
      $this->irqMessage = "";
      $this->irqMessage = "Welcome, Pay attention to fields";

      $ps = $this->psbi1;
      $this->validate(['psbi1' => 'required']);
      $xs = explode(";", $ps);
      $input['species_id'] = $xs[0];
      $input['strain_id'] = $xs[1];

      $input['usage_id'] = $this->usage_id;
      $input['project_id'] = $this->iaecproject_id;
      $input['pi_id'] = Auth::id();
      $input['sex'] = $this->sex;
      $this->validate(['sex' => 'required|alpha']);

      $input['age'] = $this->age;
      $this->validate(['age' => 'required']);

      $input['ageunit'] = $this->ageunit;
      $this->validate(['ageunit' => 'required|alpha']);

      $input['number'] = $this->number;
      $this->validate(['number' => 'required|numeric']);

      $input['cagenumber'] = $this->cagenumber;
      $this->validate(['cagenumber' => 'required|numeric']);

      $input['termination'] = $this->termination;
      $this->validate(['termination' => 'required|regex:/^[\pL\s\- ;0-9_]+$/u|max:150']);

      $input['duration'] = $this->duration;
      $this->validate(['duration' => 'required|regex:/^[0-9]+$/u|max:52']);
      
      $input['expt_desc'] = $this->expt_desc;
      $this->validate(['expt_desc' => 'required|regex:/^[\pL\s\- .,;0-9_]+$/u|max:500']);
 
      $input['products'] = $this->products;
      $this->validate(['products' => 'required|regex:/^[\pL\s\- ,;0-9_]+$/u|max:150']);

      $input['remarks'] = $this->remarks;
      $this->validate(['remarks' => 'required|regex:/^[\pL\s\- ,;0-9_]+$/u|max:150']);

      $input['agree'] = $this->agree;
      $this->validate(['agree' => 'required:numeric']);

      $input['status_date'] = date('Y-m-d');
      //now post to trait because, everything is ok
      // and get it posted after verification of strain balance.
      $result = $this->postIssueRequest($input);

		if($result){
			$msg = "Issue Request Edited Successfully";
			$this->irqMessage = $msg;
		}
		else {
			$msg = "Issue Request Edit Failed, Contact Admin";
			$this->irqMessage = $msg;
		}

		$this->updateMode = false;
  	}

  	public function cages($id)
  	{
      $this->usage_id = $id;
      $this->cageInfo = Cage::with('slots')
                ->where('usage_id', $id)
                ->get();
      $this->updateMode = false;
      $this->cageDetailsPi = false;
      $this->layoutPiCage = false;
      $this->cageAndLayout = true;
  	}

  	public function location($id)
  	{
      $this->rackInfo = "";
      $ex = explode('_', $id);
      $this->cage_id = $ex[0];
      $this->rackInfo = $this->rackOccupancyInfo($id);
      $this->cageDetailsPi = false;
      $this->layoutPiCage = true;
      $this->transferCage = false;
  	}

  	public function markCages($id)
  	{
      $this->cageTerm[] = $id;
      $this->selCage = $this->selCage.$id.";";
      $this->markedCages = $this->selCage;
  	}

  	public function clearMarkedCages()
  	{
      $this->selCage = "";
      $this->markedCages = "";
  	}

  	public function cageDetails($id)
  	{
      $exp = explode('_', $id);
      $cage_id = $exp[0];
      $usage_id = $exp[1];
      $this->irqMessage = "Cage Selected is: ".$id;
      $caInfos = Cage::with('user')
              ->with('strain')
              ->where('cage_id', $id)->get();
      $this->caInfos = $caInfos;
      $this->layoutPiCage = false;
      $this->cageDetailsPi = true;
      $this->transferCage = false;
  	}

  	public function terminateCages()
  	{

      $ids = array_filter(explode(";",$this->markedCages));
		
      //now loop through the array, and make the
      //process the cage details.

      foreach($ids as $val)
      {
        //get cage id info

        $cageIdInfo = Cage::where('cage_id', intval($val))->first();

        $cageIdInfo->end_date = date('Y-m-d');
        $cageIdInfo->ack_date = date('Y-m-d');
        $cageIdInfo->cage_status = "Finished";
        $cageIdInfo->notes = "Cage removed";

        $cageIdInfo->save();
        //dd($cageIdInfo);

        $slotInfo = Slot::where('cage_id', intval($val))->first();

        $slotInfo->cage_id = 0;
        $slotInfo->status = 'A';

        $slotInfo->save();
      }
  	}

  public function cageSurveillance($cage_id)
  {
    $this->postCageInspectionReport($cage_id);
  }
  
  /*
  	public function postCageObservations($idcg)
  	{
      $cageIdInfo = Cage::where('cage_id', intval($idcg))->first();

      //$cnInfo = Cagenote::where('cage_id', intval($idcg))->get();

      $project_id = $cageIdInfo->project_id;

      $table = $project_id."notebook";

      $cnotes = "";

      $appearance = $this->appearance;

      $numdead  = $this->numdead;
      $moribund = $this->moribund;
      $housing  = $this->housing;
      $xyz      = $this->xyz;
      $notes    = $this->notes;

      if($numdead > 0)
      {
        $cageIdInfo->animal_number = $cageIdInfo->animal_number - $numdead;

        $cageIdInfo->save();
        //reduce the animal number by that many
        $cnotes = $cnotes.'[ '.$numdead." ] dead removed;";

        $input['usage_id'] = $cageIdInfo->usage_id;
        $input['cage_id'] = $cageIdInfo->cage_id;
        $input['staff_id'] = Auth::user()->id;
        $input['staff_name'] = Auth::user()->name;
        $input['entry_date'] = date('Y-m-d');
        $input['protocol_id'] = 0;
        $input['expt_date'] = date('Y-m-d');
        $input['expt_description'] = "Cage observation: [ ".$numdead." ] dead, removed";
        $input['authorized_person'] = "PI";
        $input['signature'] = "Auto Entry-Signed";
        $input['remarks'] = "none";

        $result = DB::table($table)->insert($input);
      }

      if($moribund > 0)
      {
        //reduce the animal number by that many
        //$cageIdInfo->animal_number = $cageIdInfo->animal_number - $moribund;
        $cnotes = $cnotes.'[ '.$moribund." ] moribund state removed;";
      }

      if($housing)
      {
        $cnotes = $cnotes."Cage changed with new bedding;";
      }

      if($xyz)
      {
        $cnotes = $cnotes."Xyz;";
      }

      if($notes != "")
      {
        $notes = $cnotes.$notes;
      }

      $res = Cagenote::updateOrCreate(
            ['cage_id' => intval($idcg),
            'date' => date('Y-m-d'),
            'posted_by' => Auth::user()->name,
            'notes'=>$notes]);
      
      $this->resetCageObservations();
      $this->cageDetailsPi = false;
  	}


  	public function resetCageObservations()
  	{
      $this->numdead = "";
      $this->moribund = "";
      $this->housing = "";
      $this->xyz = "";
      $this->notes = "";
  	}
*/



  	public function transferToNewCage($idxz)
  	{
      $exp = explode('_', $idxz);
      $cage_id = $exp[0];
      $usage_id = $exp[1];
      $this->irqMessage = "Cage Selected is: ".$idxz;
      $caInfos = Cage::with('user')
              ->with('strain')
              ->where('cage_id', $cage_id)->get();
      $this->caInfos = $caInfos;
      $this->layoutPiCage = false;
      $this->transferCage = true;
      $this->cageDetailsPi = false;
  	}

  	public function updatedAnimalnum()
  	{
      $anNum = $this->animalnum;

      $issInfos = $this->issInfos[0];

      $number = $issInfos->number;

      if($anNum > 0)
      {
          $quotient = (int)($number / $anNum);
          $remainder = $number % $anNum;

          if($number >= $anNum)
          {
          if($remainder > 0)
          {
            $addval = 1;
          }
          else{
            $addval = 0;
          }
              $this->cagesRequired = $quotient + $addval;
          }
          else {
            $this->cagesRequired = "Exceeded Required Number";
          }

      }
      else {
        $this->cagesRequired = "Minimum 1 per cage";
      }

  	}

  	public function inductRequiredCages($id)
  	{
      $usage_id = $id;

      $is = Issue::with('user')
            ->with('strain')
            ->where('usage_id', $id)
            ->get();

      $isInfx = $is[0];

      //make notebook table name
      $table = $isInfx->project_id.'notebook';

      //we need to do same procedure as addNewCages mentioned
      //below.

      //process begins only when both racks combined has
      // more vacant places if not just throw a message.
      $cageNumberNeeded = $this->cagesRequired;
      $rackIdSelected = $this->racknum;
      $maxAnimNumber = $this->animalnum;
      $inNotes = $this->notes;

      //we need to make entries in 4 tables;
      // 1. issue table, change status as issued.
      // 2. inser into cages table the details.
      // 3. insert into slot table for location
      // 4. insert into projects notebook.

      //table 1. issues table.
      $isInfx->issue_status = "issued";
      $isInfx->cagenumber = $cageNumberNeeded; //reflects actual number issued
      $isInfx->save();

      $totalInducted = 0;

  		for($i=0; $i < $cageNumberNeeded; $i++)
  		{
        //table 2. Cages table
        $newCage = new Cage();

        $newCage->usage_id = $isInfx->usage_id;
        $newCage->project_id = $isInfx->project_id;
        $newCage->requested_by = Auth::user()->id;
        $newCage->species_id = $isInfx->species_id;
        $newCage->strain_id = $isInfx->strain_id;
        $newCage->animal_number = $maxAnimNumber;
        $newCage->start_date = date('Y-m-d');
        $newCage->end_date = date('Y-m-d');
        $newCage->ack_date = date('Y-m-d');
        $newCage->cage_status = 'Active';
        $newCage->notes = "Mice inducted; ".$inNotes;
        //ready for saving
        $newCage->save();
        //dd($newCage);

        //table 3. Slots table
        $vacantFirst = Slot::where('rack_id', $rackIdSelected)
                        ->where('status', 'A')
                        ->first();

        $vacantFirst->cage_id = $newCage->cage_id;
        $vacantFirst->status = 'O';
        $vacantFirst->save();

        //table 3. project notebook table
        $inNew['usage_id'] = $isInfx->usage_id;
        $inNew['cage_id'] = $newCage->cage_id;
        $inNew['staff_id'] = Auth::user()->id;;
        $inNew['staff_name'] = Auth::user()->name;
        $inNew['entry_date'] = date('Y-m-d');
        $inNew['protocol_id'] = 0;
        $inNew['number_animals'] = $maxAnimNumber;
        $inNew['expt_date'] = date('Y-m-d');
        $inNew['expt_description'] = "[ ".$maxAnimNumber." ] inducted; ".$inNotes;
        $inNew['authorized_person'] = "PI";
        $inNew['signature'] = "Auto entry";
        $inNew['remarks'] = "None";

        $resNew = DB::table($table)->insert($inNew);

        $totalInducted = $totalInducted + $maxAnimNumber;

        if( ($isInfx->number - $totalInducted ) < $maxAnimNumber)
        {
          $maxAnimNumber = $isInfx->number - $totalInducted;
        }
  		}
      //the above are part of the for loop.
      $this->resetInductionForm();
      $this->cageInduction = false;
  	}

  	public function resetInductionForm()
  	{
      $this->animalnum = "";
      $this->racknum = "";
      $this->notes = "";
  	}

  	public function addNewCages($id)
  	{
      $this->irqMessage = "Usage Id Selected is: ".$id;

      $this->issInfos = Usage::with('user')
                  ->with('strain')
                  ->where('usage_id', $id)
                  ->get();

      //dd($this->merged);
      //$this->layoutPiCage = false;
      $this->cageInduction = true;
  	}

  	public function enterNewCage($idz)
  	{
      $cage_id = $idz;
      $numAnimals = $this->animalnum;
      //$numCages = $this->cagenum;
      $numCages = 1;
      $notes = $this->notes;

      $caInfos = Cage::with('user')
                      ->with('strain')
                      ->where('cage_id', $cage_id)->first();

      //first look for empty space in the same rack
      //for the number of cages required.

      //if present allocate them, it not look
      //for slots table find the slots and allot them.

      //query the slot table for rack id. in that rack
      // look for first available empty slot.

      $rackId = Slot::where('cage_id', $cage_id)->first();

      //specific rack based availability. Change this whole
      //rack availability
      $emptyCount = Slot::where('rack_id', $rackId->rack_id)
                          ->where('status', 'A')
                          ->count();

      if( $emptyCount > $numCages )
      {
        for($i=0; $i < $numCages; $i++)
        {
        //first increase the cage count number in issue table also.
        $caInfos->cagenumber = $caInfos->cagenumber + $numCages;
        $caInfos->save();
        $vacantFirst = Slot::where('rack_id', $rackId->rack_id)
                        ->where('status', 'A')
                        ->first();
        $newCage = new Cage();
        $newCage->usage_id = $caInfos->usage_id;
        $newCage->project_id = $caInfos->project_id;
        $newCage->requested_by = Auth::user()->id;
        $newCage->species_id = $caInfos->species_id;
        $newCage->strain_id = $caInfos->strain_id;
        $newCage->animal_number = $this->animalnum;
        $newCage->start_date = date('Y-m-d');
        $newCage->end_date = date('Y-m-d');
        $newCage->ack_date = date('Y-m-d');
        $newCage->cage_status = 'Active';
        $newCage->notes = "Transferred From Cage Id ".$cage_id.";".$notes;
        //ready for saving
        $newCage->save();
        //dd($newCage);

        //make slot change identified above
        $vacantFirst->cage_id = $newCage->cage_id;
        $vacantFirst->status = 'O';
        $vacantFirst->save();
        //alter the cages table for current number
        $caInfos->animal_number = $caInfos->animal_number - $this->animalnum;

        $caInfos->save();

        //make notebook entry
        $table = $caInfos->project_id.'notebook';

        $inOld['usage_id'] = $caInfos->usage_id;
        $inOld['cage_id'] = $cage_id;
        $inOld['staff_id'] = Auth::user()->id;;
        $inOld['staff_name'] = Auth::user()->name;
        $inOld['entry_date'] = date('Y-m-d');
        $inOld['protocol_id'] = 0;
        $inOld['number_animals'] = $caInfos->animal_number - $this->animalnum;
        $inOld['expt_date'] = date('Y-m-d');
        $inOld['expt_description'] = "[ ".$this->animalnum." ] Transferred to Cage Id ".$newCage->cage_id."; ".$notes;
        $inOld['authorized_person'] = "PI";
        $inOld['signature'] = "Auto entry";
        $inOld['remarks'] = "None";

        $resOld = DB::table($table)->insert($inOld);

        $inNew['usage_id'] = $caInfos->usage_id;
        $inNew['cage_id'] = $newCage->cage_id;
        $inNew['staff_id'] = Auth::user()->id;;
        $inNew['staff_name'] = Auth::user()->name;
        $inNew['entry_date'] = date('Y-m-d');
        $inNew['protocol_id'] = 0;
        $inNew['number_animals'] = $this->animalnum;
        $inNew['expt_date'] = date('Y-m-d');
        $inNew['expt_description'] = "[ ".$this->animalnum." ] Transferred From Cage Id ".$cage_id."; ".$notes;
        $inNew['authorized_person'] = "PI";
        $inNew['signature'] = "Auto entry";
        $inNew['remarks'] = "None";

        $resNew = DB::table($table)->insert($inNew);
        }
      }
      else {
        $this->irqMessage = "Not Eough Vacant Slots";
      }
      $this->resetTransferForm();
      $this->transferCage = false;
  	}

  	public function resetTransferForm()
  	{
      $this->animalnum = "";
      $this->cagenum = "";
  	}
////////
}
