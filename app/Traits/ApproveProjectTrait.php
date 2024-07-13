<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use App\Models\Species;
use App\Models\Strain;
use App\Models\Tempproject;
use App\Models\Tempstrain;

use File;
use App\Traits\Base;
use App\Traits\Notes;
use App\Traits\NewFormDTable;

trait ApproveProjectTrait
{
		use Base;
		use Notes;
		use NewFormDTable;

		public function projectDecision($input, $purpose, $id)
		{
      $today = $this->today();
      $iaec_comments  = strip_tags($input['iaec_comments']);
      $iaecApproveDate = $input['iaecdate'];
      $iaecmeeting = $input['iaecmeeting'];
      $decision    = $input['decision'];
      $iaec_comments = $this->addNotes($iaec_comments, "Project added");
      $mananger = "IAEC decision conveyed";
      $spcomments = $this->addTimeStamp($mananger);
      $tempProj = Tempproject::findOrFail($id);

      if( $decision === 0 )
      {
        $tempProj->comments = $iaec_comments;
        $tempProj->status = 'pending';
        $tempProj->update();
      }


			if( $decision === 1 )
		  {
				$project = new Project();

				$project->iaecproject_id    = $tempProj->temproject_id;
        $project->uuid              = $tempProj->uuid;
				$project->pi_id             = $tempProj->pi_id;
				$project->title             = $tempProj->title;
				$project->start_date        = $tempProj->start_date;
				$project->end_date          = $tempProj->end_date;
				$project->iaec_meeting_info = $iaecmeeting;
				$project->iaec_comments     = $tempProj->iaec_comments;
				$project->comments          = $tempProj->notes;
				$project->filename          = $tempProj->filename;
				$project->date_approved     = $iaecApproveDate;
				$project->status            = 'active';
				$project->formD             = $id."nformD";
        $project->notebook          = $id."notebook";
				$project->save();

				// copy entries from tempstrains to projectstrains
				$tempstrains = Tempstran::where('tempproject_id', $id)->get();

				foreach($tempstrains as $entry)
				{
          $projstrain = new Projectstrain();
          $projstrain->project_id 		= $id;
          $projstrain->species_id 		= $entry->species_id;
          $projstrain->strain_id  		= $entry->strain_id;
          $projstrain->total_allyears = $entry->total_allyears;
          $projstrain->year1 					= $entry->year1;
          $projstrain->year2 					= $entry->year2;
          $projstrain->year3 					= $entry->year3;
          $projstrain->year4 					= $entry->year4;
          $projstrain->year5 					= $entry->year5;
          $projstrain->save();
          $tempproject = Tempstrain::where('projstrain_id', $entry->projstrain_id)
                                          ->delete();
				}

				Tempproject::where('tempproject_id', $id)->delete();
				//now create the new formd table.
				// If it is new project approval, create formD, for amendment, do not
				// execute formD table creation as it will delete the running formD
				// table. so now check for new or amendment.
				if($purpose == "new")
				{
					$res = $this->makeFormDNoteBookTables($id);
				}
			}

			return true;
		}

}
