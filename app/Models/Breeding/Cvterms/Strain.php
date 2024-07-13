<?php

namespace App\Models\Breeding\Cvterms;

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

		//all breeding models must have this below 2 lines because
		//it connects to another separate db;
		//protected $connection = 'mysql2';

		protected $table = 'strain';

		protected $primaryKey = '_strain_key';

		protected $fillable = [
				'_strain_key',
				'strainName',
				'nickname',
				'formalName',
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
				'section_'
    ];

    // Customize log name
    protected static $logName = 'herd';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
      '_strain_key',
      'strainName',
      'nickname',
      'formalName',
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
      'section_'
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
