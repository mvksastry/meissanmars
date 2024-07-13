<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class RolesController extends Controller
{
  	public function __construct() {
		//  $this->middleware(['auth']); 
    //  $this->middleware(['auth', 'isAdmin']);
		//  isAdmin middleware lets only users with a 
		//  specific permission permission to access these resources
    //  $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
    //  $this->middleware('permission:role-create', ['only' => ['create','store']]);
    //  $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
    //  $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      //
      $roles = Role::orderBy('id', 'DESC')->paginate(15);//Get all roles
      return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $permissions = Permission::pluck('name', 'id');//Get all permissions
      return view('roles.create', compact('permissions'));  //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      //Validate name and permissions field
 
      $this->validate($request, [
          'name'=>'required|unique:roles|max:15',
          'perms' =>'required|array',
      ]);
        
      $perms = $request['perms'];
      $roleName = $request['name'];
      //dd($perms, $name);
      
      $role = Role::create(['name' => $roleName]);
      $role->syncPermissions($perms);
   
      // Looping thru selected permissions
      //foreach ($perms as $permission) 
      //{
      //   $p = Permission::where('id', '=', $permission)->firstOrFail(); 
      // Fetch the newly created role and assign permission
      //    $role = Role::where('name', '=', $name)->first(); 
      //    $role->givePermissionTo($p);
      //}

      return redirect()->route('roles.index')
            ->with('flash_message',
             'Role'. $role->name.' added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $role = Role::find($id);
      $rolePermissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', 'permissions.id')
                        ->where('role_has_permissions.role_id',$id)
                        ->get();
    
      return view('roles.show', compact('role', 'rolePermissions'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
      $role = Role::findOrFail($id);
      $permissions = Permission::pluck('name', 'id');
      $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
    
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
      //dd($role, $permissions);
      //return view('roles.edit', compact('role', 'permissions'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $this->validate($request, [
        'name'=>'required',
        'permissions' =>'required|array|between:1,50',
      ]);
      
      $role = Role::findOrFail($id);//Get role with the given id
      
      $curPerms = $role->permissions;

      if(count($curPerms) > 0)
      {
        foreach($curPerms as $row)
        {
          $curPermId[] = $row->id;
        }
      }
      else {
        $curPermId = [];
      }

      $permSelected = $request['permissions'];    

      $diffPerms = array_diff($permSelected, $curPermId);
      
      $permNames = Permission::whereIn('id', $diffPerms)->pluck('name');
        
      $role->givePermissionTo($permNames); 
        
      $newSyncedPerms = $role->permissions;
      
      //dd($curPermId, $permSelected, $diffPerms, $permNames, $newSyncedPerms);
     
      return redirect()->route('roles.index')
          ->with('flash_message',
           'Role'. $role->name.' updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $role = Role::findOrFail($id);
      $role->delete();

      return redirect()->route('roles.index')
            ->with('flash_message',
             'Role deleted!');
    }
}
