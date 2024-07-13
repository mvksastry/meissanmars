<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Storage;

use App\Models\Species;
use App\Models\Strain;
use App\Models\Tempproject;
use App\Models\Tempstrain;
use App\Models\Iaecproject;
use App\Models\Iaecassent;
use App\Models\Projectstrains;

//use File;
use App\Traits\Base;
use App\Traits\Notes;
use App\Traits\NewFormDTable;

trait ProjectQueries
{
  use Base;
  use Notes;
  use NewFormDTable;

  public function projectById($id)
  {
    return Iaecproject::where('iaecproject_id', $id)->first();
  }

  public function allowedProjectIds()
  {
    return Iaecassent::with('projectiaec')
              //->with('permitted')
              ->where('allowed_id', Auth::id())
              ->where('end_date', '>=', date('Y-m-d'))
              ->where('status', 'active')
              ->get();

  }

  public function allowedSubmittedProjectIds()
  {
    return Tempproject::where('pi_id', Auth::id())
              ->where('status', 'submitted')
              ->get();
  }
  
  
  public function checkProjectAllowedOrNot($id)
  {
    $res = Iaecassent::where('iaecproject_id', $id)
            ->where('allowed_id', Auth::id())
            ->where('end_date', '>=', date('Y-m-d'))
            ->where('status', 'active')
            ->get();

    if( count($res) == 1 )
    {
      return true;
    }
    else {
      return false;
    }

  }
}
