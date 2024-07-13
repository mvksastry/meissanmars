<?php

namespace App\Models\Breeding\Colony;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Mating extends Model
{
    use HasFactory;
		use HasRoles;
    use LogsActivity;

		//all breeding models must have this below 2 lines because
		//it connects to another separate db;
		//protected $connection = 'mysql2';

		protected $table = 'mating';

		protected $primaryKey = '_mating_key';

		protected $fillable = [
				'_matingType_key',
				'_dam1_key',
				'_dam2_key',
				'_sire_key',
				'_strain_key',
				'matingID',
				'suggestedPenID',
				'weanTime',
				'matingDate',
				'retiredDate',
				'generation',
				'owner',
				'weanNote',
				'needsTyping',
				'comment',
				'proposedDiet',
				'proposedRetireDate',
				'proposedRetireD1Diet',
				'proposedRetireD2Diet',
				'proposedRetireSDiet',
				'proposedRetireD1BrStatus',
				'proposedRetireD2BrStatus',
				'proposedRetireSBrStatus',
				'proposedRetireD1LfStatus',
				'proposedRetireD2LfStatus',
				'proposedRetireSLfStatus',
				'proposedRetirePenStatus',
				'suggestedFirstLitterNum',
				'_crossStatus_key',
				'version'
    ];

    // Customize log name
    protected static $logName = 'Mating';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
      '_matingType_key',
      '_dam1_key',
      '_dam2_key',
      '_sire_key',
      '_strain_key',
      'matingID',
      'suggestedPenID',
      'weanTime',
      'matingDate',
      'retiredDate',
      'generation',
      'owner',
      'weanNote',
      'needsTyping',
      'comment',
      'proposedDiet',
      'proposedRetireDate',
      'proposedRetireD1Diet',
      'proposedRetireD2Diet',
      'proposedRetireSDiet',
      'proposedRetireD1BrStatus',
      'proposedRetireD2BrStatus',
      'proposedRetireSBrStatus',
      'proposedRetireD1LfStatus',
      'proposedRetireD2LfStatus',
      'proposedRetireSLfStatus',
      'proposedRetirePenStatus',
      'suggestedFirstLitterNum',
      '_crossStatus_key',
      'version'
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
