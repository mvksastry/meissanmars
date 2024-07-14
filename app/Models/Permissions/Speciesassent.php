<?php

namespace App\Models\Permissions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Speciesassent extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    
		//protected $table = 'matingassents';
    protected $primaryKey = 'speciesassent_id';
    
    protected $fillable = [
    	'species_id',
			'handler_id',
			'surrogate_id',
    	'start_date',
			'end_date',
    	'status',
    	'created_at',
    	'updated_at'
    ];
		
		public function species()
    {
      return $this->hasOne(\App\Models\Species::class, 'species_id', 'species_id');
    }
		
		public function handler()
    {
      return $this->hasOne(\App\Models\User::class, 'id', 'handler_id');
    }
		
		public function surrogater()
    {
      return $this->hasOne(\App\Models\User::class, 'id', 'surrogate_id');
    }

    // Customize log name
    protected static $logName = 'Speciesassents';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
    	'species_id',
			'handler_id',
			'surrogate_id',
    	'start_date',
			'end_date',
    	'status',
    	'created_at',
    	'updated_at'
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
