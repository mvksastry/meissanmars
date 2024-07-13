<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Units extends Model
{

  use HasFactory;
	use HasRoles;
  //use LogsActivity;
	
	protected $table = 'units';

	protected $primaryKey = 'unit_id';
	
		protected $fillable = [
		'symbol',
		'symbol_add', 
		'description',
	];
}
