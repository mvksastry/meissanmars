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


trait CageReshuffle
{
		use Base;
		use Notes;

  public function postCageReshuffleData($data_string)
  {
    $tarr = explode("&", $data_string);
    $r_id = explode("=", $tarr[0]);
    $rack_id = $r_id[1];

    array_shift($tarr);

    $cage_slot_info = array();

    foreach($tarr as $row)
    {
        array_push($cage_slot_info, $row);
    }
    //now using the rack_id, get the rows, cols, levels
    //to iterate through the rearrangement and also
    //update notifications table.

    //first get the rows, cols, levels for a given rack id
    $result1 = Rack::where('rack_id', $rack_id)->first();

    $rows = $result1->rows;
    $cols = $result1->cols;
    $levels = $result1->levels;

    //now iteratively go through the rack and update the information
    //first for each cage id get the old slot position and store it.
    $total_slots = $rows*$cols*$levels;

    foreach($cage_slot_info as $info)
    {
      $na = explode("@", $info);
      $na1 = explode("=", $na[0]);
      $na2 = explode("=", $na[1]);

      $new_slot_id = (int)$na2[1];
      $cage_id = (int)$na1[1];

      $slot = Slot::where('rack_id', $rack_id)->where('cage_id', $cage_id)->first();

      $old_slot_id = $slot->slot_id;

      // Now make the old slot available
      if ($this->makeOldSlotAvailable($rack_id,$old_slot_id))
      {
        //now inser the new slot details.
        if ($this->makeNewSlotOccupied($rack_id, $new_slot_id, $cage_id))
        {
          $notes = "Cage Id: ".$cage_id. " moved to Rack# ".$rack_id.", Slot# ".$new_slot_id;
          $project_id = Cage::where('cage_id',$cage_id)->first();
          $cagenote = new Cagenote();
          $cagenote->cage_id = $cage_id;
          $cagenote->date = date('Y-m-d');
          $cagenote->posted_by = Auth::user()->name;
          $cagenote->notes = $notes;
          $cagenote->save();
          $cagenote_id = $cagenote->cagenote_id;

          if(!empty($cagenote_id))
          {
              $msg = "Reorganization is successful & messages posted";
          }
          else {
              $msg =  "Error XXX1: Contact Admin";
          }
        }
        else {
            $msg =  "Error XXX2: Contact Admin";
        }
      }
      else {
        $msg = "Error Code xxxx";
      }
    }
    return $msg;
  }

  private function makeOldSlotAvailable($rack_id, $old_slot_id )
  {
    $datArray = array(
                    'cage_id' => 0,
                    'status'  => 'A'
                    );

    if ( Slot::where('rack_id', $rack_id)
          ->where('slot_id', $old_slot_id)
          ->update($datArray))
    {
        return true;
    }
    else {
        return false;
    }
  }

  private function makeNewSlotOccupied( $rack_id, $new_slot_id, $cage_id )
  {
    $updArray = array(
                  'cage_id' => $cage_id,
                  'status'  => 'O'
                  );

    if( Slot::where('rack_id', $rack_id)
            ->where('slot_id', $new_slot_id)
            ->update($updArray))
    {
      return true;
    }
    else {
      return false;
    }
  }

}
