<?php

namespace App\Models\Breeding\Cvterms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CVCoatcolor extends Model
{
    use HasFactory;
		use HasRoles;
    use LogsActivity;

		//all breeding models must have this below 2 lines because
		//it connects to another separate db;
		//protected $connection = 'mysql2';
		//
		protected $table = 'cv_coatcolor';

		protected $primaryKey = '_coatColor_key';

		protected $fillable = [
				'coatColor',
				'description',
				'version',
				'_species_key'
    ];

    // Customize log name
    protected static $logName = 'CVCoatcolor';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
      'coatColor',
      'description',
      'version',
      '_species_key'
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
