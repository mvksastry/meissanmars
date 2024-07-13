<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Storage;

//use App\Models\Species;
use App\Models\Iaecassent;
use App\Models\Tempproject;
use App\Models\Tempstrain;
use App\Models\Iaecproject;
use App\Models\Projectstrains;

//use File;
use App\Traits\Base;
use App\Traits\Notes;
use App\Traits\NewFormDTable;


trait ProjectDecision
{
	use Base;
	use Notes;
	use NewFormDTable;
  

	public function accordDecision($input)
	{
		$input['iaec_comments'] = $this->addNotes(strip_tags($input['iaec_comments']), "Project added");
		$input['spcomments'] = $this->addTimeStamp("IAEC decision conveyed");
		$tempProj = Tempproject::findOrFail($input['id']);

		$newProject_id = Iaecproject::max('iaecproject_id') + 1;

		switch ($input['iaec_decision']) {

			case 0:
				$tempProj->comments = $iaec_comments;
				$tempProj->status = 'pending';
      			$tempProj->update();
				$msg = "Project Pending: Please see IAEC comments";
				return $msg;
			break;

			case 1:
				$project = new Iaecproject();
				$project->iaecproject_id    = $newProject_id;
        $project->uuid              = $tempProj->uuid;
				$project->pi_id             = $tempProj->pi_id;
				$project->title             = $tempProj->title;
				$project->start_date        = $tempProj->start_date;
				$project->end_date          = $tempProj->end_date;
				$project->iaec_meeting_info = $input['iaec_meeting'];
        $project->iaec_approval_ref = $input['iaec_app_ref'];
				$project->iaec_comments     = $tempProj->iaec_comments.';;;'.$input['iaec_comments'];
				$project->comments          = $tempProj->notes;
				$project->filename          = $tempProj->filename;
				$project->date_approved     = $input['iaec_date'];
				$project->status            = 'active';
				$project->formD             = $newProject_id."formd";
        $project->notebook          = $newProject_id."notebook";
				//dd($project);
				$project->save();

				// copy entries from tempstrains to projectstrains
				$tempstrains = Tempstrain::where('tempproject_id', $input['id'])->get();
				//dd($tempstrains);

				foreach($tempstrains as $entry)
				{
					$projstrain = new Projectstrains();
					$projstrain->iaecproject_id 	= $newProject_id;
					$projstrain->species_id 	    = $entry->species_id;
					$projstrain->strain_id  	    = $entry->strain_id;
					$projstrain->allyearstotal    = $entry->allyearstotal;
					$projstrain->year1 			      = $entry->year1;
					$projstrain->year2 			      = $entry->year2;
					$projstrain->year3 			      = $entry->year3;
					$projstrain->year4 			      = $entry->year4;
					$projstrain->year5 			      = $entry->year5;
					//dd($projstrain);
					$projstrain->save();
					
					//now delete the temp strains in the table one by one.
					$tempproject = Tempstrain::where('projstrain_id', $entry->projstrain_id)->delete();
				}
				
				//inser permissions here
				$newAssent = new Iaecassent();
				$newAssent->iaecproject_id =  $newProject_id;
				$newAssent->allowed_id = $project->pi_id;
				$newAssent->start_date = $tempProj->start_date;
				$newAssent->end_date   = $tempProj->end_date;
				$newAssent->status     = 1;
        $newAssent->formd      = $newProject_id."formd";
				$newAssent->notebook   = $newProject_id."notebook";
				//dd($newAssent);
				$newAssent->save();

				// now delete the project entry of tempprojects table
				// no trace of old submission should be present.
				$result = Tempproject::where('tempproject_id', $input['id'])->delete();

				//now create the new Notebook table.
				// If it is new project approval, create Notebook.
				// For amendment, do NOT execute Notebook table creation
				// as it will delete the running Notebook table.
				// so now check for new or amendment.
				
				if($input['NBformD'] == "yes")
				{
					$res = $this->makeFormDNoteBookTables($newProject_id);
				}
				$msg = "Project ".$newProject_id." Created";

				return $msg;
			break;
			
			default:
			    $msg = "No changes made";
			    return $msg;
		}
	}
}
