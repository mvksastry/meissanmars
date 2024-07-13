<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Room extends Model
{
    use HasFactory;
	use HasRoles;
    use LogsActivity;
    
	protected $primaryKey = 'room_id';
		
	/**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
    'uuid',
    'building_id',
    'floor_id',
		'room_name',
    'image_id',
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
		
    public function rack()
    {
      return $this->hasMany(Rack::class, 'rack_id', 'rack_id');
    }

    // Customize log name
    protected static $logName = 'Room';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
    'uuid',
    'building_id',
    'floor_id',
		'room_name',
    'image_id',
		'notes'
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
