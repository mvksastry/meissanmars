<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Rack extends Model
{
  use HasFactory;
  use HasRoles;
  use LogsActivity;
    
	protected $primaryKey = 'rack_id';

	/**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
				'rack_name',
				'building_id',
				'floor_id',
				'room_id',
				'rows',
				'cols',
				'levels',
				'notes'				
    ];		
		
    public function building()
    {
      return $this->hasOne(Building::class, 'building_id', 'building_id');
    }
		
    public function floor()
    {
      return $this->hasOne(Floor::class, 'floor_id', 'floor_id');
    }
		
    public function room()
    {
      return $this->hasOne(Room::class, 'room_id', 'room_id');
    }
    
    public function slots()
    {
      return $this->hasMany(Slot::class, 'rack_id', 'rack_id');
    }

    // Customize log name
    protected static $logName = 'Rack';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
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
