<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use App\Models\Species;
use App\Models\Strain;
use App\Models\Tempproject;
use App\Models\Tempstrain;

use File;
use App\Traits\Base;
use App\Traits\Notes;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

trait ProjectSubmission
{
  use Base;
  use Notes;
  use HasUuids;

  public function postProjectData($request, $purpose, $id, $filename)
  {
    $today            = $this->today();
    $pi_id            = $request['pi'];
    $spcomments       = strip_tags($request['comment']);
    $tickedSpecies    = $request['species'];
    $tickedStrains    = $request['exp_strain'];
    $aname            = $request['name'];
    $aprojecttitle    = $request['title'];
    $aStDate          = date('Y-m-d',strtotime($request['start_date']));
    $aendate          = date('Y-m-d',strtotime($request['end_date']));
    
    //the following block of code can be used for testing
    // the request object processing.
    //$inp = $request->all();
    //dd($inp, $tickedStrains);   
    
    /*
    foreach($tickedStrains as $val)
    {
    $darr = explode("_", $val);
    $tickedStrainYearData[$darr[1]] = $inp[$darr[1]];
    }
    dd($tickedStrainYearData);
    */
 
 
 
    if($spcomments == NULL || $spcomments == "")
    {
      $spcomments = "No comments";
    }
       
      $notes = $this->addTimeStamp($spcomments);
      // prepping complete
      $tempStrainSqls = $this->decodeStrainData($tickedSpecies, $tickedStrains, $request);      
      //dd($tempStrainSqls);

      if($purpose == 'new')
      {
        //make the array for database insert query
        $tempProj = new Tempproject();
        $tempProj->uuid          = $this->newUniqueId();
        $tempProj->pi_id         = $pi_id;
        $tempProj->title         = $aprojecttitle;
        $tempProj->start_date    = $aStDate;
        $tempProj->end_date      = $aendate;
        $tempProj->iaec_comments = 'None';
        $tempProj->notes         = $notes;
        $tempProj->filename      = $filename;
        $tempProj->status        = 'submitted';

        $tempProj->save();
        //dd($tempProj);
        $tempproject_id = $tempProj->tempproject_id;
      }
      
      if($purpose == 'edit')
      {
        $tempProj = Tempproject::findOrFail($id);
        $tempProj->title         = $aprojecttitle;
        $tempProj->start_date    = $aStDate;
        $tempProj->end_date      = $aendate;
        $tempProj->iaec_comments = 'none';
        $tempProj->notes         = $notes;
        $tempProj->filename      = $filename;
        $tempProj->status        = 'Submitted';

        //dd($tempProj);
        // post to db through update method
        $tempProj->update();

        $tempproject_id = $id;
        // trait to delete the old tempproj strain table entries
        $tempproject = Tempstrain::where('tempproject_id', $tempproject_id)->delete();
      }
      
      //for testing uncomment one below comment above two
      //$tempproject_id = 1;
      
      //with this all aspects of straight submision should be done.
      //note we have not included tempproject_id in the strain sqls prepared earlier.
      // now through loop add tempproject_id and insert into db.
      
      foreach($tempStrainSqls as $val)
      {
        $val['tempproject_id'] = $tempproject_id ;
        DB::table('tempstrains')->insert($val);
      }
    return true;
  }

  public function decodeStrainData($tickedSpecies, $tickedStrains, $request)
  {
      $today = $this->today();
      foreach( $tickedSpecies as $val)
      {
        $tarray = explode('_', $val);
        $speciesName = $tarray[0];
        $speciesId = $tarray[1];
        // check for tampering of speciesName and species id
        $tickedStrains = $this->processUnsetArray($tickedStrains);
        //check here for entries in db?
        for($i = 0; $i < count($tickedStrains); $i ++ )
        {
                  
          $t1array = explode('_', $tickedStrains[$i]);
          
          if ($speciesName == $t1array[0])
          {
            //$t2array = explode('_', $tickedStrains[$i]);
            $strainUuid = $t1array[1];
            //$strainName = $t1array[1];
            $selStrain = Strain::where('uuid', $strainUuid)->first();
            
            $strainId = $selStrain->strain_id;
            $strainName = $selStrain->strain_name;
            //$strainId = Strain::where('strain_name', $strainName)->pluck('strain_id');
            //$strainId = $this->commonri->strainIdFromStrainName($strainName);
            
            //this is old line when using strain name
            //$t3array = $request[$strainName];
            
            //this is new line changed on 5 Jul 2024
            $t3array = $request[$strainUuid];
            
            //number of yearwise entries cannot exceed
            //duratin of the project. check the entries throw an error
            //if not matched
            
            $strainYearwiseData = $this->validateStrainYearwiseData($t3array);
            if(array_sum($strainYearwiseData) != 0)
            {
              $year1 = $strainYearwiseData[0];
              $year2 = $strainYearwiseData[1];
              $year3 = $strainYearwiseData[2];
              $year4 = $strainYearwiseData[3];
              $year5 = $strainYearwiseData[4];
              
              $tempStrainSql[] = array(
                        'species_id'      => $speciesId,
                        'strain_id'       => $strainId,
                        'allyearstotal'   => array_sum($strainYearwiseData),
                        'year1'           => $year1,
                        'year2'           => $year2,
                        'year3'           => $year3,
                        'year4'           => $year4,
                        'year5'           => $year5
              );
            }
            
          } //this if can be removed
          
        }
      }
    return $tempStrainSql;
  }


  public function validateStrainYearwiseData($strainYearData)
  {
    $tc = count($strainYearData);
    for($i=0; $i < $tc; $i++)
    {
      $strainYearData[$i] = preg_replace('/\D/', '', $strainYearData[$i]);
      if ($strainYearData[$i] == null)
      {
        $strainYearData[$i] = 0;
      }
      if (!(is_numeric($strainYearData[$i])))
      {
        $strainYearData[$i] = 0;
        //  $msg = "Yearwise data contains Non-Numeric data";
        //  return $msg;
      }
    }
    return $strainYearData;
  }

  private function processUnsetArray($input_array)
  {
    
    foreach($input_array as $key => $value)
    {
      if($value == "")
      {
        unset($input_array[$key]);
      }
    }
    $new_array = array_values($input_array);
    return $new_array;
  }

}
