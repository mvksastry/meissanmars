<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Models\User;
use App\Models\Project;
use App\Models\Strain;
use App\Models\Species;

trait Openstrains
{
	function strains_open()
	{
		return Strain::with('species')->where('distributable', 'yes')->get()->sortBy('species_id');
	}
}
