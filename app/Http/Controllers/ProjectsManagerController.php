<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\User;
use App\Models\Iaecproject;
use App\Models\Issue;
use App\Models\Projectstrains;
use App\Models\Strain;
use App\Models\Species;
use App\Models\Tempproject;
use App\Models\Tempstrain;
use App\Models\Usage;

use Illuminate\Support\Facades\Route;
//---------------

use App\Traits\ProjectDecision;
use App\Traits\StrainConsumption;
use App\Traits\costByProjectId;
use App\Traits\Openstrains;
use App\Traits\Ownerstrains;
use App\Traits\Fileupload;

use App\Http\Requests\ProjectApprovalRequest;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

//use File;
use Validator;

  
use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class ProjectsManagerController extends Controller
{
  use HasRoles, ProjectDecision, StrainConsumption, costByProjectId;
  use Openstrains, Ownerstrains;
  use Fileupload;
  use HasUuids;

	public function __construct()
  {
    //$this->middleware(['role:manager']);
  }
  
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
    // manager can only see the project submitted by Pi belong to enterprise.

    $tps = Tempproject::with('user')->where('status', 'submitted')->get();
    $aps = Iaecproject::with('user')->where('status', 'active')->get();
  //dd($tps);
    
    /*   
    $tps = Tempproject::join('users', 'tempprojects.pi_id', '=', 'users.id')
                            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->where('roles.name', '=', 'pient')
                            ->get();

    $aps = Iaecproject::join('users', 'iaecprojects.pi_id', '=', 'users.id')
                            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->where('roles.name', '=', 'pient')
                            ->get();
    */
    //dd($aps);
    return view('projects.manager.index')
        ->with(['subProjects'=>$tps,
        'activeProjects'=>$aps ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //Get all strain, species information and pass it on.
		$freestrains = $this->strains_open();
		$own_strains = $this->strains_by_owner(Auth::id());
    $users = User::where('id', '<>', 1)->get();
    
			return view('projects.manager.create',
				[	'freestrains'=>$freestrains,
						'own_strains'=>$own_strains,
            'users'=> $users]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    if( Auth::user()->hasAnyRole('pient','manager') )
		{
    		$purpose = "new";
    		$id = "null";
    
    		$this->validate($request, [
    			'title'      => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/|max:200',
    			'start_date' => 'required|date|date_format:Y-m-d',
    			'end_date'   => 'required|date|date_format:Y-m-d|after:start_date',
    			'species'    => 'present|array',
    			'exp_strain' => 'present|array',
    			'spcomments' => 'nullable|regex:/(^[A-Za-z0-9 -_]+$)+/',
    		]);
    
    		if( $request->hasFile('projfile') )
    		{
    			$request->validate([
    				'userfile' => 'required|mimes:pdf|max:4096'
    			]);
    			
    			$filename = $this->projFileUpload($request);
    			// for testing uncomment below and comment above
    			//$filename = "abvdedfadklj";
    		}
    
    		$result = $this->postProjectData($request, $purpose, $id, $filename);
    		
    		return redirect()->route('piprojects.index')
    						->with('flash_message',
    								'New Project Posted Successfully.');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function submitted($id)
  {
    
    $subProject = Tempproject::where('tempproject_id', $id)->first();
    $strainsPosted = Tempstrain::with('strains')
                  ->where('tempproject_id', $id )->get();
    //dd($subProject);
    return view('projects.manager.submittedProjectDetails',
              [ 'subProject'=>$subProject,
                'strainsPosted'=>$strainsPosted]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function showXC($id)
  {
    $subProjects = Tempproject::where('tempproject_id', $id)->get();
    $strainsPosted = Tempstrain::with('strains')
                  ->where('tempproject_id', $id )->get();

    return view('projects.adminApprove',
        [	'subProjects'=>$subProjects,
          'strainsPosted'=>$strainsPosted]);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
    $table = $id."formd";
    
    $iaecproject = Iaecproject::with('user')->where('iaecproject_id', $id)->first();
    
    $projectstrains = Projectstrains::with('strain')
                    ->where('iaecproject_id', $id )->get();
                    
    $issueConfirmed	= Usage::with('strain')->where('iaecproject_id', $id )
                  ->whereIn('issue_status', ['confirmed'])
                  ->get();
                  
    $issue	= Usage::with('strain')->where('iaecproject_id', $id )
                    ->whereIn('issue_status', ['approved', 'issued'])
                    ->get();
   
    $swc	= $this->consumptionByProjectId($id);
    
    $formd = DB::table($table)
                    ->leftJoin('usages', 'usages.usage_id', '=', $table.'.usage_id')
                    ->leftJoin('strains', 'strains.strain_id', '=', $table.'.strain')
                    ->leftJoin('species', 'species.species_id', '=', $table.'.species')
                    ->get();

    $costs = $this->ProjectWiseCost($id);

    return view('projects.manager.showProjectDetails',
                [	'iaecproject'=>$iaecproject,
                  'projectstrains'=>$projectstrains, 
                  'swc'=>$swc, 
                  'formd'=>$formd,
                  'issue'=>$issue, 
                  'issueConfirmed'=>$issueConfirmed,
                  'costs'=>$costs
                ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $freestrains = $this->strains_open();
        
    if( Auth::user()->hasAnyRole('pisg','pient') )
		{
      $tempproject = Tempproject::where('pi_id', Auth::id() )->where('tempproject_id', $id )
                  ->whereIn('status', ['submitted'])->first();
    }

    if( Auth::user()->hasAnyRole('manager') )
		{
      $tempproject = Tempproject::where('tempproject_id', $id )
                  ->whereIn('status', ['submitted'])->first();
    }
    //dd($tempproject);
    $own_strains = $this->strains_by_owner($tempproject->pi_id);
    
    $strainsPosted = Tempstrain::with('strains')
                  ->where('tempproject_id', $id )->get();
                  
    $users = User::where('id', '=', $tempproject->pi_id)->get();
    
    return view('projects.manager.editProject',
      [	'users'=>$users,
        'tempproject'=>$tempproject,
          'freestrains'=>$freestrains,
            'own_strains'=>$own_strains,
              'strainsPosted'=>$strainsPosted]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $result = Tempproject::find($id);
    $input = $request->all();
    //dd($id, $input, $result);
    if( $result != null )
    {
      $input = $request->validate([
        'iaec_comments' => 'required|regex:/^[a-zA-Z0-9\s .,\-\_\/]+$/|max:255',
        'iaec_app_ref'  => 'required|regex:/^[a-zA-Z0-9\s .,\-\_\/]+$/|max:255',
        'iaec_date'     => 'required|date',
        'iaec_meeting'  => 'required|regex:/^[a-zA-Z0-9\s .,\-\_\/]+$/|max:255',
        'iaec_decision' => 'required|numeric'
      ]);

      //dd($input);
      $input['id'] = $id;
      $input['NBformD'] = "yes";
      $msg = $this->accordDecision($input);
    }
        
    return redirect()->route('projectsmanager.index');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
      //
  }
}
