<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\Cost;

use App\Traits\Base;
use App\Traits\Notes;


trait SetPerdiemCost
{
	use Base;

	use Notes;

	public function postPerDiemCost($input)
	{
    $sp_str_id = $input['sp_str_id'];

    $per_diem_cost = $input['per_diem_cost'];

    for($i=0; $i < count($per_diem_cost); $i++)
    {
      $id_posted = $sp_str_id[$i];
      $array = explode("_", $id_posted); // Split string into an array
      $newCost = new Cost();
      $newCost->strain_id = $array[1];
      $newCost->species_id = $array[0];
      $newCost->effective_cost_date = date('Y-m-d');
      $newCost->per_diem_cost = $per_diem_cost[$i];
      $newCost->save();
    }
    return true;
	}
}
