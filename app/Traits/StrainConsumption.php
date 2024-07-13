<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Models\User;
use App\Models\Iaecproject;
use App\Models\Strain;
use App\Models\Species;
use App\Models\Projectstrains;
use App\Models\Usage;

use App\Traits\Base;

trait StrainConsumption
{
  use Base;
  // we need project id only
  public function consumptionByProjectId($project_id)
  {
		$projectInfo = Iaecproject::where('iaecproject_id', $project_id)->first();

		$sanctionedStrainInfo = Projectstrains::with('strain')->where('iaecproject_id', $project_id)
															->get();
		$start_date = $projectInfo->start_date;
		$cur_year_start = $this->currentYearStartDate($start_date);
		//$all_strains = $this->all_sanctioned_strains($project_id);
		$strainwise_data = array();
    foreach ($sanctionedStrainInfo as $row )
    {
      $species_id = $row->species_id;
      $strain_id  = $row->strain_id;
      $strain_name = $row->strain->strain_name;
      // first get the name of the spcies.
      $total_strainwise = $this->strainwise_total_consumption($species_id, $strain_id, $project_id);
      $strain_sanctioned = $this->strainwise_total_sanctioned($species_id, $strain_id, $project_id);
      $yearly_limit_mice = $this->strainWiseCurrentYearLimit($species_id, $strain_id, $start_date, $project_id);
      $curyear_strain_consumed = $this->strainwise_curyear_consumption($species_id, $strain_id, $start_date, $project_id);
      $eachstrain_data = array($strain_name, $total_strainwise, $strain_sanctioned, $curyear_strain_consumed, $yearly_limit_mice);
      $finalstrainwise_data = array_push($strainwise_data, $eachstrain_data);
    }
    return $strainwise_data;
  }

  // below function is correct and no modifications
  public function strainwise_total_consumption($species_id, $strain_id, $project_id)
  {
    $strainwise_used = Usage::where('iaecproject_id', $project_id)
                  ->where('species_id', $species_id)
                                  ->where('strain_id', $strain_id)
                                  ->whereIN('issue_status', ['approved','issued'])
                                  ->sum('number');
    if( $strainwise_used == NULL )
    {
      $strainwise_used = 0;
    }
    return  $strainwise_used;
  }

  // below function is correct and no modifications
  public function strainwise_total_sanctioned($species_id, $strain_id, $project_id)
  {
    $strain_sanctioned = Projectstrains::where('iaecproject_id', $project_id)
                    ->where('species_id', $species_id)
                    ->where('strain_id', $strain_id)
                    //	->sum('year1','year2','year3','year4','year5');
                    ->first('allyearstotal');
    return $strain_sanctioned->allyearstotal;
  }

	// below function is correct
  public function strainWiseCurrentYearLimit($species_id, $strain_id, $start_date, $project_id)
  {
    //first get the project start year
    $cur_year_start = $this->currentYearStartDate($start_date);
    // now calculate yearly limit for each species by taking the value from projstrains
    // first obtain the current year from start date.
    $diff = abs(strtotime($cur_year_start) - strtotime($start_date));
    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    //make the table coumn to look for here
    // if you get $years = 0 then you have to look in for limit_year_1 so
    // you should add +1 to years because $years returns 0 if less than year
    // the above floor(diff) function.
		if($years <= 1)
		{
			$column_name = "year".strval($years + 1);
		}
		else {
			$column_name = "year".strval($years + 1);
		}
		$cur_yearlimit = Projectstrains::where('iaecproject_id', $project_id)
										->where('species_id', $species_id)
										->where('strain_id', $strain_id)
										->first($column_name);
    return $cur_yearlimit->$column_name;
  }

	// below function is correct and no modifications
  public function strainwise_curyear_consumption($species_id, $strain_id, $start_date,$project_id)
  {
    $cur_year_start = $this->currentYearStartDate($start_date);
    $result =	Usage::where('iaecproject_id', $project_id)
							->where('species_id', $species_id)
							->where('strain_id', $strain_id)
							->where('status_date', '>=', '$cur_year_start')
							->whereIN('issue_status', ['approved','issued'])
							->sum('number');
							
    if( $result == NULL )
    {
        $result = 0;
    }
    return  $result;
  }
}
