<?php

namespace App\Http\Controllers\Breeding\Cvhome;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App;
// place breeding models, Traits here.
use App\Models\Breeding\Allele;

use App\Traits\Breed\BBase;

use Illuminate\Support\Facades\Route;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class CVHomeController extends Controller
{
  //
  use HasRoles;

  use BBase;
  /**
   * Handle the incoming request.
   */
  public function __invoke(Request $request)
  {
    if( Auth::user()->hasRole('manager') )
    {
      return view('breeding.cvterms.cvTermsHome');
    }
  }
}
