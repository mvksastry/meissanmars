<?php

namespace App\Models\Breeding\Cvterms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CVLittertype extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;

    //all breeding models must have this below 2 lines because
    //it connects to another separate db;
    //protected $connection = 'mysql2';

    protected $table = 'cv_littertype';

    protected $primaryKey = '_litterType_key';

    protected $fillable = [
            'litterType',
            'abbreviation',
            'isActive',
            'isDefault',
            'sortOrder',
            '_vocabularySource_key',
            'elementID',
            'isDeprecated',
            'version'
        ];

        // Customize log name
        protected static $logName = 'CVLittertype';

        // Only defined attribute will store in log while any change
        protected static $logAttributes = [
          'litterType',
          'abbreviation',
          'isActive',
          'isDefault',
          'sortOrder',
          '_vocabularySource_key',
          'elementID',
          'isDeprecated',
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
