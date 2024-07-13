<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Slot extends Model
{
    use HasFactory;
	use HasRoles;
    use LogsActivity;
    
	protected $primaryKey = 'slot_index';

	/**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'slot_id',
    	'rack_id',
    	'cage_id',
    	'status'
    ];

    public function rack()
    {
      return $this->hasOne(Rack::class, 'rack_id', 'rack_id');
    }

    public function occupancy()
    {
        return $this->hasOne(Occupancies::class, 'rack_id', 'rack_id');
    }

    // Customize log name
    protected static $logName = 'Slot';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
        'slot_id',
    	'rack_id',
    	'cage_id',
    	'status'
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
