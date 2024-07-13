<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



use App\Models\Rack;
use App\Models\Slot;
use App\Models\Floor;

use App\Traits\Base;
use App\Traits\Notes;

trait SlotCreation
{
  
  use Base;
  use Notes;
  
  public function inductNewRack($request)
  {
      $rack = new Rack();
      $rack->building_id = 1;
      $rack->floor_id = 1;
      $rack->room_id = $request['room_id'];
      $rack->rack_name = $request['rack_name'];
      $rack->rows = $request['rows'];
      $rack->cols = $request['cols'];
      $rack->levels = $request['levels'];
      $rack->notes = $request['notes'];
      $rack->save();
      
      $rack_id = $rack->rack_id;

      $capacity = $rack->rows*$rack->cols*$rack->levels;

      for($i = 1; $i< $capacity+1; $i++)
      {
        $slot = new Slot();
        $slot->slot_id = $i;  //added on 2-Jan-2022 after change in db
        $slot->rack_id = $rack_id;
        $slot->cage_id = 0;
        $slot->status = 'A';
        $slot->save();
      }
    return true;
  }

  public function editRackInformation($request)
  {
    //first get the building and floor ids
    $result = Floor::findorFail($request['rack->id']);
    
    $building_id = $result->building_id;
    $floor_id = $result->floor_id;
        
    $rack = new Rack();
    $rack->building_id = 1;
    $rack->floor_id = 1;
    $rack->room_id = $request['room_id'];
    $rack->rack_name = $request['rack_name'];
    $rack->rows = $request['rows'];
    $rack->cols = $request['cols'];
    $rack->levels = $request['levels'];
    $rack->notes = $request['notes'];
    $rack->save();

    $rack_id = $rack->rack_id;

    $capacity = $rack->rows*$rack->cols*$rack->levels;

    //querry the slot table whether any slot for this
    // is occupied, if yes don't do any update.

    //before new entries delete existing entries
    $delEntries = Slot::where('rack_id', $rack_id)->delete();
    
    for($i = 1; $i< $capacity+1; $i++)
    {
      $slot = new Slot();
      $slot->slot_id = $i;  //added on 2-Jan-2022 after change in db
      $slot->rack_id = $rack_id;
      $slot->cage_id = 0;
      $slot->status = 'A';
      $slot->save();
    }
    
  }
  
  private function storeRackData($rack)
  {
      $nrack = new Rack();
      $nrack->building_id = 1;
      $nrack->floor_id = 1;
      $nrack->room_id = $rack->room_id;
      $nrack->rack_name = $rack->rack_name;
      $nrack->rows = $rack->rows;
      $nrack->cols = $rack->cols;
      $nrack->levels = $rack->levels;
      $nrack->notes = $rack->notes;
      $nrack->save();
    
  }
 
}