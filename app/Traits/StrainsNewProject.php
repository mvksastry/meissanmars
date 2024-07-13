<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Models\User;
use App\Models\Project;
use App\Models\Strain;
use App\Models\Species;


trait StrainsNewProject
{
	public function strainsAllowed() 
	{
    $result1 = Strain::with('species')->where('distributable', 'yes')->get();
    $result2 = Strain::with('species')->where('distributable', 'no')
                  ->where('owner_id', Auth::user()->id )->get();
    $stnInfo = $result1->merge($result2);
    $strain_info  = $stnInfo->sortBy('species_name');
    return $strain_info;
	}

	public function strainsAllowedEnterprise() 
  {
    $result1 = Strain::with('species')
          ->where('distributable', 'yes')
              ->where('owner_id', '=', 0)->get();

    $result2 = Strain::with('species')
                        ->where('distributable', 'yes')
            ->whereHas('user', function($q){
                  $q->where('role','=','pient');
              })->get();

    $stnInfo = $result1->merge($result2);
    $strain_info  = $stnInfo->sortBy('species_name');
    return $strain_info;
	}
}
