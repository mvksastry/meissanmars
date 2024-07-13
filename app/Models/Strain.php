<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Strain extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    
    protected $primaryKey = 'strain_id';
		
		/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'uuid',
      'species_id',
      'strain_name',
      'strain_nickname',
      'strain_formalname',
      'distributable'.
      'owner_id',
      'notes',
      'isActive',
      'strainStatus',
      'tagMin',
      'tagMax',
      'lastTag',
      'jrNum',
      'feNumEmbryos',
      'feMaxGen',
      'fsNumMales',
      'fsMaxGen',
      'foNumFemales',
      'foMaxGen',
      'cardColor',
      'strainType',
      'comment',
      'lineViabilityYellowMinNumMales',
      'lineViabilityYellowMinNumFemales',
      'lineViabilityYellowMaxAgeMales',
      'lineViabilityYellowMaxAgeFemales',
      'lineViabilityRedMinNumMales',
      'lineViabilityRedMinNumFemales',
      'lineViabilityRedMaxAgeMales',
      'lineViabilityRedMaxAgeFemales',
      'version',
      'section_',
      'created_at',
      'updated_at',    
    ];
		
    public function species()
    {
      return $this->hasOne(Species::class, 'species_id', 'species_id');
    }
    
    public function cost()
    {
      return $this->hasOne(Cost::class, 'strain_id', 'strain_id')->latest();
    }
		
    public function user()
    {
      return $this->hasOne(User::class, 'id', 'owner_id');
    }

    // Customize log name
    protected static $logName = 'Strain';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
      'uuid',
      'species_id',
      'strain_name',
      'strain_nickname',
      'strain_formalname',
      'distributable'.
      'owner_id',
      'notes',
      'isActive',
      'strainStatus',
      'tagMin',
      'tagMax',
      'lastTag',
      'jrNum',
      'feNumEmbryos',
      'feMaxGen',
      'fsNumMales',
      'fsMaxGen',
      'foNumFemales',
      'foMaxGen',
      'cardColor',
      'strainType',
      'comment',
      'lineViabilityYellowMinNumMales',
      'lineViabilityYellowMinNumFemales',
      'lineViabilityYellowMaxAgeMales',
      'lineViabilityYellowMaxAgeFemales',
      'lineViabilityRedMinNumMales',
      'lineViabilityRedMinNumFemales',
      'lineViabilityRedMaxAgeMales',
      'lineViabilityRedMaxAgeFemales',
      'version',
      'section_',
      'created_at',
      'updated_at',
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
