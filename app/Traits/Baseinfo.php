<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;

trait Baseinfo
{
	//protected $user;
	
    //
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
		
	public function weekDaysBetweenTwoDates($startDate, $endDate)
	{
		// input start and end date 
		//$startDate = "01-01-2018"; 
		//$endDate = "01-01-2019"; 
  
		$resultDays = array(
			'Monday' => 0, 
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
	//All folder checks and makigs here
				
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
		foreach($role as $val) 
		{
			$guard = $val->guard_name; 
		}
		return $guard;
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
		
	public function makeCommitteeArray($input)
	{
		$com = array();
		$meetGroup = array();
		$members = array();
		foreach($input as $row)
		{
			foreach($row as $dx)
			{
				foreach($row->committees as $valx)
				{
					$mem['committee_id'] = $row->committees->committee_id;
					$mem['title'] = $row->committees->title;
					$mem['mandate'] = $row->committees->mandate;
					$mem['agenda'] = $row->committees->agenda;
					$mem['start_date'] = $row->committees->start_date;
					$mem['end_date'] = $row->committees->end_date;
					$mem['status'] = $row->committees->status;
					$mem['uuid'] = $row->committees->uuid;
					$mem['notes'] = $row->committees->notes;
				}
			}
			
			foreach($row->panel as $val)
			{
				if($val->name2 == "Chairman")
				{
					$mem['chair'] = $val->name1;
				}
				if($val->name2 == "Secretary")
				{
					$mem['sec'] = $val->name1;
				}
				
				if($val->name2 == "Convener")
				{
					$mem['conv'] = $val->name1;
				}
				
				if($val->name2 == "Member")
				{
					$mem['memb'][] = $val->name1;
				}
				
			}
			
			if(in_array(Auth::user()->name, $mem) || in_array(Auth::user()->name, $mem['memb']))
			{
				$mem['takePart'] = "yes";
			}
			else {
				$mem['takePart'] = "no";
			}
			
			array_push($meetGroup, $mem);
			unset($mem);
		}
		return $meetGroup;
	}
			
	public function roleFolder()
	{
		$name = $this->getRole();
    
		switch ($name) {
			
			case "researcher":
				return "media/researchers";
			break;
			
			case "employee":
				return "media/employees";
			break;
			
			case "supervisor":
				return "media/supervisors";
			break;
			
			case "staff":
				return "media/staff";
			break;
			
			case "admin":
				return "media/office";
			break;
			
			case "tours":
				return "media/office/tours";
			break;
			
			case "communications":
				return "media/office/communications";
			break;
							   
			default:
				return "media/misc";
		}
	}		
		
	public function checkFolder($name)
  {
    //the $name can consist of subfolder and actual folder.
    $base = "/tenancy/tenants/";
    $folderPath = $base.$this->getTenantFolder().$name;

    if($this->makeFolder($folderPath))
    {
      return $folderPath;
    }
    else {
      //this false should ideally throw an exception 
      //which should be caught. it should never return false
      return false;
    }
  }
		
	public function makeFolder($folderPath)
  {
      if(File::isDirectory($folderPath))
      {
          return true;
      }
      else {
          File::makeDirectory($folderPath, 0777, true, true);
          return true;
      }
  }
    
  public function conditions()
  {
    $condChoices = array("1" => "Open", "2" => "Invitees Only", "3"=>"Group Only", "4"=>"Meeting");
    return $condChoices;
  }
  
  public function timeSpanArray()
  {
		$timespans = array( 
			"1"  => "06:00",  "2" => "06:30",  "3" => "07:00",  "4" => "07:30", "5"  => "08:00",
			"6"  => "08:30",  "7" => "06:00",  "8" => "06:30",  "9" => "07:00", "10" => "07:30",
			"11" => "08:00", "12" => "08:30",	"13" => "09:00", "14" => "09:30", "15" => "10:00", 
			"16" => "10:30", "17" => "11:00",	"18" => "11:30", "19" => "12:00", "20" => "12:30", 
			"21" => "13:00", "22" => "13:30",	"23" => "14:00", "24" => "14:30",	"25" => "15:00", 
      "26" => "15:30", "27" => "16:00", "28" => "16:30", "29" => "17:00", "30" => "15:30",
			"31" => "17:00", "32" => "18:30", "33" => "19:00", "34" => "19:30", "35" => "20:00",
      "36" => "20:30"
			);
    return $timespans;
  }
	
}