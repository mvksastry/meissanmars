<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Categories extends Model
{
	use HasFactory;
	use HasRoles;
	//use LogsActivity;

	protected $table = 'categories';

	protected $primaryKey = 'category_id';

	protected $fillable = [
		'name',
		'description',
	];

	public function user()
	{
		return $this->hasOne(User::class, 'id', 'posted_by');
	}

	public function cage()
	{
		return $this->hasOne(Cage::class, 'cage_id', 'cage_id');
	}
}
