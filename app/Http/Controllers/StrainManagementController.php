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
use App\Models\Strain;
use App\Models\Species;
use App\Models\Cost;

use App\Traits\StrainsNewProject;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

//Uuid import class
use Illuminate\Support\Str;

class StrainManagementController extends Controller
{
    use HasRoles;
    use StrainsNewProject; 
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      if( Auth::user()->hasAnyRole('pisg','pilg','piblg', 'manager') )
      {
        $species = Species::all();

        $strains = Strain::with('species')->with('user')->get();
        /*
            $strains = Strain::with('species')->where('distributable', 'yes')->whereHas('user', function($q){
             $q->where('role','=','pisg');
            })->get();
        */
        // This is also valid function use if the above not working

        //$strains = $this->strainsAllowedEnterprise();
        $users = User::role('pient')->get();

        return view('facility.strains.index')
               // ->with('species', $species)
               // ->with('users', $users)
                ->with('strains', $strains);
        //
        //return view('strains.strainManageHome');
      }
      else {
        return view('errors.error401');
      }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      if( Auth::user()->hasAnyRole('manager') )
      {
          
        $species = Species::all();
        
        $strains = Strain::with('species')->with('user')->groupBy('species_id');
       
        return view('facility.strains.create')
          ->with('species', $species)
          ->with('strains', $strains);
      }
      else {
        return view('errors.error401');
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changestatus()
    {
      if( Auth::user()->hasAnyRole('pisg','manager') )
      {
        $species = Species::all();
        
        $strains = Strain::with('species')->with('user')->get();
        
        $users = User::where('role', 'pient')->get();
        
        return view('facility.strains.bulkEditForm')
                  ->with('species', $species)
                  ->with('users', $users)
                  ->with('strains', $strains);
      }
      else {
        return view('errors.error401');
      }
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      if( Auth::user()->hasAnyRole('pisg', 'manager') )
      {
          $input = $request->all();
      
              //Validate name and permissions field
              $this->validate($request, [
                'species_id' => 'required|numeric|min:1',
                'strain_name' => 'required|regex:/^[a-zA-Z\s0-9-_.\/]*$/|max:50',
                'notes' => 'nullable|regex:/^[a-zA-Z\s0-9_-]*$/|max:200',
                'dist' => 'required|numeric|min:1|max:2',
                'perDiemCost' => 'required|numeric|min:0.00'
              ]);
      
          $newStrain = new Strain();
          $newStrain->uuid = Str::uuid()->toString();
          $newStrain->species_id = $input['species_id'];
          $newStrain->strain_name = $input['strain_name'];
      
          if($input['dist'] == 1)
          {
            $newStrain->distributable = 'yes';
            $newStrain->owner_id = 0;
          }
          else {
            $newStrain->distributable = 'no';
            $newStrain->owner_id = 0; // correct it with actual user id
          }
          $newStrain->notes = $input['notes'];
          //dd($newStrain);
          $newStrain->save();
      
          $newStrainCost = new Cost();
      
          $newStrainCost->strain_id = $newStrain->strain_id;
          $newStrainCost->species_id = $input['species_id'];
          $newStrainCost->effective_cost_date = date('Y-m-d');
          $newStrainCost->per_diem_cost = $input['perDiemCost'];
      
          $newStrainCost->save();
      
              return redirect()->route('strains.index')
              ->with('flash_message',
               'Strains added!');
      }
      else {
        return view('errors.error401');
      }
        //
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
      if( Auth::user()->hasAnyRole('pient','manager') )
      {
       
        $strain = Strain::findOrfail($id);
        $users = User::all();
        //dd($strain);
        return view('facility.strains.edit')
        ->with('strain', $strain)
        ->with('users', $users);
      }
    }

    public function updatestatus(Request $request)
    {
      if( Auth::user()->hasAnyRole('pisg','pilg','piblg', 'manager') )
      {
        $input = $request->all();
        $checkedStrainsIds = $input['strain_id'];
        $statusDist = $input['dist'];
        $statusOwner = $input['owner'];

        //dd($input);

        foreach($checkedStrainsIds as $key => $val)
        {
          $owner = null;

          $updStatStrain = Strain::where('strain_id', $val)->first();

          foreach($statusDist as $xval)
          {
            $dx = explode("_", $xval);
            if(intval($dx[0]) == intval($val))
            {
              $dist = $dx[1];
            }
          }
           
          foreach($statusOwner as $yval)
          {
            if($yval != 0)
            {
              $dy = explode("_", $yval);
            if(intval($dy[0]) == intval($val))
            {
              $owner = $dy[1];
            }
            }
          }
           
           
          if( $dist == 1)
          {
            $dist = "yes";
          }
          else {
            $dist = "no";
          }

          if($owner == null)
          {
            $owner = 0;
          }

          $updStatStrain->update([
            'distributable' => $dist,
            'owner_id' => $owner]);
        }
        //get the strain box
        //complete the code part of interface
        return redirect()->route('strains.index')
                ->with('flash_message',
                 'Strains Updated!');
      }
      else {
        return view('errors.error401');
      }

    }
  
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      if( Auth::user()->hasAnyRole('pisg','piblg', 'manager') )
      {
        $input = $request->all();
        $checkedStrainsIds = $input['strain_id'];
        $statusDist = $input['dist'];
        $statusOwner = $input['owner'];

        //dd($input);

        foreach($checkedStrainsIds as $key => $val)
        {
          $owner = null;

          $updStatStrain = Strain::where('strain_id', $val)->first();

          foreach($statusDist as $xval)
          {
            $dx = explode("_", $xval);
            if(intval($dx[0]) == intval($val))
            {
              $dist = $dx[1];
            }
          }
           
          foreach($statusOwner as $yval)
          {
            if($yval != 0)
            {
              $dy = explode("_", $yval);
            if(intval($dy[0]) == intval($val))
            {
              $owner = $dy[1];
            }
            }
          }
           
           
          if( $dist == 1)
          {
            $dist = "yes";
          }
          else {
            $dist = "no";
          }

          if($owner == null)
          {
            $owner = 0;
          }

          $updStatStrain->update([
            'distributable' => $dist,
            'owner_id' => $owner]);
        }
        //get the strain box
        //complete the code part of interface
        return redirect()->route('strains.index')
                ->with('flash_message',
                 'Strains Updated!');
      }
      else {
        return view('errors.error401');
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
