<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Kanbanboards extends Model
{
    use HasFactory;
    use HasRoles;
    
  protected $table = 'kboboards';
  
  protected $primaryKey = 'kboboard_id';
	
	protected $fillable = [
	
    'uuid',
    'name',
    'description',
    'sequence_id',
    'color',
    'status',
    'status_date',
    'posted_by',
    'edited_by'
    
	];    
    
    
    
    
    
    
}
