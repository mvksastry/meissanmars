<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Tempproject;

use App\Traits\Fileupload;
use App\Traits\ProjectSubmission;
use App\Traits\DeleteOldFile;

class EditIAECProjectController extends Controller
{
  use Fileupload, DeleteOldFile, ProjectSubmission;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
      $input = $request->all();
			$id = $input['tempproject_idx'];
      //dd($input);
      if( Auth::user()->hasAnyRole('pisg','pient','manager') )
      {
        $purpose = "edit";
        $tempproject = Tempproject::findOrFail($id);
				//dd($tempproject);
        //$input = $request->validated();
				
				$this->validate($request, [
					'title'      => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/|max:200',
					'start_date' => 'required|date|date_format:Y-m-d',
					'end_date'   => 'required|date|date_format:Y-m-d|after:start_date',
					'species'    => 'present|array',
					'exp_strain' => 'present|array',
					'spcomments' => 'nullable|regex:/(^[A-Za-z0-9 -_]+$)+/',
				]);
				
        // check for input file, if present upload it.
        if( $request->hasFile('projfile') )
        {
          $request->validate([
            'projfile' => 'required|mimes:pdf|max:4096'
          ]);
          // delete old project file
          // get folder name from db, for testing use below
          $instns = "/institutions/";
          $piFolder = Auth::user()->folder;
          $file_path = $instns.$piFolder.'/';

          $oldFileName = $tempproject->filename;

          if(	$this->OldFileDelete($piFolder, $oldFileName) ) 
          {
            $result = "file present";
						//dd("file present");
          }
          else {
            $result = "not exists";
						//dd("file not present");
          }
					
          $filename = $this->projFileUpload($request);
        }

        //last line to execute before returning.
        $result = $this->postProjectData($request, $purpose, $id, $filename);
        $oldNotes = $tempproject->notes;
        $newNotes = "Edited project submitted";
        $tempproject->notes = $this->addNotes($oldNotes, $newNotes);
        $tempproject->update();

				if( Auth::user()->hasRole('manager') )
				{
					return redirect()->route('projectsmanager.index')
								->with('success',
										'Project Edited Successfully');
				}
				
				if( Auth::user()->hasRole('pient') )
				{
					return redirect()->route('home')
								->with('success',
										'Project Edited Successfully');
				}
        //return redirect()->route('projectsmanager.index')
        //->with('flash_message',	$fm);
      }
    }
}
