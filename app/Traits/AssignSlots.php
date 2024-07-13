<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Issue;
use App\Models\Slot;
use App\Models\Cage;

use App\Traits\Base;
use App\Traits\Notes;


trait AssignSlots
{
  use Base;

  use Notes;

  /*
    slot assignment has the following steps
    1. collect cage, strain info and put in cages table with status active
    2. create as many cages sanctioned, put them slots table.
    3. the above 2 should complete the action
  */
  public function slotAssignment($input)
  {
    $result = false;

    $issue_Ids = $input['issue_id']; //all ids checked in the form;

    //corresponding racks selected in the form;
    //remove here zero containing array elements
    $rack_Ids = array_filter($input['rack_id']);
    //remove here zero containing array elements

    //the number of cages issued to issue_id;
    $cagenums = array_filter($input['number']);

    foreach($issue_Ids as $val)
    {
      $issue_id = $val;
      $projectInfo = Issue::where('issue_id', $issue_id)->first();
      $res = Slot::where('rack_id', $rack_Ids[$issue_id])
                        ->where('status', 'A')
                        ->count('status');
      $reqCageNumbers = $cagenums[$issue_id];
      if($res > $reqCageNumbers)
      {
        for($i=1; $i<$reqCageNumbers+1; $i++)
        {
          // gather data for cages table
          $cageInfo = new Cage();
          $cageInfo->issue_id = $issue_id;
          $cageInfo->project_id = $projectInfo->project_id;
          $cageInfo->requested_by = $projectInfo->pi_id;
          $cageInfo->species_id = $projectInfo->species_id;
          $cageInfo->strain_id = $projectInfo->strain_id;
          $cageInfo->start_date = date('Y-m-d');
          $cageInfo->end_date = date('Y-m-d');
          $cageInfo->ack_date = date('Y-m-d');
          $cageInfo->cage_status = 'Active';
          $cageInfo->notes = 'Cage Issued';

          $cageInfo->save();

          $cage_id = $cageInfo->cage_id;
          //save in cages table

          // collect data for slots table
          $sInput['rack_id'] = $rack_Ids[$issue_id];
          $sInput['cage_id'] = $cage_id;
          $sInput['status'] = "O";
          $res = Slot::where('rack_id', $sInput['rack_id'])
                        ->where('status', 'A')
                        ->first();
          $res = Slot::where('slot_id', $res->slot_id)->update($sInput);
          $result = true;
        }
        $issue = new Issue();
        $sql['issue_status'] = "issued";
        $resx = Issue::where('issue_id', $issue_id)->update($sql);
      }
      else {
        return $result;
      }
    }
    return $result;
  }
}
