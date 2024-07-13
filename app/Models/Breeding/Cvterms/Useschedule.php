<?php

namespace App\Models\Breeding\Cvterms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Useschedule extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;

    //all breeding models must have this below 2 lines because
    //it connects to another separate db;
    //protected $connection = 'mysql2';

    protected $table = 'useschedule';

    protected $primaryKey = '_useSchedule_key';

    protected $fillable = [
            '_mouse_key',
            '_useScheduleTerm_key',
            '_plugDate_key',
            'startDate',
            'comment',
            'done',
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

        public function useSchTerms()
        {
          return $this->hasMany(Usescheduleterm::class, '_useScheduleTerm_key', '_useScheduleTerm_key');
        }

        // Customize log name
        protected static $logName = 'Useschedule';

        // Only defined attribute will store in log while any change
        protected static $logAttributes = [
          '_mouse_key',
          '_useScheduleTerm_key',
          '_plugDate_key',
          'startDate',
          'comment',
          'done',
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
