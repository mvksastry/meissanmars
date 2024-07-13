<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Consumption extends Model
{
   use HasFactory;
	
	protected $primaryKey = 'consumption_id';

	protected $fillable = [
		'pack_mark_code',
		'user_id',   
		'date_used',
		'product_id',
		'unit_id',
		'quantity_consumed',
		'experiment_id',
		'experiment_date',
		'notes'
	];

	public function user()
	{
		return $this->hasOne(User::class, 'id', 'user_id');
	}

	public function units()
	{
		return $this->hasOne(Units::class, 'unit_id', 'unit_id');
	}
	
	public function product()
	{
		return $this->hasOne(Products::class, 'product_id', 'product_id');
	}
	 
	public function prodProj()
	{
		return $this->hasOneThrough(Resproject::class, Products::class, 'product_id', 'resproject_id', 'product_id', 'resproject_id');
	} 
	 
	 //below this one works! finally, a long distance relationship, 
	 // watch the keys placement.
	public function productProject()
	{
		return $this->hasOneThrough(Resproject::class, Products::class, 'product_id', 'resproject_id', 'product_id', 'resproject_id');
	}

}
