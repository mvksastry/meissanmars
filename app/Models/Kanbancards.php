<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Kanbancards extends Model
{
  use HasFactory;
  use HasRoles;
  
  protected $table = 'kbocards';
  
  protected $primaryKey = 'kbocard_id';
	
	protected $fillable = [
	
    'kboboard_id',
    'uuid',
    'item_name',
    'item_desc',
    'sequence_id',
    'item_status',
    'status_date',
    'status_by',
    'posted_by',
    'edited_by',
	
	];
  
}
