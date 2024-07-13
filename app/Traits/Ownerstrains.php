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


trait Ownerstrains
{
  function strains_by_owner($id)
  {
      return Strain::with('species')->where('distributable', 'no')
                  ->where('owner_id', $id )->get();
  }
}
