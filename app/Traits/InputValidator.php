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


trait InputValidator
{
  
	public function piProjectForm($request) 
  {		
    $request->validate($request, [
      'title'      => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/|max:200',
      'start_date' => 'required|date|date_format:Y-m-d',
      'end_date'   => 'required|date|date_format:Y-m-d|after:start_date',
      'species'    => 'present|array',
      'exp_strain' => 'present|array',
      'spcomments' => 'nullable|regex:/(^[A-Za-z0-9 -_]+$)+/',
    ]);	
	}
	
}