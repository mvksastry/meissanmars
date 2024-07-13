<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Importing laravel-permission models
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

//models
use Auth;
use App\Models\Teams;
use App\Models\Teamusers;
use App\Models\Teaminvitations;
use App\Models\User;

//traits
use App\Traits\Base;
use App\Traits\Groupidentity;

//uuid
use Illuminate\Support\Str;

//Requests
use App\Http\Requests\TeamsRequest;

class UsersController extends Controller
{
  use Base, Groupidentity;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      //
      $users = User::whereNotIn('role', ["superadmin","manager"])->get();
      return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $roles = Role::whereNotIn('name', ['admin','manager'])->get();
      //dd($roles);
      return view('users.create')->with('roles', $roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if( Auth::user()->hasRole('manager|superadmin') )
        {
      		$newUser = $request->all();
           
          Validator::make($newUser, [
              'name' => ['required', 'string', 'max:55'],
              'email' => ['required', 'string', 'email', 'max:55', 'unique:users'],
              'start_date' => ['required', 'date'],
              'end_date' => ['required', 'after:start_date'],
              'role' => ['required', 'string', 'max:30'],
          ])->validate();
    
            
    
          $newUser['folder'] = $this->generateCode(15); //added by ks
  
          //$newUser['password'] = $this->generateCode(10);
          $newUser['password'] = "secret1234"; //should be loggable
          
          $newUser['uuid'] = Str::uuid()->toString();

          //dd($newUser);
          $newUserResult = User::create([
            'name'        => $newUser['name'],
            'email'       => $newUser['email'],
            'password'    => Hash::make($newUser['password']),
            'folder'      => $newUser['folder'],
            'role'        => $newUser['role'],
            'uuid'        => $newUser['uuid'],
            'start_date'  => $newUser['st_date'],
            'expiry_date' => $newUser['end_date'],
          ]);
            
          //dd($newUser, $newUserResult);
          // now assign Role
          $newUserResult->assignRole('manager');
  
          //now send mail to the newly registered user using registered event
          event(new Registered($newUserResult));
  
          //$users = $this->activeUsers();
          //dd($users);
          $users = User::whereNotIn('role', ['superadmin','manager'])->get();
          return view('users.index')->with([
                      'users'=> $users]);
        }
        else {
          return view('norole.noroleHome');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      if( Auth::user()->hasRole('pient|manager|superadmin') )
      {  //
        $user = User::where('id', $id)->first();
        //dd($user);
        return view('users.show')->with([
                      'user'=> $user]);
      }
      else {
        return view('norole.norolehome');
      }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = User::findOrFail($id);
        
        return view('users.edit')
          ->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $input = $request->all();
      //dd($id, $input);
      $input = $request->only('password', 'inactivate');
      $input['password'] = Hash::make($input['password']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
