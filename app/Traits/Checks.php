<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Hop;
use App\Models\Path;
use App\Models\User;


trait Checks
{
  //
	public function leaveConditionChecks($input)
	{
		$suspension = "false";

		$result['check'] = false;
			
		// overlapping dates
		$res = $this->overlapingLeaveDates($input['leave_start'], $input['leave_end']); 
			
		$cumulativeBalance = $this->cumulativeLeaveBalance($input['employee_id'], $input['leavetype_id']);
							
		if( strtotime($input['leave_end']) < strtotime($input['leave_start']) )
		{
			$result['message'] =  "End Date is earlier than Start Date";
			return $result;
		}	
																
		if($cumulativeBalance < $this->numberOfDays($input))
		{
			$result['message'] =  "No Leave Balance";
			return $result;
		}

		if( count($res) > 0 )
		{
			$result['message'] =  "Found One Request With Overlapping Dates";
			return $result;
		}	

		if(strtotime($input['leave_end']) < strtotime($input['leave_start']))
		{		
			$result['message'] =  "Start/End dates cannot be earlier than today";
			return $result;
		}
			
		if(!$suspension)
		{
			$result['message'] =  "Application rejected due to suspension rule";
			return $result;
		}	
						
		$result['check'] = true;
		return $result;
			
	}
		
	public function numberOfDays($input)
	{
		//calculate number of days leave applied
		$numDays = $this->daysBetween($input['leave_start'], $input['leave_end']);
			
		//the following three ifs will work only for casual leave
		if($input['leave_end_session'] == "afternoon")
		{
			$numDays = $numDays + 1;
		}
			
		if($input['leave_end_session'] == "forenoon")
		{
			$numDays = $numDays + 0.5;
		}
			
		if($input['leave_start_session'] == "afternoon")
		{
			$numDays = $numDays - 0.5;
		}
		return $numDays;
	}
		
	public function totalSatSunInLeave($start_date, $end_date)
	{
		$satSunCheck = $this->weekDaysBetweenTwoDates($start_date, $end_date);

		return ($satSunCheck['Saturday'] + $satSunCheck['Sunday']);					
	}
				
	public function tourProposalChecks($input)
	{
		$result['check'] = false;
		// overlapping dates
		$res = $this->overlapingTourDates($input['dep_station_date'], $input['rj_origin_arr_date']);
		
		if( count($res) > 0 )
		{
			$result['message'] =  "Found One Request With Overlapping Dates";
			return $result;
		}
		
		//check dates for ealier and later for departure and arrival
		if( strtotime($input['dep_station_date']) > strtotime($input['dest_arr_date']) ||
				strtotime($input['dep_station_date']) > strtotime($input['rj_station_date']) ||
				strtotime($input['dep_station_date']) > strtotime($input['rj_origin_arr_date']) )
		{
			$result['message'] =  "Departure date is later than other journey dates";
			return $result;				
		}
		
    $rjArrTime = $this->mergeDateAndTime($input['rj_origin_arr_date'], $input['rj_origin_arr_time']);
    $rjDepTime = $this->mergeDateAndTime($input['rj_station_date'], $input['rj_station_time']);

		//check dates for ealier and later for departure and arrival
		if( strtotime($rjArrTime) <= strtotime($rjDepTime) )
		{
      $result['message'] =  "Return Journey Dates are wrong";
			return $result;			
		}
		
		//check whether a tour is already posed with same dates.
		if( count($res) > 0 )
		{
			$result['message'] =  "One Pending Tour Application, Overlapping the sames dates";
			return $result;
		}	
		
		$result['check'] = true;
		
		return $result;
		
	}
}










