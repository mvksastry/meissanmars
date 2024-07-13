<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Logentry extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;
	 
	 protected $table = 'logentries';
	 
	 protected $primaryKey = 'logentry_id';
	 
  /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
		'infra_id',
		'start_hour',
		'start_min',  
		'end_hour',   
		'end_min',    
		'accessories',
		'user_id', 
		'status',  
		'remarks'
		];

    public function infra()
    {
      return $this->hasOne(Infrastructure::class, 'infra_id', 'infra_id');
    }
	 
	 public function user()
    {
      return $this->hasOne(User::class, 'id', 'user_id');
    }
    
    // Customize log name
    protected static $logName = 'Logentries';
	 
	     // Only defined attribute will store in log while any change
    protected static $logAttributes = [
		'infra_id',
		'start_hour',
		'start_min',  
		'end_hour',   
		'end_min',    
		'accessories',
		'user_id', 
		'status',  
		'remarks'
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
