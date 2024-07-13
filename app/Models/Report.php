<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Report extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    
    protected $primaryKey = 'report_id';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'iaecproject_id',
        'report_type',
        'date_from',
        'date_to',
        'filename',
        'submitted_by',
        'submitted_date'
    ];
				
    public function user()
    {
      return $this->hasOne(User::class, 'id', 'submitted_by');
    }

    // Customize log name
    protected static $logName = 'herd';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
        'iaecproject_id',
        'report_type',
        'date_from',
        'date_to',
        'filename',
        'submitted_by',
        'submitted_date'
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
