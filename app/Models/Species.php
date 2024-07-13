<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Species extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;

    protected $table = 'species';

    protected $primaryKey = 'species_id';
		
		/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'species_name',
      'notes'
    ];
		
    public function strains()
    {
      return $this->hasMany(Strain::class, 'species_id', 'species_id');
    }
		
    // Customize log name
    protected static $logName = 'Species';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
      'species_name',
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
