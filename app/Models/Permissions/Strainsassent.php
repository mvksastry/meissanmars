<?php

namespace App\Models\Permissions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Strainsassent extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    
		//protected $table = 'matingassents';
    protected $primaryKey = 'strainsassent_id';
    
    protected $fillable = [
    	'strain_id',
			'handler_id',
			'backup_id',
    	'start_date',
			'end_date',
    	'status',
			'notes',
    	'created_at',
    	'updated_at'
    ];
		
		public function strains()
    {
      return $this->hasOne(\App\Models\Strain::class, 'strain_id', 'strain_id');
    }
		
		public function handler()
    {
      return $this->hasOne(\App\Models\User::class, 'id', 'handler_id');
    }
		
		public function backup()
    {
      return $this->hasOne(\App\Models\User::class, 'id', 'backup_id');
    }

    // Customize log name
    protected static $logName = 'Strainsassents';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
    	'strain_id',
			'handler_id',
			'backup_id',
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
