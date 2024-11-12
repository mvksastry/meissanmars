<?php

namespace App\Traits\TCommon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Storage;

use App\Models\Resassent;
use App\Models\Resproject;

//use File;
use App\Traits\Base;

trait ResProjectQueries
{
	use Base;
	
	public function allResProjects()
	{
		return Resproject::all();
	}
	
	public function resProjectById($id)
	{
		return Resproject::where('resproject_id', $id)->first();
	}
	
	public function allProjectsAndUsers()
	{
		return Resassent::with('allowed')->with('resproject')->get();	
	}

	public function resProjectAllowed()
	{
		return Resassent::with('resprojs')
							->where('allowed_id', Auth::id())
							->where('end_date', '>=', date('Y-m-d'))
							->where('status', 1)
							->get();
		
	}
		
	public function checkResProjectAllowed($id)
	{
		$res = Resassent::where('resproject_id', $id)
						->where('allowed_id', Auth::id())
						->where('end_date', '>=', date('Y-m-d'))
						->where('status', 1)
						->get();

		if( count($res) >= 1 )
		{
				return true;
		}
		else {
				return false;
		}

	}
		
	public function fetchResprojPermInfos($project_id, $user_id)
	{
		$res = Resassent::where('resproject_id', $project_id)
							->where('allowed_id', $user_id)
							->where('end_date', '>=', date('Y-m-d'))
							->where('status', 1)
							->get();

		if( count($res) >= 1 )
		{
			return $res;
		}
		else {
			return null;
		}
	}	

	public function fetchIeacprojPermInfos($project_id, $user_id)
	{
		$res = Iaecassent::where('iaecproject_id', $project_id)
							->where('allowed_id', $user_id)
							->where('end_date', '>=', date('Y-m-d'))
							->where('status', 1)
							->get();

		if( count($res) >= 1 )
		{
			return $res;
		}
		else {
			return null;
		}
	}	
}
