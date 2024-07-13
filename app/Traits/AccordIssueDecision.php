<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\Usage;
use App\Models\Project;
use App\Models\Projectstrains;

use App\Traits\Base;
use App\Traits\Notes;
use App\Traits\FormDEntryAdmin;

trait AccordIssueDecision
{
	use Base;
	use Notes;
	use	FormDEntryAdmin;

	public function approveUsageRequest($input)
	{
	    
		switch ($input['decision']) {
		    
		case 0:
			$irq = Usage::findOrfail($input['usage_id']);
			$irq->remarks = $input['remarks'];
      $irq->update();
			$msg = "Remarks Posted, Usage Approval Pending";
			return $msg;
		break;

		case 1:
			$input['remarks'] = $this->addNotes(strip_tags($input['remarks']), "Usage Approved");
			$input['remarks'] = $this->addTimeStamp("Approved");

			$issueRequest = Usage::with('user')
								->with('species')
								->with('strain')
								->where('issue_status', 'confirmed')
								->where('usage_id', $input['usage_id'])
								->get();

			$sql['remarks'] = $input['remarks'];
			$sql['status_date'] = date('Y-m-d');
			$sql['issue_status'] = 'approved';
			$res = Usage::where('usage_id', $input['usage_id'])->update($sql);
			
      // now make entry in Form-D table
			$result = $this->enterFormD($issueRequest, $input);
			$msg = "Usage ID:".$input['usage_id']." Approved";
			return $msg;
		break;

		default:
			$msg = "Form Data Tampered";
			return $msg;
		}

	}

}
