<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Repository extends Model
{
  use HasFactory;
	use HasRoles;
  use LogsActivity;
    
	protected $primaryKey = 'repository_id';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'posted_by'.
		'description',
		'repository_type',
		'capacity',
		'building',
		'floor',
		'room',
		'incharge',
		'keys_with',
		'status',
		'created_at',
		'updated_at'			
    ];

    // Customize log name
    protected static $logName = 'Repository';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
        'posted_by'.
        'description',
		'capacity',
		'building',
        'floor',
        'room',
        'incharge',
        'keys_with',
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