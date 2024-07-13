<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Cage extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    
    protected $primaryKey = 'cage_id';
    
    protected $fillable = [
    	'issue_id',
    	'project_id',
    	'requested_by',
    	'species_id',
    	'strain_id',
    	'start_date',
    	'end_date',
    	'ack_date',
    	'cage_status',
    	'notes'
    ];

    public function user()
    {
      return $this->hasOne(User::class, 'id', 'requested_by');
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
        return $this->hasMany(Slot::class, 'cage_id', 'cage_id');
    }

    public function slotID()
    {
        return $this->hasMany(Slot::class, 'cage_id', 'cage_id');
    }

    // Customize log name
    protected static $logName = 'Cage';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
    	'issue_id',
    	'project_id',
    	'requested_by',
    	'species_id',
    	'strain_id',
    	'start_date',
    	'end_date',
    	'ack_date',
    	'cage_status',
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
