<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Group;
use App\Models\Assent;

trait GroupUserProjects
{
  /**
   * Check file validity and move to uploads folder
   *
   * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
   * @return boolean
   */

  public function projectsGroupUsers()
  {
    $lm = array();
    //first get list of group members
    $lo = array(); $lm = array(); $lx = array();

    $gM = $this->groupMembers();

    foreach($gM as $val)
    {
      $lo['member_id'] = $val->member_id;
      $lo['name'] = $val->member->name;

      //do a query in assents table and get project info
      $project = Assent::with('project')->where('allowed_id', $val->member_id)->get();

      if(count($project) != 0) {
        foreach($project as $row)
        {
          $lx['title'] = $row->project->title;
          $lx['proj_end_date'] = $row->project->end_date;
          $lx['tenure_start_date'] = $row->start_date;
          $lx['tenure_end_date'] = $row->end_date;
          $lx['tenure_status'] = $row->status;
          $lx['tablename'] = $row->tablename;

          array_push($lo, $lx);
          unset($lx);
        }

        array_push($lm, $lo);
        unset($lo);
      }
    }
    return $lm;
  }

  //add expiry dates to query
  public function groupMembers()
  {
    return Group::with('member')->where('pi_id', Auth::id())->get();
  }


}
