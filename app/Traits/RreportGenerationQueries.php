<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Models\User;
use App\Models\Project;
use App\Models\Assent;
use App\Models\Strain;
use App\Models\Species;
use App\Models\Projectstrains;
use App\Models\Issue;

use App\Traits\Base;
use App\Traits\StrainConsumption;
use App\Traits\ProjectQueries;

trait RreportGenerationQueries
{
	use Base;
	use ProjectQueries;
	use StrainConsumption;

	public function projectAllowed()
	{
			$result = Assent::where('allowed_id', Auth::id())
							->where('end_date', '>=', date('Y-m-d'))
							->where('status', 1)
							->get();

	}

}
