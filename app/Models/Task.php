<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Task extends Model
{
	use HasFactory;
	use HasRoles;
    use LogsActivity;
    
	protected $primaryKey = 'task_id';
		
    		/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'self_id',
		'category',
		'text',
		'date',
		'status',				
    ];
		
	public function user()
    {
        return $this->hasOne(User::class, 'id', 'self_id');
    }

    // Customize log name
    protected static $logName = 'Task';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
        'self_id',
        'category',
        'text',
        'date',
        'status',
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
