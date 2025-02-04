<?php

namespace App\Livewire\Breeding\Colony;

use Livewire\Component;
use Livewire\Attributes\On; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Support\Facades\Route;

use App\Models\Cage;
use App\Models\Room;
use App\Models\Rack;
use App\Models\Slot;
use Validator;

class CageRegister extends Component
{
		public $cageEntries1 = [], $cageEntries2 = [], $rooms, $room_name;
		public $rackUpdate = false;
		public $layoutRack = false;
		public $cageInfos = false;
		public $reshuffle = false;
		public $irqMessage, $racks, $rackFlayout;
		public $rows, $cols, $levels, $rackName, $cageIds;
		public $rack_info, $caInfos;
		
		public $cage_id, $appearance, $numdead, $moribund, $housing, $xyz, $notes;
		
		//panels
		public $defaultPanel = true, $cagesPanel = false;
		
		//protected $listeners = ['dataTableDisplay' => 'displayDataTable'];
		
    public function render()
    {
			$this->rooms = Room::all();
			$this->cageEntries1 = Cage::with('user')->with('species')->with('strain')->get();
      return view('livewire.breeding.colony.cage-register');
    }
		
		public function show($id)
		{
			$this->rackUpdate = true;
			$this->irqMessage = "";
			//$this->irqMessage = $id;
			$room = Room::where('image_id', $id)->first();
			$this->room_name = $room->room_name;
			$this->racks = Rack::where('room_id', $room->room_id)->get();
			$this->defaultPanel = false;
			$this->cagesPanel = false;
		}
		
		public function rackLayout($id)
		{
			//dd($id);
			$this->rackName = Rack::where('rack_id', $id)->pluck('rack_name');
			$this->defaultPanel = false;
			$this->cageEntries1 = [];
			$this->cageEntries2 = Slot::with('cages')
										->where('rack_id', $id)->where('cage_id', '<>', 0)->get();
			//dd($this->cageEntries2);
			$this->cagesPanel = true;
			$this->dispatch('cageRegister');
		}
			
}
