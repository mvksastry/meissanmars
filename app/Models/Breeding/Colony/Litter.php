<?php

namespace App\Models\Breeding\Colony;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Litter extends Model
{
    use HasFactory;
		use HasRoles;
    use LogsActivity;

		//all breeding models must have this below 2 lines because
		//it connects to another separate db;
		//protected $connection = 'mysql2';

		protected $table = 'litter';

		protected $primaryKey = '_litter_key';

		protected $fillable = [
				'_mating_key',
				'_theilerStage_key',
				'litterID',
				'totalBorn',
				'birthDate',
				'numFemale',
				'numMale',
				'numberBornDead',
				'numberCulledAtWean',
				'numberMissingAtWean',
				'weanDate',
				'tagDate',
				'status',
				'comment',
				'version',
				'_litterType_key',
				'harvestDate',
				'numberHarvested',
    ];

    // Customize log name
    protected static $logName = 'Litter';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
      '_mating_key',
      '_theilerStage_key',
      'litterID',
      'totalBorn',
      'birthDate',
      'numFemale',
      'numMale',
      'numberBornDead',
      'numberCulledAtWean',
      'numberMissingAtWean',
      'weanDate',
      'tagDate',
      'status',
      'comment',
      'version',
      '_litterType_key',
      'harvestDate',
      'numberHarvested',
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
