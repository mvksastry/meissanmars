<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Group;
use App\Models\Assent;

trait Assents
{
		/**
     * Check file validity and move to uploads folder
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return boolean
     */
    public function addMemberToProject($input)
    {
      		//first check if he is already a member of this
      		$resx = Assent::where('project_id', $input['project_id'] )
      										->where('allowed_id', $input['allowed_id'])
      										->get();

      		if($resx->count() == 0)
      		{
        			//no, rows, new insert query
        			$newAssent = new Assent();
        			$newAssent->project_id = $input['project_id'];
        			$newAssent->allowed_id = $input['allowed_id'];
        			$newAssent->start_date = $input['start_date'];
        			$newAssent->end_date   = $input['end_date'];
        			$newAssent->tablename  = $input['tablename'];
        			$newAssent->status     = $input['status'];
        			$newAssent->save();
      		}
      		else {
        			foreach($resx as $row){
        				Assent::where('assent_id', $row->assent_id)->update($input);
        			}
      		}
      		return true;
      }
}
