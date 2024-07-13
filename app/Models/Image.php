<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Image extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    
    protected $primaryKey = 'image_id';
    
    protected $fillable = [
      'tablename',
      'notebook_id',
      'staff_id',
      'staff_name',
      'entry_date',
      'cage_id',
      'image_file',
      'video_file',
      'remarks',
    ];
		
    public function cage()
    {
      return $this->hasOne(Cage::class, 'cage_id', 'cage_id');
    }
		
    public function user()
    {
      return $this->hasOne(User::class, 'id', 'staff_id');
    }

    // Customize log name
    protected static $logName = 'herd';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
      'tablename',
      'notebook_id',
      'staff_id',
      'staff_name',
      'entry_date',
      'cage_id',
      'image_file',
      'video_file',
      'remarks',
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
