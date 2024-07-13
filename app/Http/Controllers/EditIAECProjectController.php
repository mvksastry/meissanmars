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

class EditIAECProjectController extends Controller
{
  use Fileupload, ProjectSubmission;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
      $input = $request->all();
      //dd($input);
      if( Auth::user()->hasAnyRole('pisg','pient','manager') )
      {
        $purpose = "edit";
        $tempproject = Tempproject::findOrFail($id);
        $input = $request->validated();
        // check for input file, if present upload it.
        if( $request->hasFile('userfile') )
        {
          $request->validate([
            'userfile' => 'required|mimes:pdf|max:4096'
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
          }
          else {
            $result = "not exists";
          }
          $filename = $this->projFileUpload($request);
        }

        //last line to execute before returning.
        $result = $this->postProjectData($request, $purpose, $id, $filename);
        $oldNotes = $tempproject->notes;
        $newNotes = "Edited project submitted";
        $tempproject->notes = $this->addNotes($oldNotes, $newNotes);
        $tempproject->update();

        return redirect()->route('projectsmanager.index')
        ->with('flash_message',	$fm);
      }
    }
}
