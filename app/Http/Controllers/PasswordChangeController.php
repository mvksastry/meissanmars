<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

use App\Models\User;

class PasswordChangeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
				$input = $request->all();
				$email = Auth::user()->email;
				$cpw = Auth::user()->password;		
				//dd($cp, $pw, $email,$input);
				if(Hash::check($input['current_password'], $cpw))
				{
					$result = User::where('email', $email)->update([
                       'password' => Hash::make($input['password']),
                       'first_login' => date('Y-m-d'),
											 'last_pwchange' => date('Y-m-d')]);
				}
				else {
					dd('password mismatch');
				}
				//Log::channel('activity')->info('Logged in user [ '.$request->email.' ] password reset successful');
				Auth::logout();
				return  redirect('/login');
    }
}
