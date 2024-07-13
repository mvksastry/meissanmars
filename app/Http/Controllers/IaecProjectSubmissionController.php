<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Traits\Fileupload;
use App\Traits\ProjectSubmission;

class IaecProjectSubmissionController extends Controller
{
  use Fileupload, ProjectSubmission;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if( Auth::user()->hasAnyRole('pient','manager') )
        {
          $input = $request->all();  

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
              'projfile' => 'required|mimes:pdf|max:4096'
            ]);
            
            $filename = $this->projFileUpload($request);
            // for testing uncomment below and comment above
            //$filename = "abvdedfadklj";
          }
          else {
            session()->flash("error", "Project File Not Attached!");
            return redirect()->back()->withErrors(['errors' => 'Project File Not Attached!']);;
          }
      
          $result = $this->postProjectData($request, $purpose, $id, $filename);
          
          return redirect()->route('projectsmanager.index')
                  ->with('success',
                      'New Project Posted Successfully.');
        }
        
    }
}
