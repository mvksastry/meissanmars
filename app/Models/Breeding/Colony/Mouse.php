<?php

namespace App\Models\Breeding\Colony;

use App\Models\Breeding\Cvterms\Strain;
use App\Models\Breeding\Cvterms\CVProtocol;
use App\Models\Breeding\Cvterms\CVGeneration;
use App\Models\Breeding\Cvterms\Lifestatus;

use App\Models\Breeding\Cvterms\CVOrigin;
use App\Models\Breeding\Cvterms\Owner;
use App\Models\Breeding\Cvterms\Container;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use App\Traits\Breed\Search;

class Mouse extends Model
{
    use HasFactory;
		use HasRoles;
    use LogsActivity;


		//all breeding models must have this below 2 lines because
		//it connects to another separate db;
		//protected $connection = 'mysql2';

		protected $table = 'mouse';

		protected $primaryKey = '_mouse_key';

		protected $fillable = [
				'_litter_key',
				'_strain_key',
				'_pen_key',
				'ID',
				'newTag',
				'birthDate',
				'exitDate',
				'cod',
				'codNotes',
				'generation',
				'generation',
				'sex',
				'lifeStatus',
				'breedingStatus',
				'coatColor',
				'diet',
				'owner',
				'origin',
				'protocol',
				'comment',
				'sampleVialID',
				'sampleVialTagPosition',
				'version'
    ];

    /* --- existing code here --- */



    public function protoSelected()
    {
      return $this->hasOne(CVProtocol::class, '_species_key', '_species_key');
    }

    public function strainSelected()
    {
      return $this->hasOne(Strain::class, '_strain_key', '_strain_key');
    }

    public function genSelected()
    {
      return $this->hasOne(CVGeneration::class, 'generation', 'generation');
    }

    public function lifestatusSelected()
    {
      return $this->hasOne(Lifestatus::class, 'lifeStatus', 'lifeStatus');
    }

    public function originSelected()
    {
      return $this->hasOne(CVOrigin::class, 'Origin', 'origin');
    }

    public function ownerSelected()
    {
      return $this->hasOne(Owner::class, 'owner', 'owner');
    }

    public function mouseContainer()
    {
      return $this->hasMany(Container::class, '_container_key', '_pen_key');
    }

    // Customize log name
    protected static $logName = 'Mouse';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = [
      '_litter_key',
      '_strain_key',
      '_pen_key',
      'ID',
      'newTag',
      'birthDate',
      'exitDate',
      'cod',
      'codNotes',
      'generation',
      'generation',
      'sex',
      'lifeStatus',
      'breedingStatus',
      'coatColor',
      'diet',
      'owner',
      'origin',
      'protocol',
      'comment',
      'sampleVialID',
      'sampleVialTagPosition',
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
