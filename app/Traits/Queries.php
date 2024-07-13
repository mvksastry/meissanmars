<?php

namespace App\Traits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Hop;
use App\Models\Path;
use App\Models\User;
use App\Models\Tour;
use App\Models\Employee;
use App\Models\Supervisor;


use App\Models\Communication;
use App\Models\Leave;
use App\Models\Leaverecord;

trait Queries
{
    //
		public function subjectPath($id)
		{
			return Path::where('path_id', $id)->pluck('controller')->first();
		}
		
		public function defaultPath($controller)
		{
			return Path::where('controller', $controller)->pluck('path')->first();
		}
		
		public function currentPath($uuid)
		{
			return Hop::where('uuid', $uuid)->pluck('path')->first();
		}
		
		public function roles()
		{
			return Role::select('id','name')->get();
		}
		
		public function roleIdByName($name)
		{
			return Role::select('id')->where('name', $name)->first();
		}
				
		public function leaveById($id)
		{
			return Leave::where('uuid', $id)->get();
		}
		
		public function commById($id)
		{
			return Communication::where('communication_id', $id)->get();
		}
		
		public function commByUuid($uuid)
		{
			return Communication::where('uuid', $uuid)->get();
		}
		
		public function rhId()
		{
			return Holiday::where('holiday_type', 'rh')->select('holiday_id')->get();
		}
		
		// overlapping dates
		public function overlapingLeaveDates($start_date, $end_date)
		{
			return Leave::where('leave_start', '<', $end_date)
						->where('leave_end', '>', $start_date)
						->where('employee_id', Auth::id())
						->get();
		}
		
		// cumulative balance
		public function cumulativeLeaveBalance($employee_id, $leavetype_id)
		{
			return Leaverecord::where('employee_id', $employee_id)
								->where('eligible_leavetype_id', $leavetype_id)
								->pluck('cumulative_balance')->first();
		}
		
		// overlapping tour dates
		public function overlapingTourDates($start_date, $end_date)
		{
  		 // overlapping dates
			return Tour::where('dep_station_date', '<', $end_date)
						->where('rj_origin_arr_date', '>', $start_date)
						->where('employee_id', Auth::id())
						->get();
		}
		
		public function designationPayscale()
		{
      return Employee::where('employee_id', Auth::id())
										->select('designation', 'basic_pay')
										->get();
                    
			$user = Auth::user();
      
			$role = $user->roles;
			
			foreach($role as $val)
			{
				$role_name = $val->name;
			} 
      
			switch ($role_name) {
				
				case "admin":
						return Employee::where('employee_id', Auth::id())
										->select('designation', 'basic_pay')
										->get();
						break;
						
				case "director":
						return Employee::where('employee_id', Auth::id())
										->select('designation', 'basic_pay')
										->get();
						break;
				
				case "employee":
						return Employee::where('employee_id', Auth::id())
										->select('designation', 'basic_pay')
										->get();
						break;
			}
		}		
}








