<?php

namespace App\Livewire;

use Livewire\Component;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Support\Facades\Route;
use App\Models\Room;
use App\Models\Rack;
use App\Models\Cage;
use App\Models\Slot;

use App\Traits\CageInspections;

class Occupancy extends Component
{
  use CageInspections;
  
	public $rackUpdate = false;
	public $layoutRack = false;
	public $cageInfos = false;
	public $reshuffle = false;

	public $reorg, $infos, $rack_id;

	public $irqMessage, $racks, $rackFlayout;
	public $rows, $cols, $levels, $rackName, $cageIds;
	public $rack_info, $caInfos;
  
  public $cage_id, $appearance, $numdead, $moribund, $housing, $xyz, $notes;

  public function render()
  {
    $rooms = Room::all();
    return view('livewire.occupancy')->with(['rooms'=>$rooms]);
  }

	public function show($id)
  {
		$this->rackUpdate = true;
		$this->layoutRack = false;
		$this->cageInfos = false;
		$this->irqMessage = "";
		//$this->irqMessage = $id;
		$room = Room::where('image_id', $id)->first();
		$this->racks = Rack::where('room_id', $room->room_id)->get();
	}

	public function reorganize()
	{
		$this->irqMessage = $this->reorg;
		dd($this->irqMessage);
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
    $this->cage_id = $id;
		$this->layoutRack = true;
		$this->irqMessage = "Cage Selected is: ".$id;
		$caInfos = Cage::with('user')
						->with('strain')
						->where('cage_id', $id)->get();
		$this->caInfos = $caInfos;
		$this->cageInfos = true;
	}
  
  public function cageSurveillance($cage_id)
  {
    $this->postCageInspectionReport($cage_id);
  }
}
