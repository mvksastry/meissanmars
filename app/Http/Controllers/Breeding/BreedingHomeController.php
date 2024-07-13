<?php

namespace App\Http\Controllers\Breeding;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App;
// place breeding models, Traits here.
use App\Models\Breeding\Allele;

use App\Traits\Breed\BBase;

use Illuminate\Support\Facades\Route;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class BreedingHomeController extends Controller
{
  
    //
    use HasRoles;

    use BBase;
    
    public function __construct()
    {
      	//$this->middleware(['role:manager|investigator']);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      if( Auth::user()->hasRole('manager') )
      {
        return view('breeding.manager.bManagerHome');
      }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
