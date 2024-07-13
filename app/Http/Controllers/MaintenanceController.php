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
use App\Models\Infrastructure;
use App\Models\Maintenance;

use App\Traits\Fileupload;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class MaintenanceController extends Controller
{
    use Fileupload;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infra = Infrastructure::all();
        return view('facility.maintenance.index')->with('infra', $infra);
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
        $input = $request->all();
        $res1 = Infrastructure::where('name', $input['infname'])->first();
        $res2 = User::where('name', $input['supname'])->first();
        $infraName = $input['infname'];

        if( $request->hasFile('userfile') )
        {
            $request->validate([
                'userfile' => 'required|mimes:pdf|max:4096'
            ]);
            $filename = $this->serviceReportFileUpload($request, $infraName, $res1->infra_id);
            // below only for testing, comment above
            //$filename = "ansdkjweuncjs";
        }

        if(!empty($filename)){
            $msr = new Maintenance();
            $msr->supervisor = $res2->id;
            $msr->infra_id = $res1->infra_id;
            $msr->type =$input['mrsType'];
            $msr->done_date = $input['doneDate'];
            $msr->description = $input['desc'];
            $msr->filename = $filename;

            $msr->save();
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $infra = Infrastructure::with('user')->where('infra_id', $id)->first();
        $mrs = Maintenance::where('infra_id', $id)->get();

        return view('maintenance.show')
                ->with('mrs', $mrs)
                ->with('infra', $infra);
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
