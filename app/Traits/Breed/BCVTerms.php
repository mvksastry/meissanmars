<?php

namespace App\Traits\Breed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Breeding\Strain;
use App\Models\Breeding\CVSpecies;
use App\Models\Breeding\CVSex;
use App\Models\Breeding\Matingunitlink;

use DateTime;
use App\Traits\Breed\BBase;


trait BCVTerms
{
  use BBase;

	public function findAllSex()
    {
        return CVSex::all();
    }

    public function getMaxMatingUnitLinkKey()
    {
        return Matingunitlink::max('_matingUnitLink_key') + 1;
    }

    public function findAllProtocolsForSpeciesId($species_id)
    {
        return CVProtocol::where('_species_key', '=', $species_id)->get();
    }

    public function findAllStrainsForSpeciesId($species_id)
    {
		return Strain::where('_species_key', '=', $species_id)->get();
    }

    public function findAllGenerations()
    {
		return CVGeneration::all();
    }

    public function findAllLifestatuses()
    {
		return Lifestatus::all();
    }

    public function findAllLitterTypesForSpeciesId($species_id)
    {
        return CVLittertype::where('_species_key', $species_id)->get();
    }

    public function findAllBirthStatus()
    {
        return CVBirtheventstatus::all();
    }

    public function findAllRooms()
    {
        return Room::all();
    }

    public function findAllAlleles($species_id)
    {
        return Allele::all();
    }

    public function findAllGenes($species_id)
    {
        return Gene::all();
    }

    public function findAllCoatcolorsForSpeciesId($species_id)
    {
        return CVCoatcolor::where('_species_key', '=', $species_id)->get();
    }
    
    public function findAllDietsForSpeciesId($species_id)
    {
        return CVDiet::where('_species_key', '=', $species_id)->get();
    }

    public function findAllOwners()
    {
        return Owner::all();
    }

    public function findAllOrigins()
    {
        return CVMouseorigin::all();
    }

    public function findAllGeneClassForSpeciesId($species_id)
    {
        return CVGeneclass::where('_species_key', '=', $species_id)->get();
    }

    public function findAllGenesForSpeciesId($species_id)
    {
        return Gene::where('_species_key', '=', $species_id)->get();
    }

    public function findAllAllelesForSpeciesId($species_id)
    {
        return Allele::where('_species_key', '=', $species_id)->get();
    }

    public function findAllPhenotypes($species_id)
    {
        return CVPhenotype::where('_species_key', '=', $species_id)->get();
    }

    public function findAllUseScheduleTerms($species_id)
    {
        return Usescheduleterm::where('_species_key', '=', $species_id)->get();
    }

    public function findAllUseScheduleTermsNotSelected($mouseId)
    {
        $mouseKey = $this->mouseKeyById($mouseId);
        $sqlStatement = "select * from usescheduleterm
                            where not exists(select * from useschedule
                            where useschedule._useScheduleTerm_key = usescheduleterm._useScheduleTerm_key
                            and useschedule._mouse_key = 1)";
        return DB::select($sqlStatement);
    }

    public function findCommentById($mouseId)
    {
        return Mouse::where('ID', '=', $mouseId)->value('comment')->get();
    }

    public function mouseKeyById($mouseId)
    {
        return Mouse::where('ID', '=', $mouseId)->pluck('_mouse_key');
    }

    public function findAllUseScheduleTermsSelected($species_id, $mouseId)
    {
        $selectedUseSchTerms = array();
        $mouseKey = $this->mouseKeyById($mouseId);
        $useSchTermKeys = DB::table('useschedule')
                                    ->leftJoin('usescheduleterm', 'useschedule._useScheduleTerm_key', '=', 'usescheduleterm._useScheduleTerm_key')
                                    ->where('useschedule._mouse_key', '=', $mouseKey)
                                    ->select('*')
                                    ->get();

        $allUseSchTermsInDB = $this->findAllUseScheduleTerms($species_id);
        $t = array();
        $tarray = array();
        $ust = array();
        foreach($useSchTermKeys as $val)
        {
          $ust[] = $val->_useScheduleTerm_key;
        }
        foreach($allUseSchTermsInDB as $valx)
        {
            $tarray1['_useScheduleTerm_key'] = $valx->_useScheduleTerm_key;
            $tarray1['useScheduleTermName'] = $valx->useScheduleTermName;
            if( in_array($valx->_useScheduleTerm_key, $ust) )
            {
                $tarray1['selected'] = '1';
            }
            else {
                $tarray1['selected'] = '0';
            }
            array_push($t,$tarray1);
        }
        return $t;
    }


    public function findAllPhenotypesSelected($species_id, $mouseId)
    {
        $phenotypesSelectedForMouseId = array();
        $mouseKey = $this->mouseKeyById($mouseId);
        $phenotype_keys_selected = DB::table('phenotypemouselink')
                                    ->where('_mouse_key', '=', $mouseKey)
                                    ->select('_phenotype_key')
                                    ->orderBy('_phenotype_key')
                                    ->get();
        $tarray = array();
        $tarray1 = array();
        $t = array();
        foreach($phenotype_keys_selected as $val)
        {
          $tarray[] = $val->_phenotype_key;
        }

        $allPheynotypes = $this->findAllPhenotypes($species_id);
        foreach($allPheynotypes as $val)
        {
            $tarray1['_phenotype_key'] = $val->_phenotype_key;
            $tarray1['phenotype'] = $val->phenotype;
            if( in_array($val->_phenotype_key, $tarray) )
            {
                $tarray1['selected'] = '1';
            }
            else {
                $tarray1['selected'] = '0';
            }
            array_push($t,$tarray1);
        }
        return $t;
    }


    //this is a very imp query
    public function findAllPhenotypesNotSelected($mouseId)
    {
        $mouseKey = $this->mouseKeyById($mouseId);
        return DB::table('cv_phenotype')
                                    ->leftJoin('phenotypemouselink', 'phenotypemouselink._phenotype_key', '=', 'cv_phenotype._phenotype_key')
                                    ->whereNull('phenotypemouselink._phenotype_key')
                                    ->select('cv_phenotype.*')
                                    ->get();
    }

    public function findAllPhenotypesKeys()
    {
        return CVPhenotype::all();
    }

	public function getPhenotypeKeysMatchingMouseKey($mouse_key)
    {
        $phenotypeKeysInDB = array();
        $result = DB::table('phenotypemouselink')
                            ->where('_mouse_key', $mouse_key)
                            ->select('*')
                            ->get();
        if(count($result) != 0 )
        {
            foreach ($result as $row )
            {
               // echo $row->_phenotype_key;
                $phenotypeKeysInDB[] = $row->_phenotype_key;
            }
            //echo "phenotype mouse keys in DB are ".print_r($phenotypeKeysInDB);echo"</br>";
        }
		else {
			$phenotypeKeysInDB = array();
		}
        return $phenotypeKeysInDB;
    }

	public function getAllUseScheduleKeysMatchingMouseKey($mouse_key)
    {
        $useScheduleKeysInDB = array();
        
        $result = DB::table('useschedule')
                            ->where('_mouse_key', $mouse_key)
                            ->select('*')
                            ->get();
        $total_rows = count($result);
        //echo "total use schedule rows = ".$total_rows;echo "</br>";
        if(count($result) != 0 )
        {
            foreach($result as $row)
            {
                //echo "use schedule key = ".$row->_useSchedule_key;echo "</br>";
                $useScheduleKeysInDB[] = $row->_useSchedule_key;
            }
           // echo "use schedule keys in db are ";print_r($useScheduleKeysInDB);echo"</br>";
        }
        return $useScheduleKeysInDB;
    }

	public function getAllMouseUseKeysMatchingMouseKey($mouse_key)
    {
        $usageKeysInDB = array();
        $result = DB::table('mouseusage')
                            ->where('_mouse_key', $mouse_key)
                            ->select('*')
                            ->get();
        $total_rows = count($result);
        //echo "total use schedule rows = ".$total_rows;echo "</br>";
        if(count($result) != 0 )
        {
            foreach($result as $row)
            {
                //echo "use schedule key = ".$row->_useSchedule_key;echo "</br>";
                $usageKeysInDB[] = $row->_usage_key;
            }
            //echo "usage keys in db are ";print_r($usageKeysInDB);echo"</br>";
        }
        return $usageKeysInDB;
    }

	public function getAllUseSchTermsKeysMatchingMouseKey($mouse_key)
    {
        $useScheduleTermKeysInDB = array();
        
        $result = DB::table('useschedule')
                            ->where('_mouse_key', $mouse_key)
                            ->select('*')
                            ->get();

        $total_rows = count($result);
        //echo "total use schedule rows = ".$total_rows;echo "</br>";
        if(count($result) != 0 )
        {
            foreach($result as $row)
            {
                //echo "use schedule key = ".$row->_useSchedule_key;echo "</br>";
                $useScheduleTermKeysInDB[] = $row->_useScheduleTerm_key;
            }
            //echo "use schedule term keys in db are ";print_r($useScheduleTermKeysInDB);echo"</br>";
        }
        return $useScheduleTermKeysInDB;
    }

	public function getMaxUseScheduleKey()
    {
        $result = DB::table('useschedule')->max('_useSchedule_key');
		if($result == null || empty($result)) { $result = 0; }
        //$total_rows = count($result);
        //echo "max use schedule key ".$result;echo "</br>";
        $maxUseScheduleKeyFound = $result + 1;
        return $maxUseScheduleKeyFound;
    }

	public function findAllDaysPostEvent($useScheduleTerm_key)
    {
        //echo "use schedule term key value = ".$useScheduleTerm_key; echo "</br>";
        
        $result =DB::table('useschedulelist')
                            ->where('_useScheduleTerm_key', $useScheduleTerm_key)
                            ->select('daysPostEvent')
                            ->get();
        //$daysPostEvent = count($result);.
        //echo "total event rows found are =  "; print_r($daysPostEvent); echo "</br>";
        return $result;
    }

    public function findMouseUseMatchingUseScheduleTermKey($useScheduleTerm_key)
    {
        $result = DB::table('useschedulelist')
                            ->leftJoin('cv_mouseuse', 'cv_mouseuse._mouseUse_key','=', 'useschedulelist._mouseUse_key')
                            ->where('_useScheduleTerm_key', $useScheduleTerm_key)
                            ->select('mouseUse')
                            ->first();

        //echo "total mouseUse rows got = ".count($result); echo "</br>";
		if(!empty($result))
		{
			$mouseUse = $result->mouseUse;
		}
		else {
			$mouseUse = null;
		}
        //echo "mouse use value =  "; echo $mouseUse; echo "</br>";
        return $mouseUse;
    }

    public function getUseSchKeyBySchTermKeyAndMouseKey($value, $mouse_key)
    {
        $result = DB::table('useschedule')
                            ->where('_mouse_key', $mouse_key)
                            ->where('_useScheduleTerm_key', $value)
                            ->select('_useSchedule_key')
                            ->first();
        return $result->_useSchedule_key;
    }

    public function findMouseKeyMatchingMouseId($mouse_id)
    {
        
        $result = DB::table('mouse')
                            ->where('ID', '=', $mouse_id)
                            ->select('_mouse_key')
                            ->get();
        foreach($result as $row)
        {
            $mouse_key = $row->_mouse_key;
        }
        return $mouse_key;
    }

    public function getSpeciesKeyBySpeciesName($speciesName)
    {
        $result = DB::table('cv_species')
                            ->where('species', '=', $speciesName)
                            ->select('_species_key')
                            ->first();
        return $result->_species_key;
    }

    public function getMaxMouseKey()
    {
        $result =DB::table('mouse')
                            ->select('*')
                            ->get();
        $total_rows = count($result);
        $max_mouse_key = $total_rows + 1;
        return $max_mouse_key;
    }

    public function getMaxPhenotypeMouseLinkKey()
    {
        
        $result = DB::table('phenotypemouselink')
                            ->max('_phenotypeMouseLink_key');
		if($result == null || empty($result)) { $result = 0; }
        //echo "_phenotypeMouseLink_key = ". $result;echo "</br>";
        $maxPhenotypeMouseLinkKey = $result + 1;
        return $maxPhenotypeMouseLinkKey;
    }

    public function getMaxMouseusageKey()
    {
        $result = DB::table('mouseusage')->max('_usage_key');
        $maxMouseusageKeyFound = $result + 1;
        return $maxMouseusageKeyFound;
    }

    /*
    public function validateAlphaNumericString($inputString)
    {
        if( preg_match("/^[a-zA-Z0-9_ ,.]+$/", $inputString) )
        {
            return true;
        }
        else {
           return false;
        }
    }

    public function validateAlphaNumUnderscore($inputString)
    {
        if( preg_match("/^[a-zA-Z0-9_]+$/", $inputString) )
        {
            return true;
        }
        else {
           return false;
        }
    }
	*/


}
