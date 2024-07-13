<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Tempproject extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;		
	
	protected $primaryKey = 'tempproject_id';
		
		/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'pi_id',
		'title',
		'start_date',
		'end_date',
		'iaec_comments',
		'notes',
		'filename',
		'status',
		'created_at',
		'updated_at'
    ];
		
	public function user()
    {
      return $this->hasOne(User::class, 'id', 'pi_id');
    }

    // Customize log name
    protected static $logName = 'Tempproject';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
		'pi_id',
		'title',
		'start_date',
		'end_date',
		'iaec_comments',
		'notes',
		'filename',
		'status',
		'created_at',
		'updated_at'
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
