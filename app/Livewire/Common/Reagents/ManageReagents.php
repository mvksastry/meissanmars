<?php

namespace App\Livewire\Common\Reagents;

use Livewire\Component;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

//Research Projects

//models
use App\Models\Categories;
use App\Models\Consumption;
use App\Models\Products;
use App\Models\Reagents;
use App\Models\Repository;
use App\Models\Supplier;
use App\Models\Units;
use App\Models\User;

//Traits
use App\Traits\Base;
//use App\Traits\TCommon\Fileupload;
//use Livewire\WithFileUploads;
use Validator;

use File;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class ManageReagents extends Component
{
	use Base;
	//use Fileupload;
	//use WithFileUploads;
	
	//models
	public $repositories;
	public $categories;
	public $units;
	public $suppliers;
	
	//common panel titles
	public $panel_title = "Select Action";
	
	//consumption form inputs
	public $prodResult, $expt_id, $expt_date, $consumed;
	
	//reagent variables
	public $reagent_name, $reagent_nickname, $reagent_desc, $reagentClassCode;
	public $quantity_made, $units_id, $units_desc, $expirty_date, $reagentCode;
	public $products;
  
	public $container_id, $rack_shelf, $box_sack, $location_code, $note_remark;
	
	public $openrestriced = 1;
	
	public $product_id, $pack_mark_code, $prod_name;
	
  public $inputs = [], $pmcProd = [], $nameProd = [];
	public $quantityProd = [], $usageProd = [];
  public $i = 0;
	public $sampCode, $catalogNumber, $itemDesc, $unit_desc1, $unit_desc2;
	
	//panels
	public $searchResultBox1 = false;
	public $left_panel_title, $right_panel_title;
	
	//remake reagents
	public $selectedReagentID, $rmReagentClassCode, $rmStockReagents;
	public $rmReagent_id,$rmName,$rmDesc,$rmNickName,$rmIngradients=[];
	public $rmMadebyID, $rmDateMade, $rmRegClassCode, $rmRegCode;
	public $rmQuantity, $rmUnits_desc, $rmUnitDesc, $rmExpiryDate;
	public $rmStorContId,$rmShelfRackId,$rmBoxSackId,	$rmLocationCode;
	public $rmOpenRestrict, $rmNotes, $rmMakeSame, $usedReagents = [];
	public $altProdInfo = [], $rmCodePM = [], $reagentsUsed = [];
	public $openRemakeReagentFields = false;
	
	//flags
	public $stopFlag = true;
	
	//errors
	public $rmMakeSameError, $rmQuantityErrors = [];
	
	//listeners
	protected $listeners = [
      'itemSelected' => 'selectedItem',
		  'reagentSelected' => 'selectedReagent'
  ];
	
	//panels
	public $viewNewReagentForm = false;
	public $showNewReagentEntry = false;
	
	public $viewRemakeReagentForm = false;
	public $showRemakeReagentEntry = false;
	
	public function render()
	{
		$this->units = Units::all();
		$this->suppliers = Supplier::all();
		$this->categories = Categories::all();
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Reagent home page displayed'); 
		return view('livewire.common.reagents.manage-reagents');
	}
	
	public function newReagentForm()
	{
    $this->products = Products::with('categories')
								->with('units')
								->with('vendor')
								->get();   
                
		$this->repositories = Repository::all();
		$this->reagentCode = $this->generateCode(6);
		$this->left_panel_title = "Make Reagents";
		$this->right_panel_title = "Current Inventory";
		$this->showNewReagentEntry = true;
		$this->showRemakeReagentEntry = false;
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] New Reagent form shown'); 
	}	
	
	public function selectedItem($pack_mark_code)
	{
    //dd($pack_mark_code);
		$this->sampCode = $pack_mark_code;
		
		$res = Products::with('categories')
								->with('units')
								->with('vendor')
								->where('pack_mark_code', $pack_mark_code)
								->first();
								
		$this->inputs[$this->i]['pmc'] = $this->sampCode;
		$this->inputs[$this->i]['name'] = $res->name;
		$this->inputs[$this->i]['cat_num'] = $res->catalog_id;
		$this->inputs[$this->i]['unit_desc1'] = $res->units->symbol;
		$this->inputs[$this->i]['unit_desc2'] = $res->units->symbol_add;
		$this->inputs[$this->i]['quantity'] = '';
		$this->inputs[$this->i]['usage'] = '';
		
		//open the result box
		$this->searchResultBox1 = true;
		
		//keep ready for next item
		$this->i = $this->i + 1;
		
		//array_push($this->inputs ,$this->i);
		//dd($this->inputs);
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] selected the reagent ['.$this->sampCode.' ]');
	}
	
  public function removeSelectedItem($key)
  {
    unset($this->inputs[$key]);    
  }
  
	public function postReagentInfo()
	{	
		$i=0;
		
		foreach($this->inputs as $row)
		{
			$this->inputs[$i]['quantity'] = $this->quantityProd[$i];
			$this->inputs[$i]['usage'] = $this->usageProd[$i];
			$i = $i + 1;
		}
	
		$ingradients = json_encode($this->inputs);

		$newReagent = new Reagents();
		
		$newReagent->name  = $this->reagent_name;
		$newReagent->nick_name  = $this->reagent_nickname;
		$newReagent->description  = $this->reagent_desc;
		$newReagent->madeby_id  = Auth::user()->id;
		$newReagent->date_made  = date('Y-m-d');
		$newReagent->reagent_class_code  = $this->reagentClassCode;
		$newReagent->reagent_code  = $this->sampCode;
		$newReagent->ingradients  = $ingradients;
		$newReagent->quantity_made  = $this->quantity_made;
		$newReagent->unit_id  = $this->units_desc;
		$newReagent->quantity_left  = $this->quantity_made;
		$newReagent->expiry_date  = $this->expirty_date;
		$newReagent->storage_container_id  = $this->container_id;
		$newReagent->shelf_rack_id  = $this->rack_shelf;
		$newReagent->box_sack_id  = $this->box_sack;
		$newReagent->location_code  = $this->location_code;
		$newReagent->open_restricted  = $this->openrestriced;
		$newReagent->notes  = $this->note_remark;
		$newReagent->save();
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] saved new reagent with id [ '.$newReagent->nick_name.' ]'); 
		
		//now using the inputs array process the usage information
		//especially the quantity left in products 
		//table and consumptions tables
		foreach($this->inputs as $row)
		{
			//now get the chemical detail from products table
			//reduce the quantity in products table
			$cProd = Products::where('pack_mark_code', $row['pmc'])->first();
			$cProd->quantity_left = $cProd->quantity_left - $row['quantity'];
			$cProd->status_date = date('Y-m-d');
			if( $cProd->quantity_left < $cProd->pack_size )
			{
				$cProd->status_open_unopened = 0;
			}
			//ensure it is not negative, 
			//it must be unsigned
			if($cProd->quantity_left < 0 )
			{
				$cProd->quantity_left = 0;
			}
			$cProd->save();
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updated quantity for reagent with id [ '.$row['pmc'].' ]'); 
			
			//now post to consumption table
			//create object for storage
			$newConsumption = new Consumption();
			$newConsumption->pack_mark_code = $row['pmc'];
			$newConsumption->user_id = Auth::user()->id;
			$newConsumption->date_used = date('Y-m-d');
			$newConsumption->product_id = $cProd->product_id;
			//get unit_id
			$newConsumption->unit_id = $cProd->unit_id;
			$newConsumption->quantity_consumed = $row['quantity'];
			//get Expt date
			$newConsumption->experiment_id = 0;
			$newConsumption->experiment_date = date('Y-m-d');
			$newConsumption->notes = "General Open reagent.";
			//dd($newConsumption);
			$newConsumption->save();
			
			//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updated consumption for reagent with id [ '.$row['pmc'].' ]');
			
		}
		
		//now clear theform
		$this->resetReagentForm();
		$ingradients = [];
		
	}
	
	public function resetReagentForm()
	{
		$this->reagent_name = null;
		$this->reagent_nickname = null;
		$this->reagent_desc = null;
		$this->sampCode = null;
		$this->quantity_made = null;
		$this->units_desc = null;
		$this->expirty_date = null;
		$this->container_id = null;
		$this->rack_shelf = null;
		$this->box_sack = null;
		$this->location_code = null;
		$this->openrestriced = null;
		$this->note_remark = null;
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] reagent form reset');
	}
	
	public function remakeReagentForm()
	{
    $this->rmStockReagents = Reagents::with('units')->with('users')->get();
 		$this->reagentCode = null;
		$this->repositories = Repository::all();
		$this->left_panel_title = "Remake Reagents";
		$this->right_panel_title = "Current Reagents: Select a Code";
		$this->showNewReagentEntry = false;
		$this->showRemakeReagentEntry = true;
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Reagent remake form displayed');
	}
	
	public function selectedReagent($reagent_id)
	{
		$regs = [];
		
		$reagentBy_id = Reagents::with('units')
										->where('reagent_id', $reagent_id)
										->first();
										
		$ingradients = json_decode($reagentBy_id->ingradients);
		//dd($ingradients);
		
		$this->selectedReagentID = $reagentBy_id;
		//set the selected reagemt code
		$this->reagentCode = $reagentBy_id->reagent_code;
		
		foreach($ingradients as $row)
		{
			$regs['pmc'] = $row->pmc;
			$regs['name'] = $row->name;
			$regs['cat_num'] = $row->cat_num;
			$unit_def = " ".$row->unit_desc1.$row->unit_desc2;
			$regs['quantity'] = $row->quantity.$unit_def;
			$pmcProdInfo = Products::where('pack_mark_code', $row->pmc)->first();
			$regs['quantity_left'] = $pmcProdInfo->quantity_left.$unit_def;
			
			if( $pmcProdInfo->quantity_left < $row->quantity)
			{
				$regs['row_flag'] = "true";
				$regs['unitDef'] = $unit_def;
	
				// this query works and give total quantity left 
				// summing all packs having same catalog number.
				$quantityCheck =	Products::where('catalog_id', $row->cat_num)
												->selectRaw('sum(quantity_left) as qty_left , catalog_id')
												->groupBy('catalog_id')
												->get();
												
				foreach($quantityCheck as $valx)
				{
					if($valx->qty_left <= $row->quantity )
					{
						$quantityErrors[] = "Error: Insufficient Quantity of [ ".$row['cat_num']." ] ";
					}
					else {
						$this->altProdInfo = Products::with('units')->where('catalog_id', $row->cat_num)
													->where('quantity_left', '>=', $row->quantity)->get();
						$this->stopFlag = false;
					}
				}
			}
			else {
			    $this->stopFlag = false;
			}
			//dd($this->usedReagents, $this->stopFlag);
			array_push($this->usedReagents, $regs);
			$regs = [];
		}
		//$cap = count($this->altProdInfo);
		//dd($this->usedReagents, $this->altProdInfo, $cap, $this->stopFlag);
		
		$this->rmReagent_id = $reagentBy_id->reagent_id;
		$this->rmName = $reagentBy_id->name;
		$this->rmDesc = $reagentBy_id->description;
		$this->rmNickName = $reagentBy_id->nick_name;
		$this->rmIngradients = $ingradients;
		$this->rmMadebyID = $reagentBy_id->madeby_id;
		$this->rmDateMade = $reagentBy_id->date_made;
		$this->rmRegClassCode = $reagentBy_id->reagent_class_code;
		$this->rmRegCode = $reagentBy_id->reagent_code;
		$this->rmQuantity = $reagentBy_id->quantity_made;
		$this->rmUnitDesc = $reagentBy_id->units->description;
		
		$this->rmStorContId = $reagentBy_id->sotrage_container_id;
		$this->rmShelfRackId = $reagentBy_id->shelf_rack_id;
		$this->rmBoxSackId = $reagentBy_id->box_sack_id;
		$this->rmLocationCode = $reagentBy_id->location_code;
		$this->rmOpenRestrict = $reagentBy_id->open_restricted;
		$this->rmNotes = $reagentBy_id->notes;
		
		$this->openRemakeReagentFields = true;
		//dd($reagentBy_id);
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] remade reagent with id [ '.$reagentBy_id->nick_name.' ]');
	}
	
	public function postRemakeReagentInfo($reagentCode)
	{
		if($this->rmMakeSame != null )
		{
			// goals
			// 1. first get vials that have less than required quantity
			// 2. get ticked vial pack_mark_code and empty the vial from previous step
			// 3. remove the remaining quantity from the current selected vial.
			// dump validations

			$validatedData = $this->validate(
			[
			  'rmCodePM' 		    => 'required|min:1',
			  'rmReagentClassCode'  => 'required',
			  'rmQuantity'          => 'required|numeric',
			  'rmUnits_desc'        => 'required|numeric',
			  'rmExpiryDate'        => 'required|date',
			  
			  'rmStorContId'        => 'required|numeric',
			  'rmShelfRackId'       => 'required|numeric',
			  'rmBoxSackId'         => 'required|numeric',
			  'rmLocationCode'      => 'required|string|regex:/^[A-Za-z0-9-,_. ]+$/', 
			  
			  'rmOpenRestrict'      => 'required|numeric', 
			  'rmNotes'             => 'required|string|regex:/^[A-Za-z0-9-,_. ]+$/'
			],
			[
				'rmCodePM.required'	=> 'The :attribute must check one box',
				'rmCodePM.rmCodePM'	=> 'The :attribute must check one box',
			  'rmReagentClassCode.required' => 'The :attribute cannot be empty.',
			  'rmReagentClassCode.rmReagentClassCode' => 'The :attribute must be selected.',
			  'rmQuantity.required' => 'The :attribute cannot be empty.',
			  'rmQuantity.rmQuantity' => 'The :attribute must be a whole number.',  
			  'rmUnits_desc.required' => 'The :attribute cannot be empty.',
			  'rmUnits_desc.rmUnits_desc' => 'The :attribute must be selected.',
			  'rmExpiryDate.required' => 'The :attribute cannot be empty.',
			  'rmExpiryDate.rmExpiryDate' => 'The :attribute must be date.',
			  
			  'rmStorContId.required' => 'The :attribute cannot be empty.',
			  'rmStorContId.rmStorContId' => 'The :attribute must be a whole number.',
			  'rmShelfRackId.required' => 'The :attribute cannot be empty.',
			  'rmShelfRackId.rmShelfRackId' => 'The :attribute must be a whole number.',
			  'rmBoxSackId.required' => 'The :attribute cannot be empty.',
			  'rmBoxSackId.rmBoxSackId' => 'The :attribute must be a whole number.',
			  'rmLocationCode.required' => 'The :attribute cannot be empty.',
			  'rmLocationCode.rmLocationCode' => 'The :attribute must be a alpha numeric.',	
			  
			  'rmOpenRestrict.required' => 'The :attribute cannot be empty.',
			  'rmOpenRestrict.rmOpenRestrict' => 'The :attribute must be selected.', 
			  'rmNotes.rmNotes' => 'The :attribute must be alpha numeric only.'
			],
			[
			  'rmCodePM'				  => 'Catalog ID',
			  'rmReagentClassCode' => 'Reagent Class Code',
			  'rmQuantity'         => 'Quantity',
			  'rmUnits_desc'       => 'Units',
			  'rmExpiryDate'       => 'Expiry Date',
			  
			  'rmStorContId'       => 'Container ID',
			  'rmShelfRackId'      => 'Rack/Shelf ID',
			  'rmBoxSackId'        => 'Box/Savk ID',
			  'rmLocationCode'     => 'Loocation', 
			  
			  'rmOpenRestrict'     => 'Open/Restricted', 
			  'rmNotes'            => 'Notes'
			]);
			
			
			$this->rmUnitDesc = $this->selectedReagentID->unit_id;
			
			//first determine whether the vials have enough quantity.
			$quantityErrors = [];
			foreach($this->rmIngradients as $row)
			{
				$this->rmNotes = "";
				
				$regs['pmc'] = $row['pmc'];
				$pmcProdInfo = Products::with('units')->where('pack_mark_code', $row['pmc'])->first();
				
				$regs['name'] = $row['name'];
				$regs['cat_num'] = $row['cat_num'];
				
				$regs['unit_desc1'] = $pmcProdInfo->units->symbol;
				$regs['unit_desc2'] = $pmcProdInfo->units->symbol_add;
				
				$regs['quantity'] = $row['quantity']; //original quantity must be taken for reagent
				$regs['usage'] = "same as earlier";	
				
				if( $pmcProdInfo->quantity_left < $row['quantity'] )
				{
					
					$this->rmNotes = $this->rmNotes."Vial PMC [ ".$row['pmc']." ] has less than needed";
					
					$subProdInfo = Products::where('catalog_id', $row['cat_num'])
													->where('quantity_left', '>=', $row['quantity'])->get();
					
					$qtyTakenFromOld = intval($pmcProdInfo->quantity_left);
					
					//now zero the quantity left in the db table and save it.
					$subProdInfo = $pmcProdInfo->quantity_left = 0;
					$subProdInfo->save();
					Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updated quantity for id [ '.$row['pmc'].' ]'); 
					
					//now post to consumption table
					//create object for storage
					$newConsumption = new Consumption();
					$newConsumption->pack_mark_code = $row['pmc'];
					$newConsumption->user_id = Auth::user()->id;
					$newConsumption->date_used = date('Y-m-d');
					$newConsumption->product_id = $pmcProdInfo->product_id;
					//get unit_id
					$newConsumption->unit_id = $pmcProdInfo->unit_id;
					$newConsumption->quantity_consumed = $qtyTakenFromOld;
					//get Expt date
					$newConsumption->experiment_id = 0;
					$newConsumption->experiment_date = date('Y-m-d');
					$newConsumption->notes = $this->rmNotes;
					//dd($newConsumption);
					$newConsumption->save();
				    Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updated consumption for id [ '.$row['pmc'].' ]');
				    
					//get the vial id selected by user
					foreach($this->rmCodePM as $key => $val)
					{
						if($val)
						{
							// we are now setting to new vial 
							// as old was closed.
							$regs['pmc'] = $key;
						}
					}

					//here this $regs['quantity'] refers to the new vial 				
					$regs['quantity'] = $row['quantity'] - $qtyTakenFromOld;
					 
					//get quantity of the new vial, wrote here for verification
					$subProdInfo2 = Products::where('pack_mark_code', $regs['pmc'])
													->where('quantity_left', '>=', $regs['quantity'])->get();
													
					foreach($subProdInfo2 as $xval)
					{
						$qtyLeft = $xval->quantity_left - $regs['quantity'];
					}						
					
					if($qtyLeft >= 0 )
					{
						$this->stopFlag = false;
					}
					
					$this->rmNotes = $this->rmNotes." From new vial [ ".$row['pmc']." ] ". $row['quantity']." taken";
					//now set the newVialQuanity left as the value qtyLeft
				}
			
				array_push($this->reagentsUsed, $regs);
				$regs = [];
			}
		
			//dd($stopFlag,$this->reagentsUsed );

			if(!$stopFlag)
			{
				$ingradients = json_encode($this->reagentsUsed);
			
				//dd($ingradients, $this->reagentsUsed);
				
				$newReagent = new Reagents();
				
				$newReagent->name                  = $this->rmName;
				$newReagent->nick_name             = $this->rmNickName;
				$newReagent->description           = $this->rmDesc;
				$newReagent->madeby_id             = Auth::user()->id;
				$newReagent->date_made             = date('Y-m-d');
				$newReagent->reagent_class_code    = $this->rmRegClassCode;
				
				// let it generate a new code, since old code may be valid or invalid
				// also a new primary key is also getting generated due to new entry
				$newReagent->reagent_code          = $this->generateCode(6);
				
				$newReagent->ingradients           = $ingradients;
				
				$newReagent->quantity_made         = $this->rmQuantity;
				
				$newReagent->unit_id               = $this->rmUnitDesc;
				
				$newReagent->quantity_left         = $this->rmQuantity;
				$newReagent->expiry_date           = $this->rmExpiryDate;
				$newReagent->storage_container_id  = $this->rmStorContId;
				$newReagent->shelf_rack_id         = $this->rmShelfRackId;
				$newReagent->box_sack_id           = $this->rmBoxSackId;
				$newReagent->location_code         = $this->rmLocationCode;
				$newReagent->open_restricted       = $this->rmOpenRestrict;
				$newReagent->notes                 = $this->rmNotes;
				//dd($newReagent);
				$newReagent->save();
				
				//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] save new reagent with id [ '.$newReagent->nick_name.' ]');
				
				//now using the inputs array process the usage information
				//especially the quantity left in products 
				//table and consumptions tables
				foreach($this->reagentsUsed as $row)
				{
					//now get the chemical detail from products table
					//reduce the quantity in products table
					$cProd = Products::where('pack_mark_code', $row['pmc'])->first();
					$cProd->quantity_left = $cProd->quantity_left - $row['quantity'];
					$cProd->status_date = date('Y-m-d');
					
					if( $cProd->quantity_left < $cProd->pack_size )
					{
						$cProd->status_open_unopened = 0;
					}
					
					//ensure it is not negative, 
					//it must be unsigned
					if($cProd->quantity_left < 0 )
					{
						$cProd->quantity_left = 0;
					}
					
					$cProd->save();
					
					//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updated quantity for id [ '.$row['pmc'].' ]');

					//now post to consumption table
					//create object for storage
					$newConsumption = new Consumption();
					$newConsumption->pack_mark_code = $row['pmc'];
					$newConsumption->user_id = Auth::user()->id;
					$newConsumption->date_used = date('Y-m-d');
					$newConsumption->product_id = $cProd->product_id;
					//get unit_id
					$newConsumption->unit_id = $cProd->unit_id;
					$newConsumption->quantity_consumed = $row['quantity'];
					//get Expt date
					$newConsumption->experiment_id = 0;
					$newConsumption->experiment_date = date('Y-m-d');
					$newConsumption->notes = "General Open reagent.";
					//dd($newConsumption);
					$newConsumption->save();
					
					//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updated consumption for id [ '.$row['pmc'].' ]');
					
				}		
			}	
			//now reset form fields
			$this->resetRemakeReagentForm();
			
			//close the form
			$this->openRemakeReagentFields = false;
		}
		else {
			$this->rmMakeSameError = "Make Same not checked";
		}
	}
	
	public function resetRemakeReagentForm()
	{
		$this->reagentCode = null;
		$this->rmMakeSame = null;
		
		$this->rmCodePM 		     = null;
		$this->rmReagentClassCode = null;
		$this->rmQuantity     = null;
		$this->rmUnits_desc   = null;
		$this->rmExpiryDate   = null;
			  
		$this->rmStorContId   = null;
		$this->rmShelfRackId  = null;
		$this->rmBoxSackId    = null;
		$this->rmLocationCode = null; 
			  
		$this->rmOpenRestrict = null;
		$this->rmNotes = null;
		
		//Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] reset form');
	}	



}
