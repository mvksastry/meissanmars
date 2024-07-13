<?php

namespace App\Livewire\Common\Inventory;

use Livewire\Component;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Jantinnerezo\LivewireAlert\LivewireAlert;

//Research Projects

//models
use App\Models\Categories;
use App\Models\Consumption;
use App\Models\Products;
use App\Models\Repository;
use App\Models\Supplier;
use App\Models\Units;
use App\Models\User;

//Traits
use App\Traits\Base;
use App\Traits\TCommon\Fileupload;
use Livewire\WithFileUploads;
use Validator;

use File;

// Log trails recorder
use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;
//

class ConsumptionReplenishment extends Component
{
  use Base;
	use Fileupload;
	use WithFileUploads;
	//use ResProjectQueries;
	//
  use LivewireAlert;
	//
  public $products, $consumption;
  public $showInventoryPanel = false;
  
  
    public function render()
    {
      $this->currentInventory();
      return view('livewire.common.inventory.consumption-replenishment');
    }
    
    public function currentInventory()
    {
      $this->consumption = Consumption::with('units')
                  
                  ->with('user')
                  ->with('product')
                  ->get();   
                  
      //dd($this->consumption);
      $this->showInventoryPanel = true;
    }
  
}
