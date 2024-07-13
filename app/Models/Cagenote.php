<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Cagenote extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    
    protected $primaryKey = 'cagenote_id';
    
    protected $fillable = [
    	'cage_id',
    	'date',
    	'posted_by',
    	'notes',
    	'created_at',
    	'updated_at'
    ];
		
		public function user()
    {
      return $this->hasOne(User::class, 'id', 'posted_by');
    }
		
		public function cage()
    {
      return $this->hasOne(Cage::class, 'cage_id', 'cage_id');
    }

    // Customize log name
    protected static $logName = 'Cagenote';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
    	'cage_id',
    	'date',
    	'posted_by',
    	'notes',
    	'created_at',
    	'updated_at'
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
