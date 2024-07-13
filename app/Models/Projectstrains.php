<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Projectstrains extends Model
{
  use HasFactory;
  use HasRoles;
  use LogsActivity;
    
	protected $table = 'projectstrains';
	
	protected $primaryKey = 'projstrain_id';
		
		
		/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'iaecproject_id',
      'species_id',
      'strain_id',
      'allyearstotal',
      'year1',
      'year2',
      'year3',
      'year4',
      'year5',
    ];
		
	public function project()
  {
    return $this->hasOne(Project::class, 'project_id', 'project_id');
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
  protected static $logName = 'Projectstrains';

  // Only defined attribute will store in log while any change
  protected static $logAttributes = [
    'project_id',
    'species_id',
    'strain_id',
    'allyearstotal',
    'year1',
    'year2',
    'year3',
    'year4',
    'year5',
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
