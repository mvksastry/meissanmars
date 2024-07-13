<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Issue;
use App\Models\Slot;
use App\Models\Cage;
use App\Models\Cagenote;
use App\Models\Rack;

use App\Traits\Base;
use App\Traits\Notes;


trait CageTermination
{
  use Base;

  use Notes;

  public function rackOccupancyInfo($id)
  {
    $rackInfo = array();

    $ex = explode('_', $id);
    $rackInfo['cage_id'] = $ex[0];
    $rackInfo['usage_id'] = $ex[1];

    //dd($ex, $rackInfo);

    // get the cages that are having same issue id
    // these are same as shown onthe web page
    $cageIdsx = Cage::where('usage_id', $ex[1])->pluck('cage_id');

    foreach($cageIdsx as $x)
    {
      $cageIdArray[] = $x;
    }

    $ss = Slot::where('cage_id', intval($ex[0]))->first();

    // all slot
    $slotInfo = Slot::where('rack_id', $ss->rack_id)->get();

    $ri = Rack::where('rack_id', $ss->rack_id)->first();

    $rackInfo['rack_id'] = $ss->rack_id;
    $rackInfo['rows'] = $ri->rows;
    $rackInfo['cols'] = $ri->cols;
    $rackInfo['levels'] = $ri->levels;
    $rackInfo['rackName'] = $ri->rack_name;

    $cageIds = Slot::where('rack_id', $ss->rack_id)->get();

    foreach($cageIds as $val)
    {
      if(in_array($val->cage_id, $cageIdArray))
      {
        $info['slot_id'] = $val->slot_id;
        $info['cage_id'] = $val->cage_id;
        $info['status'] = $val->status;
        array_push($rackInfo, $info);
        $info = array();
      }
      else {
        $info['slot_id'] = $val->slot_id;
        $info['cage_id'] = 0;
        $info['status'] = "o";
        array_push($rackInfo, $info);
        $info = array();
      }
    }
    return $rackInfo;
  }
}
