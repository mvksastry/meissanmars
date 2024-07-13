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
use App\Models\Cage;
use App\Models\Cost;

trait costByProjectId
{
	// here the row is all the project models returned by DB
  private function ProjectWiseCost($project_id)
  {
    $today = date('Y-m-d');
    $first_array = array();
    $final_details = array();
    $pi_wise_cost = array();
    $cost_details = array();
    $projcost = array();
    $tempcost = 0.00;
    $proj_cost_val = array();
    $proj_cost = 0.00;
    $cage_count = 0;
    $diff1=0;

    $query = Cage::where('iaecproject_id', $project_id)
                   ->orderBy('cage_id', 'asc')
                   ->get();

    // note the valx below gives us the cage id.
    // now retrive the start date and end of that cage
    // end date is not possible if the cage is still
    // inside the facility. so if the dbase end date is
    // less than today, that means it is still present
    // in the facility.

    foreach ($query as $valx)
    {
      $cage_count = $cage_count + 1;
      $cage_id    = $valx->cage_id;
      $start_date = $valx->start_date;
      $end_date   = $valx->end_date;
      $ack_date   = $valx->ack_date; // we have no need for this
      $species_id = $valx->species_id;
      $strain_id  = $valx->strain_id;
      
      if ((strtotime($end_date) <= strtotime($start_date)))
      {
        // this will make sure that the end date is as of calculation day;
        $end_date = $today;
      }
      
      //now we should get how many effective dates are present in
      // the cost table and determine for each cost period.
      $query2 = Cost::select('effective_cost_date', 'per_diem_cost')
            ->where('species_id', $species_id)
            ->where('strain_id', $strain_id )
            ->get();

      //now based on each cost effective date, determine the
      // start date and calculate number of days.
      //if the effective cost date is older than cage start
      //date then the per diem cost is applicable

      foreach($query2 as $value)
      {
        // these two are the effective cost date and cost value arrays
        $date_cost_array[]  = $value->effective_cost_date;
        $cost_array[] = $value->per_diem_cost;
      }

      $date_arr = $date_cost_array;

      for ($i = 0; $i < count($date_arr); $i++)
      {
        if ($i < count($date_arr)-1)
        {
          $from_date = $date_arr[$i];
          $to_date =  $date_arr[$i+1];

          if( ($start_date >= $from_date) && ($start_date <= $to_date ) )
          {
            $from_date = $start_date;
            $diff1 = abs(strtotime($to_date) - strtotime($from_date));
          }
        }

        if ($i == count($date_arr)-1)
        {
          $from_date = $date_arr[$i];
          if($start_date > $from_date)
          {
            $from_date = $start_date;
          }
          if( $end_date >= $from_date )
          {
            $to_date = $end_date;
            $diff1 = abs(strtotime($to_date) - strtotime($from_date));
          }
        }
  
        //  calculate number of days between start date and the next date.
        $years1 = floor($diff1 / (365*60*60*24));
        $months1 = floor(($diff1 - $years1 * 365*60*60*24) / (30*60*60*24));
        $days1 = floor($diff1/ (60*60*24) );
        //now we got the per diem cost.
        $period_cost = $cost_array[$i];
        $holding_cost2 = $days1*$cost_array[$i];
        $tempcost = $tempcost + $holding_cost2;
        $proj_cost = $proj_cost + $holding_cost2;
        
        if ($days1 != 0)
        {
          $first_array[] = $cage_id;
          $first_array[] = $project_id;
          $first_array[] = $from_date;
          $first_array[] = $to_date;
          $first_array[] = $days1;
          $first_array[] = $period_cost;
          $first_array[] = $holding_cost2;
          array_push($cost_details, $first_array);
        }

        // make zero all values for fresh calculation
        $diff1=0;
        $years1=0;
        $months1=0;
        $days1 = 0;
        $from_date='';
        $first_array = array();
      }

      $tempcost = 0.0;
      $date_cost_array=array();
      $cost_array=array();
    }
    
    array_push($proj_cost_val, $project_id, $cage_count, $proj_cost);
    array_push($projcost,$proj_cost_val );
    array_push($final_details, $cost_details,$projcost  );
    return $final_details;
  }

  public function fetchCostByProjects()
  {
    $projects = Iaecproject::where('status', 'active')->get();
    $finalarray = array();
    foreach($projects as $project)
    {
      $cost[] = $this->ProjectWiseCost($project->project_id);
      $ra[] = $cost[0][1];
      array_push($finalarray, $ra[0][0]);
      $ra = array();
      $cost = array();
    }
    return $finalarray;
  }
}
