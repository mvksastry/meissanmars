<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Group;
use App\Models\Assent;
use App\Models\Project;

trait Groups
{
  /**
   * Check file validity and move to uploads folder
   *
   * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
   * @return boolean
   */
  public function addPiGroupMember($input)
  {
    //first check if he is already a member of this

    $qr = Group::where('pi_id', $input['pi_id'])
                  ->where('member_id', $input['group_user_id'])
                  ->count();

    if($qr == 0)
    {

      $newMember = new Group();

      $newMember->pi_id = $input['pi_id'];
      $newMember->member_id = $input['group_user_id'];
      $newMember->save();
      //now change the user status in users table to
      //$userRoleUpdate = User::find($input['group_user_id']);
      //$userRoleUpdate->role = "researcher";
      //$userRoleUpdate->save();
      return true;
    }
    else {
      //this means user is already
      // a member of the group
      return false;
    }
  }

  public function processGroupUserUpdate($input)
  {
    //separate the user id, project id and validity information
    $piId = $input['pi_id'];
    $userIds = $input['user_id'];
    $projectIds = $input['project_id'];

    //unset unwanted stuff from the array
    unset($input['_token']);
    unset($input['pi_id']);
    unset($input['user_id']);
    unset($input['project_id']);

    //safe keeping of the input
    $nbx = $input;

    //remove null values
    foreach($input as $key => $val)
    {
      if($val == null){
        unset($input[$key]);
      }
    }

    //add member to group.
    foreach($userIds as $userId)
    {
      $ia['pi_id'] = $piId;
      $ia['group_user_id'] = intval($userId);
      $res = $this->addPiGroupMember($ia);
    }

    //next clean-up the input tags coming
    //from formd fields.

    $te1 = array();
    $te2 = array();

    foreach($input as $key => $val)
    {
      if (substr($key, 0, 3) === 'val')
      {
        $vx = str_replace("validity_", '', $key);
        $te1[$vx] = $val;
      }
      else {
        $xv = str_replace("nba_", '', $key);
        $te2[$xv] = $val;
      }
    }

    // now prepare the data for db assent.
    $te3= array();
    foreach($te2 as $key => $val)
    {
      if(in_array($key, $projectIds))
      {
        $xdf  = explode('_', $key);
        $dfx = $te2[$key];
        $nba = explode('_', $dfx);
        $fin['project_id'] = intval($xdf[1]);
        $fin['allowed_id'] = intval($xdf[0]);
        $fin['start_date'] = date('Y-m-d');
        $fin['end_date'] = $te1[$key];

        if( intval($nba[1]) === 1){
          $fin['tablename'] = $fin['project_id'].'formd';
        }
        else{
          $fin['tablename'] = 'NULL';
        }
        $fin['status'] = 1;
        array_push($te3, $fin);
        $fin = array();
      }
      else
          {
        unset($te2[$key]);
      }
    }

    //the te2 is final for insertion into db.

    //dd($piId, $userIds, $projectIds, $te3);
    //first check whether the valid date is ealier than project
    //end date or not. if later ignore.

    $projInf = Project::where('pi_id', $piId)->first();

    //now loop through the $te3 and add to the db through the trait

    foreach($te3 as $input)
    {
      if( strtotime($projInf->end_date) > strtotime($input['end_date']) )
      {
        //prepare to give assent to the project.
        $res = $this->addMemberToProject($input);
      }
    }

    //add new user

    $add_new_user = "on";
    $fname = $input['fname'];
    $lname = $input['lname'];
    
    $date_valid = $input['date_valid'];
    $nba = $input['nunba'];




          //end of addition new user
    return true;
  }


}
