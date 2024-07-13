<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Issue;
use App\Models\Slot;
use App\Models\Cage;
use App\Models\Cagenote;
use App\Models\Rack;
use App\Models\Project;

use App\Models\ExptSampleSearch;

use App\Traits\Base;
use App\Traits\Notes;

trait ExptSampleSearch
{
	use Base;

	use Notes;
	
	
}