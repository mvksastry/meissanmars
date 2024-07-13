<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Session;

class PermissionsController extends Controller
{
  public function __construct() 
	{
    $this->middleware(['auth']); 
    // isAdmin middleware lets only users with a 
    // specific permission permission to access these resources
    //   $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index','store']]);
    //   $this->middleware('permission:permission-create', ['only' => ['create','store']]);
    //   $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
    //   $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
  }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      //
      $permissions = Permission::orderBy('id','ASC')->paginate(50); //Get all permissions
      return view('permissions.index', compact('permissions'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $roles = Role::get(); //Get all roles
      return view('permissions.create')->with('roles', $roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      //
      $this->validate($request, [
            'permission_name'=>'required|max:40',
      ]);

      //Permission::create(['name' => $request->input('name')]);
      
      $name = $request['permission_name'];
      $permission = new Permission();
      $permission->name = $name;
      $permission->save();
      
      $roles = $request['roles'];

      if (!empty($request['roles'])) 
      { //If one or more role is selected
        foreach ($roles as $role) 
        {
          $r = Role::where('id', '=', $role)->firstOrFail(); //Match input role to db record

          $permission = Permission::where('name', '=', $name)->first(); //Match input //permission to db record
          $r->givePermissionTo($permission);
        }
      }

      return redirect()->route('permissions.index')
            ->with('flash_message',
             'Permission'. $permission->name.' added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $permission = Permission::find($id);
      return view('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      $permission = Permission::findOrFail($id);
      return view('permissions.edit', compact('permission'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $this->validate($request, [
        'name'=>'required|max:40',
      ]);
      $permission = Permission::findOrFail($id);

      $input = $request->all();
      $permission->fill($input)->save();
      return redirect()->route('permissions.index')
          ->with('flash_message',
           'Permission'. $permission->name.' updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      //
      $permission = Permission::findOrFail($id);

      //Make it impossible to delete this specific permission    
      if ($permission->name == "admin") 
      {
        return redirect()->route('permissions.index')
        ->with('flash_message',
        'Cannot delete this Permission!');
      }
      else 
      {
        $permission->delete();

        return redirect()->route('permissions.index')
          ->with('flash_message',
          'Permission deleted!');
      }
    }
}
