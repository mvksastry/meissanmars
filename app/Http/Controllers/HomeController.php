<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

// Manager Models
use App\Models\Iaecproject;
use App\Models\Task;
use App\Models\Tempproject;
use App\Models\User;
use App\Models\Kanbancards;

use App\Traits\Base;
use App\Traits\DashAdminTrait;
use App\Traits\ProjectQueries;
use App\Traits\DashPiTrait;
use App\Traits\TaskReminderTrait;
//use App\Traits\HerdTaskAlertTrait;
use App\Traits\DashTempHumidityGraphTrait;

use Illuminate\Support\Facades\Route;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class HomeController extends Controller
{
  //
  use Base;
	use HasRoles;
	use ProjectQueries;
	use DashAdminTrait, DashPiTrait;
  use TaskReminderTrait;
  //  use HerdTaskAlertTrait;
  use DashTempHumidityGraphTrait;

	public function __construct()
  {
    //$this->middleware(['role:admin|manager|investigator|researcher']);
  }

  public function index()
  {
    $timetag = date("Y-m-d H:i:s");
		//check for expired/suspended account
		$exp = strtotime(Auth::user()->expiry_date);
		$tod = strtotime(date('Y-m-d'));
    
		if( $exp < $tod)
		{
		  $msg = "Your Account Expired on ".date('d-m-Y', strtotime(Auth::user()->expiry_date))." Contact Service Provider";
 			//return  view('norole.noroleHome');
 			Log::channel('activity')->info('Logged in user [ '.Auth::user()->name.' ] account expired');
 			return  view('errors.dashboard')->with('msg', $msg);
		}

		// all is well from here on

		$user = Auth::user();
    $roles = $user->getRoleNames();
    $groupTasks = $this->groupsTasks();
    $personalTasks = $this->personalTasks();
    $kbCards = Kanbancards::where('posted_by', Auth::user()->name)->get();
    
    if( Auth::user()->hasAnyRole('pisg','pient') )
    {
      
      //IAEC projects
      $appProjects = $this->approvedProjects();
      $subProjects = $this->submittedProjects();
      $amendProjects = $this->amendProjects();
      $expiredProjects = $this->expiredProjects();

      //IAEC Animal usage
      $submittedIssues = $this->piSubmittedIssues();
      $confirmedIssues = $this->piConfirmedIssues();
      $approvedIssues = $this->piApprovedIssues();
      $issuedIssues = $this->piIssuedIssues();
      
      //research projects
      $actvProjs = $this->allowedProjectIds();
      //dd($appProjects, $subProjects, $amendProjects, $expiredProjects);
      //dd($submittedIssues, $confirmedIssues, $approvedIssues, $issuedIssues);
      //Log::channel('activity')->info('Logged in user [ '.Auth::user()->name.' ] dashboard requested');
      Log::channel('activity')->info('Logged in user [ '.Auth::user()->name.' ] dashboard requested');
      return view('layouts.home.pi.dashboard')->with([
                  'appProjects'=>$appProjects,
                  'subProjects'=>$subProjects,
                  'amendProjects'=>$amendProjects,
                  'expiredProjects'=>$expiredProjects,
                  'submittedIssues'=>$submittedIssues,
                  'confirmedIssues'=>$confirmedIssues,
                  'approvedIssues'=>$approvedIssues,
                  'issuedIssues'=>$issuedIssues,
                  'actvProjs'=>$actvProjs,
                  'personalTasks'=>$personalTasks,
                  'groupTasks'=> $groupTasks,
                  'kbCards' => $kbCards
      ]);
    }

    if( Auth::user()->hasRole('manager') )
    {
      $users = count(User::all());
      $subProjects = $this->submittedProjectsForApproval();
      
      $activeProjects = $this->activeProjectsInFacility();
      
      $totalRacks = $this->totalRacksInFacility();
			$occupiedSlots = $this->occupiedSlots();
			$slotsAvailable = $this->availableSlots();
			$freeStrains = $this->freeStrains();
			$ownerStrains = $this->ownerStrains();
			$penUsage = $this->pendigIssues();
			$appUsage = $this->approvedIssues();
     
      $bldgName = $this->buldingName();
      $floors = $this->floorNames();
      $rooms = $this->roomNames();
      
      //Log::channel('activity')->info('Logged in user [ '.Auth::user()->name.' ] dashboard requested');
  		return view('layouts.home.manager.dashboard')
          ->with([
                  'users'=>$users,
                  'subProjects'=>$subProjects,
  								'activeProjects'=>$activeProjects,
  								'kbCards' => $kbCards,
                  'totalRacks'=>$totalRacks,                
                  'occupiedSlots'=>$occupiedSlots,
                  'slotsAvailable'=>$slotsAvailable,                     
  								'freeStrains' => $freeStrains, 
                  'ownerStrains' => $ownerStrains,
  								'penUsage' =>$penUsage,
  								'appUsage' => $appUsage,
                  'bldgName' => $bldgName,
                  'floorNames' => $floors,
                  'roomNames' => $rooms
  		]);
      
  	}

    if( Auth::user()->hasRole('researcher') )
    {
      $submittedIssues = $this->piSubmittedIssues();
      $confirmedIssues = $this->piConfirmedIssues();
      $approvedIssues = $this->piApprovedIssues();
      $issuedIssues = $this->piIssuedIssues();
      Log::channel('activity')->info('Logged in user [ '.Auth::user()->name.' ] dashboard requested');
      return view('researcher.researcherHome')->with([
                  'submittedIssues'=>$submittedIssues,
                  'confirmedIssues'=>$confirmedIssues,
                  'approvedIssues'=>$approvedIssues,
                  'issuedIssues'=>$issuedIssues,
                  'personalTasks'=>$personalTasks,
                  'groupTasks'=> $groupTasks
      ]);
    }

    if( Auth::user()->hasRole('veterinarian') )
    {
      Log::channel('activity')->info('Logged in user [ '.Auth::user()->name.' ] dashboard requested');
      return view('veterinarian.vetHome')->with([
                  'personalTasks'=>$personalTasks,
                  'groupTasks'=> $groupTasks
      ]);
    }

    if( Auth::user()->hasRole('facility_help') )
    {
      Log::channel('activity')->info('Logged in user [ '.Auth::user()->name.' ] dashboard requested');
      return view('facilithelp.facithelpHome')
              ->with(['personalTasks'=>$personalTasks,
                      'groupTasks'=> $groupTasks ]);
    }

    if( Auth::user()->hasRole('asstlab') )
    {
        Log::channel('activity')->info('Logged in user [ '.Auth::user()->name.' ] dashboard requested');

    }

    if( Auth::user()->hasRole('asstfacility') )
    {
          Log::channel('activity')->info('Logged in user [ '.Auth::user()->name.' ] dashboard requested');
    }
    
    //for management of roles and permissions.
		if( Auth::user()->hasRole('admin') )
		{
		    
			$users = count(User::all());
			$subProjects = Tempproject::where('status', 'submitted')->get();
			$activeProjects = Iaecproject::where('status', 'active')->get();
      Log::channel('activity')->info('Logged in user [ '.Auth::user()->name.' ] dashboard requested');
			return view('layouts.home.sysadmin.dashboard')->with([
									'users'=>$users,
									'groupTasks'=> 0
								 ]);
		}

    if( Auth::user()->hasRole('guest') || Auth::user()->hasRole('norole') )
		{
		  Log::channel('activity')->info('Logged in user [ '.Auth::user()->name.' ] dashboard requested');
			return view('norole.noRoleHome');
		}
    // end of herd management roles
        
		$msg = "Your account is freshly registered or has no assigned role or not activated. Contact Service Provider";
		Log::channel('activity')->info('Logged in user [ '.Auth::user()->name.' ] Guest user requesting for dashboard');
    return view('norole.noRoleHome')->with(['slot'=>$msg]);
  }

  public function passwordReset(Request $request)
  {
    //$token = $this->generateCode(80);
    //$request->route()->parameter('token') = $this->generateCode(80);
    $request->email = Auth::user()->email;
    Log::channel('activity')->info('Logged in user [ '.$request->email.' ] password reset requested');
    return view('auth.reset-pw', ['request' => $request]);
    //return view('auth.reset-password');
  }

  public function updatePassword(Request $request)
  {
    $input = $request->all();

    $rules = [
       'email'    => 'required|email',
       'password' => 'nullable|required_with:password_confirmation|string|confirmed',
       //'current_password' => 'required',
    ];

    $validation = Validator::make( $input, $rules);

    if ( $validation->fails() ) 
    {
      Log::channel('activity')->info('Logged in user [ '.$request->email.' ] validation failed');
      return redirect()->back()->withErrors($validation)->withInput();
    }
    else {
      $result = User::where('email', $input['email'])->update([
                       'password' => Hash::make($input['password']),
                       'first_login' => date('Y-m-d')]);
      Log::channel('activity')->info('Logged in user [ '.$request->email.' ] password reset successful');
      return  redirect('/home');
    }
  }

  public function expiredAccount()
  {
    $msg = "Your Account Expired on ".date('d-m-Y', strtotime(Auth::user()->expiry_date))." Contact Service Provider";
    //return  view('norole.noroleHome');
    Log::channel('activity')->info('Logged in user [ '.Auth::user()->name.' ] account expired');
    return  view('errors.dashboard')->with('msg', $msg);
  }

  public function accountSuspended()
  {
    $msg = "Your Account Suspended. Contact Service Provider";
    //return  view('norole.noroleHome');
    Log::channel('activity')->info('Logged in user [ '.Auth::user()->name.' ] account suspended');
    return  view('errors.dashboard')->with('msg', $msg);
  }
}
