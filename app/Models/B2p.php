<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class B2p extends Model
{
		use HasFactory;
		use HasRoles;
    use LogsActivity;
		
		protected $primaryKey = 'b2p_id';

		protected $fillable = [
			'species_id', 
			'strain_id',
			'issue_id',
			'number_moved',
			'date_moved',
			'cage_destination',
			'cage_source',
			'status',
			'status_date',
			'status_updated_by',
			'moved_by',
			'moved_ids',
			'comment'	
		];
		
		public function species()
    {
      return $this->hasOne(Species::class, 'species_id', 'species_id');
    }

		public function strain()
    {
      return $this->hasOne(Strain::class, 'strain_id', 'strain_id');
    }

		public function movedby()
    {
      return $this->hasOne(User::class, 'id', 'moved_by');
    }
		
    // Customize log name
    protected static $logName = 'B2p';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
			'species_id', 
			'strain_id',
			'issue_id',
			'number_moved',
			'date_moved',
			'moved_by',
			'moved_ids',
			'comment'	      
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
