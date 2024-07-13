<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Iaecassent extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;

	protected $primaryKey = 'iaecassent_id';

	 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'iaecproject_id',
      'allowed_id',
      'start_date',
      'end_date',
      'formd',
      'notebook',
      'status',
    ];
	 
	public function allowed()
  {
    return $this->hasOne(User::class, 'id', 'allowed_id');
  }

	public function projectiaec()
  {
    return $this->hasOne(Iaecproject::class, 'iaecproject_id', 'iaecproject_id');
  }

  // Customize log name
  protected static $logName = 'Resassent';

  // Only defined attribute will store in log while any change
  protected static $logAttributes = [
		'iaecproject_id',
		'allowed_id',
		'start_date',
		'end_date',
		'formd',
		'notebook',
		'status',
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