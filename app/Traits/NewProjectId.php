<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\Tempproject;

use File;
use App\Traits\Base;

trait NewProjectId
{
	use Base;
	
	public function maxProjectId()
	{
    $maxId = Tempproject::max('tempproject_id') + 1;
    return $maxid;
	}

}