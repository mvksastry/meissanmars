<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Mortality extends Model
{
  use HasFactory;
  use HasRoles;
  use LogsActivity;
	
	protected $table = "mortalities";
    
	protected $primaryKey = 'mortality_id';
		
	/**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
		'species_id',
		'strain_id',
		'project_id',
		'pi_id',
		'number_dead',
		'colony_info',
		'strain_incharge_id',
		'cage_id',
		'slot_index',
		'date_death',
		'cod',
		'notes',
		'posted_by',
		'date_posted',		
  ];
		
	public function user()
  {
    return $this->hasOne(User::class, 'id', 'pi_id');
  }
  
  // Customize log name
  protected static $logName = 'Mprtalities';

  // Only defined attribute will store in log while any change
  protected static $logAttributes = [
    'species_id',
		'strain_id',
		'project_id',
		'pi_id',
		'colony_info',
		'strain_incharge_id',
		'cage_id',
		'date_death',
		'cod',
		'notes',
		'posted_by',
		'date_posted',		
  ];
  // Customize log description
  public function getDescriptionForEvent(string $eventName): string
  {
    return "This model has been {$eventName}";
  }

  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults();
  }	
}
