<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;

trait Base
{

	public function today()
	{
		return date('Y-m-d');
	}

	public function currentYear()
	{
		return date('Y');
	}

	public function daysBetween($start, $end)
	{
		$start = new \DateTime($start);

		$end = new \DateTime($end);

		return $start->diff($end)->days;

	}
	
	public function monthsBetweenTwoDates($startDate, $endDate)
	{

    $ts1 = strtotime($startDate);
    $ts2 = strtotime($endDate);
    
    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);
    
    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);

    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
    
    return $diff;
	}
  
  public function addWeeksToDate($duration)
  {
    $phrase = "+".$duration." weeks";
    
    $weeksLaterDate = date('Y-m-d', strtotime($phrase));
    
    return $weeksLaterDate;
  }

	public function weekDaysBetweenTwoDates($startDate, $endDate)
	{
    // input start and end date
    //$startDate = "01-01-2018";
    //$endDate = "01-01-2019";

    $resultDays = array('Monday' => 0,
      'Tuesday' => 0,
      'Wednesday' => 0,
      'Thursday' => 0,
      'Friday' => 0,
      'Saturday' => 0,
      'Sunday' => 0);

    // change string to date time object
    $startDate = new DateTime($startDate);
    $endDate = new DateTime($endDate);

    // iterate over start to end date
    while($startDate <= $endDate )
    {
      // find the timestamp value of start date
      $timestamp = strtotime($startDate->format('d-m-Y'));

      // find out the day for timestamp and increase particular day
      $weekDay = date('l', $timestamp);
      $resultDays[$weekDay] = $resultDays[$weekDay] + 1;

      // increase startDate by 1
      $startDate->modify('+1 day');
    }
  	return $resultDays;
	}

  public function currentYearStartDate($start_date)
  {
     $today = date("Y-m-d");
     $start_date_val = strtotime($start_date);
     $cur_date_val = strtotime($today);
     $diff_time =  $cur_date_val -  $start_date_val;
     $diff_years = floor(($diff_time/86400)/364);
     $var = "+".$diff_years." year";
     $cur_year_start = date('Y-m-d', strtotime(  $var, strtotime($start_date)));
     return $cur_year_start;
  }

	//All folder checks and makigs here

	public function getFolderPath()
	{
		//return app(\Hyn\Tenancy\Website\Directory::class)->path();
	}

	public function getRole()
	{
		$user = Auth::user();
		$role = $user->roles;
		foreach($role as $val)
    {
			$role_name = $val->name;
		}
		return $role_name;
	}

	public function getGuard()
	{
		$user = Auth::user();
		$role = $user->roles;
		foreach($role as $val) {
				$guard = $val->guard_name;
		}
		return $guard;
	}

	public function roleFolder()
	{
		$role = $this->getRole();

		switch ($role) {

			case "pisg":
				return "institution/";
            break;
    
			case "pilg":
				return "institution/";
            break;
    
			case "piblg":
				return "institution/";
            break;
    
			case "pient":
				return "institution/";
            break;
    
			case "investigator":
				return "institution/";
            break;
    
			case "manager":
				return "institution/manager";
            break;
    
			case "admin":
				return "institution/office";
            break;
    
			default:
				return "institution/misc";
		}
	}

	public function researcherFolder($id)
	{

		return Researcher::where('researcher_id', $id)->pluck('folder')->first();

	}

	public function generateCode($length)
  {
    $string = '';
    // You can define your own characters here.
    $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnoipqrstuvwxyz0123456789";
    for ($p = 0; $p < $length; $p++) 
    {
      $string .= $characters[mt_rand(0, strlen($characters)-1)];
    }
    return $string;
  }

	public function mergeDateAndTime($date, $time)
	{
		$datex = new DateTime($date);
		$timex = new DateTime($time);

		// Solution 1, merge objects to new object:
		$merge = new DateTime($datex->format('Y-m-d').' '.$timex->format('H:i:s'));

		return $merge->format('Y-m-d H:i:s');
	}

	public function finYear()
	{
		$yeara = ( date('m') > 3) ? date('Y') : date('Y') + 1;
		$yearb = ( date('m') > 3) ? date('y') : date('y') + 1;
		$year = $yeara.'_'.($yearb + 1);
		return $year;
	}

}
