<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Team extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;

	protected $primaryKey = 'team_id';

	 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'leader_id',
      'member_id',
    ];
		
	public function members()
  {
    return $this->hasMany(User::class, 'id', 'member_id');
  }
	
  // Customize log name
  protected static $logName = 'Teams';

  // Only defined attribute will store in log while any change
  protected static $logAttributes = [
		'leader_id',
		'member_id',
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
