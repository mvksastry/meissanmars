<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

//models
use App\Models\Kanbanboards;
use App\Models\Kanbancards;
use App\Models\User;

//Traits
use App\Traits\Duedate;
use App\Traits\Eventhandler;	
  
use Illuminate\Support\Facades\Route;

class KanbanController extends Controller
{
  use Duedate;
  use Eventhandler;

	public function __construct()
	{
		$this->middleware('auth');
	}
  
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
		$user = Auth::user();
		
		$role_name = Auth::user()->roles->pluck('name')[0];
    
    //$role_name = Auth::user()->roles->pluck('name');
    //dd($role_name);
		
		if($role_name == "" || $role_name == null)
		{
			$role_name = "Role Not Assigned";
		}
		
		if( Auth::user()->hasExactRoles(['employee']) )
		{	
      $kboards = Kanbanboards::where('posted_by', Auth::user()->name)->get();
      $kcards = Kanbancards::where('posted_by', Auth::user()->name)->get();
      $kb = json_encode($kboards);
      $kc = json_encode($kcards);
      //dd($kb, $kc);
      session()->flash("success", "Kanban Board Loaded!");
			//return view('layouts.home.employee.kanbanEmployee');
      return view('layouts.kanban.kanbanBoard', compact('kb', 'kc'));
		}

		if( Auth::user()->hasExactRoles(['supervisor', 'employee']) )
		{
      return view('layouts.home.employee.kanbanEmployee');
		}

		if( Auth::user()->hasExactRoles(['admin', 'employee']) )
		{
      $kboards = Kanbanboards::where('posted_by', Auth::user()->name)->get();
      $kcards = Kanbancards::where('posted_by', Auth::user()->name)->get();
      $kb = json_encode($kboards);
      $kc = json_encode($kcards);
      
      //dd($kb, $kc);
      return view('layouts.kanban.kanbanBoard', compact('kb', 'kc'));
		}

		if( Auth::user()->hasExactRoles(['manager']) )
		{
      $kboards = Kanbanboards::where('posted_by', Auth::user()->name)->get();
      $kcards = Kanbancards::where('posted_by', Auth::user()->name)->get();
      $kb = json_encode($kboards);
      $kc = json_encode($kcards);

      return view('layouts.kanban.kanbanBoard', compact('kb', 'kc'));

		}

 		if( Auth::user()->hasExactRoles(['sysadmin']) )
		{
      return view('layouts.home.employee.kanbanEmployee');
		}
    		
		if( Auth::user()->hasRole('norole') )
		{
			return view('noRoleHome');
		}
			
		return view('noRoleHome');
	}
  


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      //
  }
}
