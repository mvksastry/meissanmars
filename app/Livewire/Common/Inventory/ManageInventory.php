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
//

class ManageInventory extends Component
{

	use Base;
	use Fileupload;
	use WithFileUploads;
	//use ResProjectQueries;
	//
  use LivewireAlert;
	//
	
	//models
	public $repositories;
	public $categories;
	public $units;
	public $suppliers;
	public $products;
  
	//common panel titles
	public $panel_title = "Select Action";
	
	//Fine chem form variables
	public $packMarkCode, $category_id, $catalog_number, $item_desc;
	public $source_desc, $pack_size, $unit_desc1, $unit_desc2, $number_packs;
	public $container_id, $rack_shelf, $box_sack, $location_code, $note_remark;
	public $batchCode, $dateMFD, $dateExpiry, $vialCost, $costCurrency;
	
	//project info
	public $allActiveResProjects, $resproj_id;
	
	//Bulk chem form variables
	public $pinfos, $sampCode, $catalogNumber, $itemDesc, $consumRemark;
	public $category_name, $unit_id, $vendor_name, $units_desc;
	public $open_status, $status_date, $quantity_left, $full_empty;
	
	//consumption form inputs
	public $prodResult, $expt_id, $expt_date, $consumed, $notes_ifany;
	
	//new category
	public $newCategory, $newCatDesc;
	
	//panels
	public $viewFineChemForm = false;
	public $viewConsumptionForm = false;
	public $viewNewCategoryForm = false;
	public $viewBulkUploadOptions = false;
	public $showInventoryPanel = false;
	public $viewStockDetails = false;
	//public $viewSearchForm = false;
	public $fullInventoryTable = true;
	public $showConsumptionUpdate = false;
	public $fullInventorySearchTable = false;
	public $viewAllStockDetails = false;
	//searchable
	public $value, $selectReply, $pack_mark_code;
	
  //products
  public $prod_info;
  
	//listeners
	protected $listeners = [
        'itemSelected' => 'selectedItem',
        'refreshComponent' => '$refresh'
    ];
	
	//sweet alerts
	public $bulkUploadSuccess = false, $bulkUploadFail = false;
	
	///////////////////////////////////////////////////
  public function render()
  {
    //Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Inventory Management page displayed');
    $this->inventoryFormView();
    //return view('livewire.common.manage-inventory');
    return view('livewire.common.inventory.manage-inventory');
  }
    
	public function inventoryFormView()
	{
		$this->packMarkCode = $this->generateCode(6);
		$this->categories = Categories::all();
		$this->repositories = Repository::all();
		$this->units = Units::all();
		$this->suppliers = Supplier::all();
    $this->products = Products::all();

		//dd($this->allActiveResProjects);
		$this->panel_title = "Add To Inventory";
		
		// panel openings
		$this->resetInventoryForm();
		//$this->viewConsumptionForm = false;
		//$this->showInventoryPanel = true;
		$this->viewFineChemForm = true;
		//$this->fullInventoryTable = true;
		//$this->viewNewCategoryForm = false;
		//$this->fullInventorySearchTable = false;
		//$this->viewBulkUploadOptions = false;
		//$this->viewStockDetails = false;
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Displayed inventory form');
	}
	
	public function postProductInfo()
	{
		//dump all validations

		for($i = 0; $i < $this->number_packs; $i++)
		{	
			$nprod = new Products();
			$nprod->pack_mark_code = $this->generateCode(6);
			$nprod->category_id = $this->category_id;
			$nprod->resproject_id = $this->resproj_id;
			$nprod->catalog_id = $this->catalog_number;
			$nprod->name = $this->item_desc;
			
			$nprod->pack_size = $this->pack_size;
			$nprod->unit_id = $this->units_desc;
			$nprod->num_packs = $this->number_packs;
			
			$nprod->mfd_date = $this->dateMFD;
			$nprod->batch_code = $this->batchCode;
			
			$nprod->vial_cost = $this->vialCost;
			$nprod->item_currency = $this->costCurrency;
			
			$nprod->expiry_date = $this->dateExpiry;
			
			$nprod->supplier_id = $this->source_desc;
			$nprod->status_open_unopened = 1; // 1 is unopened, 0 is opened
			$nprod->status_date = date('Y-m-d');
			$nprod->quantity_left = $this->pack_size;
			$nprod->full_empty = 1;  // 1 is full , 0 is empty
			
			$nprod->storage_container_id = $this->container_id;
			$nprod->shelf_rack_id = $this->rack_shelf;
			$nprod->box_id = $this->box_sack;
			$nprod->box_position_id = $this->location_code;
			if($this->box_sack == null || $this->location_code == null)
			{
				$nprod->open_storage = 1;  // 1 is kept in open
			}else {
				$nprod->open_storage = 0;  // 0 is in a box or some enclosed
			}
			
			$nprod->enteredby_id = Auth::id();
			$nprod->date_entered = date('Y-m-d');
			$nprod->notes = $this->note_remark;
			//dd($this->number_packs, $nprod);
			$nprod->save();
			
			//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] saved inventory info [ '.$this->generateCode(6).' ]');
		}
		$this->alert('success', 'Inventory Updated'); 
		$this->resetInventoryForm();
		$this->viewFineChemForm = false;
	}
	
	private function resetInventoryForm()
	{
		//$this->panel_title = "Select Action";
		$this->category_id = null;
		$this->resproj_id = null;
		$this->catalog_number = null;
		$this->item_desc = null;
		$this->pack_size = null;
		$this->units_desc = null;
		$this->number_packs = null;
		$this->dateMFD = null;
		$this->batchCode = null;
		$this->vialCost = null;
		$this->costCurrency = null;
		$this->dateExpiry = null;		
		$this->source_desc = null;
		$this->container_id = null;
		$this->rack_shelf = null;
		$this->box_sack = null;
		$this->location_code = null;
		$this->note_remark = null;
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] reset inventory form');
	}

  public function currentInventory()
  {
    $this->products = Products::with('categories')
								->with('units')
								->with('vendor')
								->get();   
    $this->showInventoryPanel = true;
  }
 
 /*
  public function stockItemDetails($id)
  {
    $this->pinfos = Products::with('categories')
								->with('units')
								->with('vendor')
								->where('product_id', $id)
								->first();  
    //$this->showProductDetailsModal($infos);
    $this->viewStockDetails = true;
    $this->showInventoryPanel = true;
    
    $this->viewFineChemForm = false;
    $this->viewConsumptionForm = false;
    $this->viewNewCategoryForm = false;
    $this->viewBulkUploadOptions = false;
    //$this->fullInventoryTable = true;
    $this->showConsumptionUpdate = false;
    $this->fullInventorySearchTable = false;
  }
  */
  
  /*
  public function showProductDetailsModal($info)
	{
	    $this->prod_info = $info;
      
      $this->dispatch("openModal", 'livewire.stockitem-modal',
					["prod_info" => $this->prod_info]);
          
      $this->dispatch(
        event: 'openModal',
        component: 'livewire.stockitem-modal',
        arguments: [
        'ispopup' => true,
        "prod_info" => $this->prod_info]);   
          
	}
  */
	///////////////////////////////////////////////
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
	///////////////////////////////////////////////
  */
  
  /*
	///////////////////////////////////////////////
	public function updatedSampCode()
	{
		//dd($this->sampCode);
	}
	public function updatedCatalogNumber()
	{
		//dd($this->catalogNumber);
	}
	
	public function updatedItemDesc()
	{
		//dd($this->itemDesc);
	}
	
	public function selectedItem($params)
	{
		$this->sampCode = $params['pack_mark_code'];
		
		$res = Products::with('categories')
								->with('units')
								->with('vendor')
								->where('pack_mark_code', $params['pack_mark_code'])
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
		
		$this->viewConsumptionForm = true;
		$this->showConsumptionUpdate = true;

    //Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] selected item id [ '.$params['pack_mark_code'].' ]');
	}
	*/
  /*
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
  */
  
	///////////////////////////////////////////////
	public function searchFormView()
	{
		//dd("Reached search window");
		
	}
	
	public function showNewCategoryCreation()
	{
	  $this->showInventoryPanel = true;
		$this->fullInventoryTable = false;
		$this->fullInventorySearchTable = false;
		$this->viewBulkUploadOptions = false;
		
		//dd("reached");
		$this->viewNewCategoryForm = true;
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] displayed new category creation form');
	}
	
	public function postNewCategoryInfo()
	{
		
		$validatedData = $this->validate(
		[
		  'newCategory' => 'required|alpha_num',
		  'newCatDesc'	 => 'required|string|regex:/^[A-Za-z0-9-,_. ]+$/',
		],
		[
			'newCategory.required'	=> 'The :attribute required',
			'newCategory.newCategory'	=> 'The :attribute must alpha numeric characters only',
			
			'newCatDesc.required'	=> 'The :attribute required',
			'newCatDesc.newCatDesc'	=> 'The :attribute must alpha numeric characters only',
		],
		[
		  'newCategory' => 'New Category',
		  'newCatDesc'  => 'New Category Description'
		]);
		
		$newCat = new Categories();
		$newCat->name = $this->newCategory;
		$newCat->description = $this->newCatDesc;
		//dd($newCat);
		$newCat->save();
		$this->alert('success', 'New Category Created');
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] saved new inventory category');
		
		$newCat = null;
		$this->categories = Categories::all();
		$this->resetNewCategoryForm();
		
		$this->showInventoryPanel = true;
		$this->fullInventoryTable = true;
		$this->fullInventorySearchTable = false;
		$this->viewNewCategoryForm = false;
		$this->viewBulkUploadOptions = false;
	}
	
	public function resetNewCategoryForm()
	{
		$this->newCategory = null;
		$this->newCatDesc = null;
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] reset Inventory New category info form');
	}
	
	/////////// -- Bulk Import section -- ///////////
	
	public function showBulkAdditionOption()
	{
	    
	    //dd("reached");
	    
    // panel opening-closing
    $this->showInventoryPanel = false;
    $this->viewFineChemForm = false;
    $this->viewConsumptionForm = false;
    $this->fullInventoryTable = false;
		$this->fullInventorySearchTable = false;
		$this->viewNewCategoryForm = false;
		$this->viewBulkUploadOptions = true;
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] displayed Bulk Addition form');
	}
	
	public function downloadBulkTemplate()
	{
	    // get pis folder, modify the column
        $path = storage_path('templates/inventoryImport.xlsx');
        $headers = array(
            'Content-Type: application/xls',
        );
        return response()->download($path);
        
        //Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] downloaded bulk inventory template');
	}
	
	public function processBulkInventoryUpload()
	{
	    $this->bulkUploadSuccess = true;
	    $this->alert('warning', 'Not Yet Implemented');
	    //dd("processing reached: will be operational shortly");
	}
	
	
	
	
	
	
	
	
	    
    
    
    
    
    
}
