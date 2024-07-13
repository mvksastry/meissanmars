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
use App\Models\Project;
use App\Models\Usage;

use App\Traits\AccordIssueDecision;

use App\Http\Requests\UsageApprovalRequest;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class UsagesController extends Controller
{
	use HasRoles;

	use AccordIssueDecision;

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
      $issueRequests = Usage::with('user')
                  ->with('species')
                  ->with('strain')
                  ->where('issue_status', 'confirmed')
                  ->get();
                  
      $irAwaiting = Usage::with('user')
                  ->with('species')
                  ->with('strain')
                  ->where('issue_status', 'approved')
                  ->get();

      return view('usage.adminIssueIndex')
                ->with(['issueRequests'=>$issueRequests,
                        'irAwaiting'=>$irAwaiting ]);
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
      $issueRequests = Usage::with('user')
                  ->with('species')
                  ->with('strain')
                  ->where('issue_status', 'confirmed')
                  ->where('issue_id', $id)
                  ->get();

      return view('usage.adminIssueDecision')
                ->with(['issueRequests'=>$issueRequests]);
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
      $result = Usage::findOrFail($id);

      if( $result != null )
      {
        $input = $request->validated();
        $input['issue_id'] = $id;
        $msg = $this->approveUsageRequest($input);
        }
        
      return redirect()->route('usageapproval.index')
                      ->with('flash_message', $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
