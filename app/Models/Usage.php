<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Usage extends Model
{
  use HasFactory;
  use HasRoles;
  use LogsActivity;
  
  protected $primaryKey = 'usage_id';
    
    protected $fillable = [
    	'iaecproject_id',
    	'pi_id',
    	'species_id',
    	'strain_id',
    	'sex',
    	'age',
    	'ageunit',
    	'number',
    	'cagenumber',
    	'termination',
      'duration',
      'duration_unit',
      'expt_desc',
    	'products',
    	'remarks',
    	'status_date',
    	'issue_status',
    	'created_at',
    	'updated_at',
    ];

    public function user()
    {
      return $this->hasOne(User::class, 'id', 'pi_id');
    }
    
    public function project()
    {
      return $this->hasOne(Iaecproject::class, 'iaecproject_id', 'iaecproject_id');
    }
		
    public function species()
    {
      return $this->hasOne(Species::class, 'species_id', 'species_id');
    }
		
    public function strain()
    {
      return $this->hasOne(Strain::class, 'strain_id', 'strain_id');
    }
		
    // Customize log name
    protected static $logName = 'Usage';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
    	'iaecproject_id',
    	'pi_id',
    	'species_id',
    	'strain_id',
    	'sex',
    	'age',
    	'ageunit',
    	'number',
    	'cagenumber',
    	'termination',
      'duration',
      'duration_unit',
      'expt_desc',
    	'products',
    	'remarks',
    	'status_date',
    	'issue_status',
    	'created_at',
    	'updated_at',
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
