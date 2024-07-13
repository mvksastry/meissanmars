<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Cost extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    
    protected $primaryKey = 'cost_id';
    
    protected $fillable = [
    	'strain_id',
    	'species_id',
    	'effective_cost_date',
    	'per_diem_cost',
    	
    ];
		
    public function strain()
    {
      return $this->hasOne(Strain::class, 'strain_id', 'strain_id');
    }
    
    public function species()
    {
      return $this->hasOne(Species::class, 'species_id', 'species_id');
    }

    // Customize log name
    protected static $logName = 'Cost';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
    	'strain_id',
    	'species_id',
    	'effective_cost_date',
    	'per_diem_cost',
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
