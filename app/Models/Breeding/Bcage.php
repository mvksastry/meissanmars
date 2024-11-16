<?php

namespace App\Models\Breeding;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Bcage extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    
    protected $primaryKey = 'bcage_id';
    
    protected $fillable = [
			'entered_by',
			'species_id',
			'strain_id', 
			'animal_number',
			'mouse_ids',
			'start_date',
			'end_date',
			'ack_date',
			'cage_status',
			'notes',
    ];
	
    public function user()
    {
      return $this->hasOne(User::class, 'id', 'entered_by');
    }

    public function species()
    {
      return $this->hasOne(Species::class, 'species_id', 'species_id');
    }

    public function strain()
    {
      return $this->hasOne(Strain::class, 'strain_id', 'strain_id');
    }

    public function slots()
    {
        return $this->hasMany(Slot::class, 'bcage_id', 'bcage_id');
    }

    public function slotID()
    {
        return $this->hasMany(Slot::class, 'bcage_id', 'bcage_id');
    }

    // Customize log name
    protected static $logName = 'Bcage';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
			'entered_by',
			'species_id',
			'strain_id', 
			'animal_number',
			'mouse_ids',
			'start_date',
			'end_date',
			'ack_date',
			'cage_status',
			'notes',
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
