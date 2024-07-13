<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

//Importing laravel-permission models
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

//models
use Auth;
use App\Models\Teams;
use App\Models\Teamusers;
use App\Models\Teaminvitations;
use App\Models\User;

//traits
use App\Traits\Groupidentity;

//Requests
use App\Http\Requests\TeamsRequest;


class TeamsController extends Controller
{
    use Groupidentity;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      //
      $teams = Teamusers::with('user')->with('tname')->get();
      
      //dd($teams);
      return view('teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      if( Auth::user()->hasAnyRole(['admin','director']) )
      {
        $users = User::pluck('name', 'id');
        //dd($users);
        $teamusers = Teamusers::all();
        $teamNames = Teams::distinct()->get('name');
        return view('teams.create', compact('users','teamusers','teamNames'));
      }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
      $input = $request->all();
           
           
      if( $input['existing_name'] != null && $input['new_team_name'] != null)
      {  
        $swalMsg = "Either select Name or Enter New Name";
        return redirect()->back()->with(['error'=>$swalMsg]);
      }

      if($input['existing_name'] == null )
      {
        $team_name = $input['new_team_name'];
        unset($input['existing_name']);
      }
      
      if($input['new_team_name'] == null)
      {
        $team_name = $input['existing_name'];
        unset($input['new_team_name']);
      } 
      
      //dd($team_name, $input);  

      //first create team
      $result1 = Teams::firstOrCreate(array('name' => $team_name, 
                                          'personal_team' => 1));
      
      //next create leader
      $result2 = Teamusers::firstOrCreate(array('team_id' => $result1->id, 
                                          'user_id' => $input['leader_id'], 
                                          'role' => "team_leader"));
                                          
      //create members through loop
      foreach($input['member_id'] as $row)
      {
        $member_id = $row;
        $role = "member";
        $resx = Teamusers::firstOrCreate(array(
                                          'team_id' => $result1->id, 
                                          'user_id' => $member_id, 
                                          'role' => $role));
                                          
        $email = User::where('id',$member_id)->first();

        $result3 = Teaminvitations::firstOrCreate(array('team_id' => $result1->id, 
                                          'email' => $email->email, 
                                          'role' => $role));     
      }                 
                              
      if($result1 && $result2)
      {
        $swalMsg = "New Team Created !";
        return redirect()->route('teams.index')->with(['success'=>$swalMsg]);
      }
      else {
        $swalMsg = "New Team Creation Failed";
        return redirect()->back()->with(['error'=>$swalMsg]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      $team_id = $id;
      $users = User::pluck('name','id');
      //get the team name first from id
      $req = Teams::where('id', $id)->first();
      $team_name = $req->name;
      
      $teamusers = Teamusers::where('team_id',$team_id)->get();
      
      //dd($teamusers, $teamNames);
      return view('teams.edit', compact('team_name','team_id','users','teamusers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $msg = "";
      
      $input = $request->all();
      // everything captured. now we need to put in db.
      // same way as stored above.
      //dd($input);
      
      //first update the team leader
      if($input['leader_id'] != null)
      {  
        $resx = Teamusers::updateOrCreate(
                              ['team_id'=> $id, 'role'=>'team_leader'],
                              ['user_id' => $input['leader_id']]); 
        $msg = "Team Leader Updated";
      }
      else {
        $msg = "Team Leader Not Changed/Selected";
        $resx = false;
      }
      // create or change members through loop
      if(array_key_exists('member_id', $input) && (count($input['member_id']) > 0))
      {
        foreach($input['member_id'] as $row)
        {
          $member_id = $row;
          $role = "member";
          $resy = Teamusers::updateOrCreate(array(
                                            'team_id' => $id, 
                                            'user_id' => $member_id, 
                                            'role' => $role));
                                            
          $email = User::where('id',$member_id)->first();

          $resz = Teaminvitations::updateOrCreate(array('team_id' => $id, 
                                            'email' => $email->email, 
                                            'role' => $role));     
        }
        $msg = $msg."; Team members updated";
      }
      else {
        $msg = $msg. " ; Team Members Not Changed/Selected";
        $resy = false;
      }
      
      if($resx && $resy)
      {
        $swalMsg = $msg;
        return redirect()->route('teams.index')->with(['success'=>$swalMsg]);
      }
      else {
        $swalMsg = $msg;
        return redirect()->back()->with(['error'=>$swalMsg]);
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $id = intval($id);
      $res = Teamusers::destroy($id);
      if($res)
      {
        $swalMsg = "Removed Successfully !";
        return redirect()->route('teams.index')->with(['success'=>$swalMsg]);
      }
      else {
        $swalMsg = "Removal Failed";
        return redirect()->back()->with(['error'=>$swalMsg]);
      }
    }
}
