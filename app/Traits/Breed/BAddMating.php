<?php

namespace App\Traits\Breed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BCVTerms;

use App\Models\Breeding\Colony\Mouse;
use App\Models\Breeding\Colony\Mating;
use App\Models\Breeding\Cvterms\Matingunitlink;

use Illuminate\Support\Facades\Log;

trait BAddMating
{
    use BBase;

	use BCVTerms;

	    /* Before addition, we must do the following.
       1. First add a cage to the system.
          select that cage and add the new mice
          We can also select an existing cage for this purpose.
       2. Add the mouse info phenotype of the mouse to the phenotypemouselink table
       3. Add info to the mouseusage table for each row.
       4. Add the mouse info to useschedule table

       Everywhere the following procedure is to be followed

       1. set the db first.
       2. prepare the data from request object passed.
       3. Do all calculations etc, like getting the id, max number etc...
       4. prepare the sql insert array
       5. insert with try catch and catch all exception.
       6. prepare the return message with errors if any.

    */
///////////////////////////////////////////////////////////////////////
public function addMating($input)
{
    // 1. setting the db
    //$mcmsTables = $this->setMcmsDB();
    // 2. preparing the data.
    $version = 1;
    $qResultMsg = "";
    $purpose = $input['purpose'];
    $speciesName = $input['speciesName'];

    if($input['genotypeneed']){
        $genotypeneed = 1;
    }
    else {
        $genotypeneed = 0;
    }

    $matingKey = Mating::max('_mating_key') + 1;
    $newMatingId = Mating::max('matingID') + 1;
    $matingUnitTypeKey = null; //entry for second table

    $newMatingEntry = new Mating();

    $newMatingEntry->_mating_key     = $matingKey;
    $newMatingEntry->_species_key    = $this->getSpeciesKeyBySpeciesName($speciesName);
    $newMatingEntry->_matingType_key = $input['matgType'];
    $newMatingEntry->_dam1_key       = $input['dam1Key'];
    $newMatingEntry->_dam2_key       = $input['dam2Key'];
    $newMatingEntry->_sire_key       = $input['sireKey'];
    $newMatingEntry->_strain_key     = $input['strain_key'];
    $newMatingEntry->matingID        = $newMatingId;
    $newMatingEntry->suggestedPenID  = $input['cage_id'];
    $newMatingEntry->weanTime        = $input['weantime'];
    $newMatingEntry->matingDate      = $input['matingDate'];
    $newMatingEntry->generation      = $input['generation_key'];
    $newMatingEntry->owner           = $input['ownerwg'];
    $newMatingEntry->weanNote        = $input['weannote'];
    $newMatingEntry->needsTyping     = $genotypeneed;
    $newMatingEntry->comment         = $input['comments'];
    $newMatingEntry->proposedDiet    = $input['diet_key'];
    $newMatingEntry->version         = $version;
    //data collection complete
    //dd($newMatingEntry);

    Log::channel('coding')->info('Data collection for mating id [ '.$newMatingId.'] complete');

       //Stage 5. insert
       //dd($newMouseEntry);
  try {
        $result = $newMatingEntry->save();
        Log::channel('coding')->info('Mating Id [ '.$newMatingId.' ] creation success');

        if(!empty($input['dam1Key'])){
            $mUnitTypeKey  = 1;
            $result = $this->insertNewMULK($matingKey, $input['dam1Key'], $sampleKey=null, $mUnitTypeKey);
            Log::channel('coding')->info('Mating unit link Id for [ '.$input['dam1Key'].' ] success');
        }
        if(!empty($input['dam2Key'])){
            $mUnitTypeKey  = 1;
            $result = $this->insertNewMULK($matingKey, $input['dam2Key'], $sampleKey=null, $mUnitTypeKey);
            Log::channel('coding')->info('Mating unit link Id for [ '.$input['dam2Key'].' ] success');
        }
        if(!empty($input['sireKey'])){
            $mUnitTypeKey  = 2;
            $result = $this->insertNewMULK($matingKey, $input['sireKey'], $sampleKey=null, $mUnitTypeKey);
            Log::channel('coding')->info('Mating unit link Id for [ '.$input['sireKey'].' ] success');
        }
    }

    catch (\Illuminate\Database\QueryException $e ) {
                $result2Fail = $mcmsTables->rollback();
                $eMsg = $e->getMessage();
                dd($eMsg);
                $qResultMsg = $qResultMsg."</br>".$eMsg."</br>";
                $result1 = false;
    }
    // With, we must have completed all entries and return the message to the user.
    //$msg = $qResultMsg;
    return true;
}

    public function insertNewMULK($mating_key, $Key, $sampleKey, $mUnitTypeKey)
    {
        $newMulK = new Matingunitlink();

        $newMulK->_mating_key = $mating_key;
        $newMulK->_mouse_key = $Key;
        $newMulK->_sample_key = $sampleKey;
        $newMulK->_matingUnitType_key = $mUnitTypeKey;
        //dd($newMulK);
        $newMulK->save();
        return $newMulK->_matingUnitLink_key;
    }

    public function searchBreedingEntries($input_array)
    {
        // 1. setting the db
        // $mcmsTables = $this->setMcmsDB();
        // $db_connection = "manage_colony";

        $species_name = $input_array[0];
        $mouseIdParam = $input_array[1];
        $mouse_id     = $input_array[2];
        $strain_key   = $input_array[3];
        $lifeStatus   = $input_array[4];
        $cageIdParam  = $input_array[5];
        $cage_id      = $input_array[6];
        $sex_key      = $input_array[7];
        $fromDate     = $input_array[8];
        $toDate       = $input_array[9];
        $owner_key    = $input_array[10];

        $species_key = $this->getSpeciesKeyBySpeciesName($species_name);

        $baseSqlStatement = "select * from mouse WHERE _species_key = ".$species_key;

        if($mouse_id !="")
        {
            if( $mouseIdParam == "contains")
            {
                $baseSqlStatement = $baseSqlStatement." AND ID LIKE '%".$mouse_id."%'  ";
            }
            if( $mouseIdParam == "equals")
            {
                $baseSqlStatement = $baseSqlStatement." AND ID = '".$mouse_id."'";
            }
            if( $strain_key != "")
            {
                $baseSqlStatement = $baseSqlStatement." AND _strain_key = ".$strain_key;
            }
            if ($cageIdParam != "")
            {
                if( $cageIdParam == "equals")
                {
                    $baseSqlStatement = $baseSqlStatement." AND _pen_key = ".$cage_id;
                }
                if( $cageIdParam == "greaterthan")
                {
                    $baseSqlStatement = $baseSqlStatement." AND _pen_key > ".$cage_id;
                }
                if( $cageIdParam == "lessthan")
                {
                    $baseSqlStatement = $baseSqlStatement." AND _pen_key < ".$cage_id;
                }
            }
            if( $lifeStatus != "")
            {
                $baseSqlStatement = $baseSqlStatement." AND lifeStatus = '".$lifeStatus."'";
            }
            if( $sex_key != "")
            {
                $baseSqlStatement = $baseSqlStatement." AND sex = '".$sex_key."'";
            }
            if ($fromDate != "")
            {
                $baseSqlStatement = $baseSqlStatement." AND DATE(birthDate) > '".$fromDate."'";
            }
            if ($toDate != "")
            {
                $baseSqlStatement = $baseSqlStatement." AND DATE(birthDate) < '".$toDate."'";
            }
            if ($owner_key != "")
            {
                $baseSqlStatement = $baseSqlStatement." AND owner = '".$owner_key."'";
            }
        }
        //echo "Query to be executed = ".$baseSqlStatement;echo "</br>";
        $result = DB::select($baseSqlStatement);
        //echo "number of rows got = ".count($result);echo "</br>";
        return $result;
    }

    public function fetchMouseIdInfo($mouseId)
    {
        $result = Mouse::where('ID', '=', $mouseId)
                            ->select('*')
                            ->get();
                            
        if( count($result) == 1 )
        {

            $MouseInfo = DB::table('mouse')
                                    ->leftJoin('strain', 'strain._strain_key', '=', 'mouse._strain_key')
                                    ->where('ID', $mouseId)
                                    ->select()
                                    ->get();

            //print_r($MouseInfo);
            //echo "Total mouse rows found = ".count($MouseInfo); echo "</br>";
            return $MouseInfo;
        }
        else {
            echo "No Information found for the ID:".$mouseId;echo "</br>";
        }
    }

}
