<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Floor extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    
    protected $primaryKey = 'floor_id';
		
	/**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
      'building_id',
      'floor_name',
      'notes'				
    ];
		
    public function building()
    {
      return $this->hasOne(Building::class, 'building_id', 'building_id');
    }
		
    public function rooms()
    {
      return $this->hasMany(Room::class, 'floor_id', 'floor_id');
    }

    // Customize log name
    protected static $logName = 'Floor';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
    'building_id',
		'floor_name',
		'notes'
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
