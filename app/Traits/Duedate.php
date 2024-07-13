<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use DateTime;

use App\Models\Researcher;
use App\Models\Registration;


trait Duedate
{
    //
	public function reportDue($researcher_id)
	{
		//$regStartDate = "2019-01-1"; // use this testing, actual is regstart Date
		
		$reqDate = Registration::where('researcher_id', $researcher_id)->pluck('request_date')->first();
		
		$approvalDate = Registration::where('researcher_id', $researcher_id)->pluck('approval_date')->first();
		
		if($approvalDate == null)
		{
			if($reqDate == null)
			{
				$regStartDate = date('Y-m-d');
			}
			else {
				$regStartDate = $reqDate;
			}
		}
		else {
			$regStartDate = $approvalDate;
		}
				
		$d1 = new DateTime($regStartDate);
		$d2 = new DateTime(date('Y-m-d'));

		$interval = $d2->diff($d1);
		
		$months = $interval->m + ($interval->y * 12);
		
		if($months == 0)
		{
			$repDue = 1;
			$remainder = 6;
		}
		else {
			$repDue = intdiv($months, 6) + 1;
			$remainder = $months % 6;
		}
		
		return "Report # ".$repDue." due in ". $remainder. " months";
				
	}
}