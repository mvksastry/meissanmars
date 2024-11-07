<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Models\User;
use App\Models\Project;
use App\Models\Iaecassent;
use App\Models\Strain;
use App\Models\Species;
use App\Models\Projectstrains;
use App\Models\Usage;

use App\Traits\Base;
use App\Traits\StrainConsumption;
use App\Traits\ProjectQueries;

trait IssueRequestQueries
{
	use Base;
	use ProjectQueries;
	use StrainConsumption;
	
	public function issueRequestsAllowed()
	{
		$res = Iaecassent::where('allowed_id', Auth::id())
						->where('end_date', '>=', date('Y-m-d'))
						->where('status', 'active')
						->get();
		$projIds = array();
		foreach($res as $row)
		{
			$projIds[] = $row->iaecproject_id;
		}
		return Usage::with('strain')->where('iaecproject_id', $projIds)->get();
	}
	
	public function fetchIssuesByProjectId($id)
	{
		$issueIds = array();
		$result = Issue::where('project_id', $id)->where('issue_status', 'issued')->get();
		foreach($result as $val)
		{
			$issueIds[] = $val->issue_id;
		}
		//dd($issueIds);
		return $issueIds;
	}
}






