<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Products extends Model
{
   use HasFactory;
	
	protected $table = 'products';

	protected $primaryKey = 'product_id';

	protected $fillable = [
		'pack_mark_code',
		'category_id', 
		'resproject_id',
		'catalog_id',
		'name',      
		'pack_size', 
		'unit_id',   
		'num_packs', 
		'mfd_date',
		'batch_code',
		'vial_cost',
		'item_currency',
		'expiry_date',
		'supplier_id',
		'status_open_unopened',
		'quantity_left',
		'full_empty',
		'storage_container_id',
		'shelf_rack_id',
		'box_id',   
		'box_position_id',
		'open_storage', 
		'enteredby_id',
		'date_entered',
		'notes',
	];
	
	public function units()
	{
		return $this->hasOne(Units::class, 'unit_id', 'unit_id');
	}
	
	public function categories()
	{
		return $this->hasOne(Categories::class, 'category_id', 'category_id');
	}
	
	public function resproject()
	{
		return $this->hasOne(Resprojects::class, 'resproject_id', 'resproject_id');
	}
	 
	public function vendor()
	{
		return $this->hasOne(Supplier::class, 'supplier_id', 'supplier_id');
	}
	    // Customize log name
    protected static $logName = 'Products';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
		'pack_mark_code',
		'category_id', 
		'catalog_id',
		'name',      
		'pack_size', 
		'unit_id',   
		'num_packs', 
		'mfd_date',
		'batch_code',
		'vial_cost',
		'item_currency',
		'expiry_date',
		'supplier_id',
		'status_open_unopened',
		'quantity_left',
		'full_empty',
		'storage_container_id',
		'shelf_rack_id',
		'box_id',   
		'box_position_id',
		'open_storage', 
		'enteredby_id',
		'date_entered',
		'notes',
    ];

	// Customize log description
	public function getDescriptionForEvent(string $eventName): string
	{
		return "This model has been {$eventName}";
	}

	public function getActivitylogOptions(): LogOptions{
		return LogOptions::defaults();
	}


}
