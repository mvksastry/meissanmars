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

//
//use App\Traits\TElab\ResProjectQueries;
use File;

// Log trails recorder
use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class UpdateConsumption extends Component
{
	//panels
	public $viewFineChemForm = false;
	public $viewConsumptionForm = false;
	public $viewNewCategoryForm = false;
	public $viewBulkUploadOptions = false;
	public $showInventoryPanel = false;
	
	//public $viewSearchForm = false;
	public $fullInventoryTable = true;
	public $showConsumptionUpdate = false;
	public $fullInventorySearchTable = false;
	//searchable
	public $value, $selectReply, $pack_mark_code;
	
  //products
  public $prod_info, $products;
  //Bulk chem form variables
	public $pinfos, $sampCode, $catalogNumber, $itemDesc, $consumRemark;
	public $category_name, $unit_id, $vendor_name, $units_desc;
	public $open_status, $status_date, $quantity_left, $full_empty;
	public $unit_desc1, $unit_desc2;
	//consumption form inputs
	public $prodResult, $expt_id, $expt_date, $consumed, $notes_ifany;
	//listeners
	protected $listeners = [
        'itemSelected' => 'selectedItem',
        'refreshComponent' => '$refresh'
    ];
    
  
  public function render()
  {
      $this->stockDetails();
      return view('livewire.common.inventory.update-consumption');
  }
    
  public function stockDetails()
  {
    $this->products = Products::with('categories')
								->with('units')
								->with('vendor')
								->get();
    //dd($infos);    
    //$this->showProductDetailsModal($infos);
    $this->viewStockDetails = true;
    $this->showInventoryPanel = true;
    
    //$this->viewFineChemForm = false;
    //$this->viewConsumptionForm = false;
    //$this->viewNewCategoryForm = false;
    //$this->viewBulkUploadOptions = false;
    //$this->fullInventoryTable = true;
    //$this->showConsumptionUpdate = false;
    //$this->fullInventorySearchTable = false;
  }    
    
  /*
	public function consumptionFormView()
	{
		//reset forms all
		$this->resetInventoryForm();
		$this->resetConsumptionDetail();
		
		//set title
		$this->panel_title = "Update Consumption";
		
		//close all other views
		$this->showInventoryPanel = true;
		$this->fullInventorySearchTable = true;
		$this->viewFineChemForm = false;
		$this->fullInventoryTable = false;
		$this->viewNewCategoryForm = false;
		$this->viewBulkUploadOptions = false;
		
		//open only relevant view
		if($this->sampCode = null || $this->sampCode = "")
		{
			$this->viewConsumptionForm = false;
			$this->showConsumptionUpdate = false;
		}
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] displayed consumption form');
	}
  */
	///////////////////////////////////////////////    
    
	public function viewSelectedItem($pack_mark_code)
	{
		$this->sampCode = $pack_mark_code;
		
		$res = Products::with('categories')
								->with('units')
								->with('vendor')
								->where('pack_mark_code', $pack_mark_code)
								->first();
		$this->catalogNumber = $res->catalog_id;
		$this->itemDesc = $res->name;
		$this->catalogNumber = $res->catalog_id;
		$this->category_name = $res->categories->name;
		$this->vendor_name = $res->vendor->name;
		$this->unit_desc1 = $res->units->symbol;
		$this->unit_desc2 = $res->units->symbol_add;
		$this->open_status  = $res->status_open_unopened;
		$this->status_date  = $res->status_date;
		$this->quantity_left  = $res->quantity_left;
		$this->full_empty  = $res->full_empty;
		
		$this->prodResult = $res;
		//dd($res);
		$this->viewConsumptionForm = true;
		$this->showConsumptionUpdate = true;

    //Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] selected item id [ '.$params['pack_mark_code'].' ]');
	}
	
	public function postConsumptionInfo()
	{	
		//create object for storage
		$newConsumption = new Consumption();
		$newConsumption->pack_mark_code = $this->sampCode;
		$newConsumption->user_id = Auth::user()->id;
		$newConsumption->date_used = date('Y-m-d');
		$newConsumption->product_id = $this->prodResult->product_id;
		//get unit_id
		$newConsumption->unit_id = $this->prodResult->unit_id;
		$newConsumption->quantity_consumed = $this->consumed;
		//get Expt date
		$newConsumption->experiment_id = $this->expt_id;
		$newConsumption->experiment_date = $this->expt_date;
		$newConsumption->notes = $this->notes_ifany;
		//dd($newConsumption);
		$newConsumption->save();
		$this->alert('success', 'Consumption Information Updated'); 
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] saved consumption for pack mark code [ '.$this->sampCode.' ]');
		
		//now reduce the quantity in products table
		$cProd = Products::where('pack_mark_code', $this->sampCode)->first();
		$final = $cProd->quantity_left - $this->consumed;
		
		if( $final < $cProd->pack_size )
		{
			$cProd->status_open_unopened = 0;
		}
		
		$cProd->status_date = $this->expt_date;
		
		//ensure itis not negative, 
		//it must be unsigned
		if($final < 0 )
		{
			$final = 0;
		}
		
		$cProd->quantity_left = $final;
		//dd($newConsumption, $final, $cProd);
		$cProd->save();
        $this->alert('success', 'Product Status Updated'); 
        
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updated quantity consumed for pack mark code [ '.$this->sampCode.' ]');
		
		//now clear the form
		$this->resetConsumptionDetail();
	}
	
	public function resetConsumptionDetail()
	{		
		//$this->panel_title = "Select Action";
		$this->packMarkCode = null;
		$this->sampCode = null;
		$this->category_name = null;
		$this->vendor_name = null;
		$this->catalogNumber = null;
		$this->itemDesc = null;
		$this->open_status = null;
		$this->status_date = null;
		$this->unit_desc1 = null;
		$this->unit_desc2 = null;
		$this->quantity_left = null;
		$this->consumed = null;
		$this->expt_id = null;
		$this->expt_date = null;
		$this->notes_ifany = null;
		$this->showConsumptionUpdate = false;
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Consumption form reset');
	}

	///////////////////////////////////////////////    
    
    
    
    
    
}
