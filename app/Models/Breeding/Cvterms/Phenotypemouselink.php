<?php

namespace App\Models\Breeding\Cvterms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Phenotypemouselink extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;

    //all breeding models must have this below 2 lines because
    //it connects to another separate db;
    //protected $connection = 'mysql2';

    protected $table = 'phenotypemouselink';

    protected $primaryKey = '_phenotypeMouseLink_key';

    protected $fillable = [
            '_phenotype_key',
            '_mouse_key',
            'version'
        ];

        public function mouse()
        {
          return $this->hasOne(Mouse::class, '_mouse_key', '_mouse_key');
        }

        public function speciesKey()
        {
          return $this->hasOne(Mouse::class, '_mouse_key', '_mouse_key')->pluck('_species_key');
        }

        public function phenotypeDesc()
        {
          return $this->hasMany(CVPhenotype::class, '_phenotype_key', '_phenotype_key');
        }

        // Customize log name
        protected static $logName = 'Phenotypemouselink';

        // Only defined attribute will store in log while any change
        protected static $logAttributes = [
          '_phenotype_key',
          '_mouse_key',
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
