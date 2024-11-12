<?php

namespace App\Traits\TCommon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\Iaecassent;
use App\Models\Iaecproject;
use App\Models\Resassent;
use App\Models\Resproject;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

trait ProjectUsers
{

	public function fetchProjectUsers()
	{
		$gM = User::where('role','<>', 'supadmin')->get();
		
		//first get list of group members
		$lo = array(); 
		$lm = array(); 
		$lx = array();
		
		foreach($gM as $val)
		{
			$lo['allowed_id'] = $val->id;
			$lo['name'] = $val->name;
			
			switch ($this->purpose) {
				
				case "resproj":
					$projects = Resassent::with('resproject')->where('allowed_id', $val->id)->get();
				break;
				
				case "iaecproj":
					$projects = Iaecassent::with('projectiaec')->where('allowed_id', $val->id)->get();
				break;
				
				default:
				$projects = [];
			}
			//dd($projects);
			if(count($projects) > 0) 
			{
				foreach($projects as $row)
				{
					if($this->purpose == "resproj")
					{
						$lx['title'] = $row->resproject->title;
						$lx['proj_end_date'] = $row->resproject->end_date;
					}
					
					if($this->purpose == "iaecproj")
					{
						$lx['title'] = $row->projectiaec->title;
						$lx['proj_end_date'] = $row->projectiaec->end_date;
					}

					$lx['tenure_start_date'] = $row->start_date;
					$lx['tenure_end_date'] = $row->end_date;
					$lx['tenure_status'] = $row->status;
					$lx['tablename'] = $row->tablename;
                    Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] project users fetched for prject id [ '.$lx['title'].']');
					array_push($lo, $lx);
					
					unset($lx);
				}
				//dd($lo);
				array_push($lm, $lo);
				unset($lo);
			}
			else {
				$lm = [];
			}
		}
		
		
		return $lm;
	}
}