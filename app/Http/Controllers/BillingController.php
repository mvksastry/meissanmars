<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Cost;
use App\Models\Strain;
use App\Models\Cage;

use App\Models\Project;
use App\Traits\SetPerdiemCost;
use App\Traits\costByProjectId;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class BillingController extends Controller
{
		use HasRoles;
		use SetPerdiemCost;
		use costByProjectId;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $cbp = $this->fetchCostByProjects();
      return view('billing.index')
        ->with('cbp', $cbp);
    }

    public function perdiem()
    {

      $st_info = Cost::with('strain')->with('species')
               //->whereRaw('effective_cost_date = (SELECT MAX(effective_cost_date) FROM costs)')
                ->get();

      $strain_info = Strain::with('species')->with('cost')->get();
      //dd($strain_info);    
      return view('billing.perDiemCostForm')->with('strain_info', $strain_info);
        
    }

    public function setperdiem(Request $request)
    {
      $input = $request->all();
      //dd($input);
      $result = $this->postPerDiemCost($input);
      return redirect()->route('billing.index')
              ->with('flash_message',
               'PerDiem Costs Set!');
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
