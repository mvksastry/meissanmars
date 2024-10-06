<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;

class PWChangeFormController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
				//$today = date('Y-m-d');
				$flogin = Auth::user()->first_login;
				$last_pw_change = Auth::user()->last_pwchange;
				
				return view('profile.pwchange')->with([
                  'flogin'=>$flogin,
                  'last_pw_change'=>$last_pw_change,
							]);
    }
}
