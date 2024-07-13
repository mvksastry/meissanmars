<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Project;
use App\Models\Projectstrains;

use App\Traits\Base;

trait ProjectStrainsById
{
	public function fetchProjectStrainsById($id)
	{
		$ps = Projectstrains::with('strain')->where('iaecproject_id',$id)->get();
		foreach($ps as $val)
		{
			foreach($val as $x)
			{
				$a1['species_id'] =  $val->species_id;
				$a1['strain_id'] =  $val->strain_id;
				$a1['name'] =  $val->strain->strain_name;
			}
			
		    $psbi[] = $a1;
	    }
		
		return $psbi;
	}
}
