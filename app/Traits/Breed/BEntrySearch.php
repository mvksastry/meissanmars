<?php

namespace App\Traits\Breed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BCVTerms;

trait BEntrySearch
{
    use BBase, BCVTerms;


		public function searchEntry($input)
    {
        // 1. setting the db
        //$mcmsTables = $this->setMcmsDB();

        //$db_connection = "mysql2";
        //$this->tables = DB::connection($db_connection);
        if (strpos($input['species_name'], 'Mice') !== false)
        {
            $species_name = "Mice";
        }

        if (strpos($input['species_name'], 'Rat') !== false)
        {
            $species_name = "Rat";
        }

        //$species_name = $input['species_name'];
        $mouseIdParam = $input['mouseId_contains'];
        $mouse_id     = $input['mouse_id'];
        $strain_key   = $input['_strain_key'];
				$_litter_key  = $input['_litter_key'];
        $lifeStatus   = $input['lifeStatus'];
        $cageIdParam  = $input['cageIdParam'];
        $cage_id      = $input['cage_id'];
        $sex_key      = $input['_sex_key'];
        $fromDate     = $input['dobfrom'];
        $toDate       = $input['dobto'];
        $owner_key    = $input['_owner_key'];
//dd($mouse_id, $mouseIdParam);

        $species_key = $this->getSpeciesKeyBySpeciesName($species_name);

        $baseSqlStatement = "select * from mouse join strains on strains.strain_id = mouse._strain_key where mouse._species_key = ".$species_key;

        //dd($mouseIdParam);
				
				$baseSqlStatement = $baseSqlStatement." AND mouse.exitDate IS NULL ";

        if( $mouseIdParam == "contains")
        {
            $baseSqlStatement = $baseSqlStatement." AND mouse.ID LIKE '%".$mouse_id."%'  ";
        }

        if( $mouseIdParam == "equals" )
        {
            $baseSqlStatement = $baseSqlStatement." AND mouse.ID = '".$mouse_id."'";
        }

        if( $strain_key != "")
        {
            $baseSqlStatement = $baseSqlStatement." AND mouse._strain_key = ".$strain_key;
        }

        if( $_litter_key != "")
        {
            $baseSqlStatement = $baseSqlStatement." AND mouse._litter_key = ".$_litter_key;
        }
				
        if ($cageIdParam != "")
        {
					if( $cageIdParam == "equals")
					{
							$baseSqlStatement = $baseSqlStatement." AND mouse._pen_key = ".$cage_id;
					}
					if( $cageIdParam == "greaterthan")
					{
							$baseSqlStatement = $baseSqlStatement." AND mouse._pen_key > ".$cage_id;
					}
					if( $cageIdParam == "lessthan")
					{
							$baseSqlStatement = $baseSqlStatement." AND mouse._pen_key < ".$cage_id;
					}
        }

        if( $lifeStatus != "")
        {
            $baseSqlStatement = $baseSqlStatement." AND mouse.lifeStatus = '".$lifeStatus."'";
        }

        if( $sex_key != "")
        {
            $baseSqlStatement = $baseSqlStatement." AND mouse.sex = '".$sex_key."'";
        }

        if ($fromDate != "")
        {
            $baseSqlStatement = $baseSqlStatement." AND mouse.birthDate > '".$fromDate."'";
        }

        if ($toDate != "")
        {
            $baseSqlStatement = $baseSqlStatement." AND mouse.birthDate < '".$toDate."'";
        }

        if ($owner_key != "")
        {
            $baseSqlStatement = $baseSqlStatement." AND mouse.owner = '".$owner_key."'";
        }

        /*
            $result = Mouse::with('strain')->where('_species_key', $species_key)
                        ->where('ID', "")->where('ID', $mouse_id)
                        ->where('_strain_key', $strain_key)
                        ->where('_pen_key', $cage_id)
                        ->where('_pen_key', '>', $cage_id)
                        ->where('_pen_key', '<', $cage_id)
                        ->where('lifeStatus',$lifeStatus)
                        ->where('sex',$sex_key)
                        ->where('birthDate', '>', $fromDate)
                        ->where('birthDate', '<', $fromDate)
                        ->where('owner', $owner_key)
                        ->get();
        */

        //dd($baseSqlStatement);
        //echo "Query to be executed = ".$baseSqlStatement;echo "</br>";
        $result = DB::select($baseSqlStatement);
        //dd($result);
        $res = array();
        foreach($result as $row)
        {
            $qr['searchFor'] = $input['searchFor'];
            $qr['_mouse_key'] = $row->_mouse_key;
            $qr['ID'] = $row->ID;
            $qr['strainName'] = $row->strain_name;
            $qr['generation'] = $row->generation;
            $qr['protocol'] = $row->protocol;
            $qr['birthDate'] = $row->birthDate;
            $qr['sex'] = $row->sex;
            $qr['lifeStatus'] = $row->lifeStatus;
            $qr['breedingStatus'] = $row->breedingStatus;
						$qr['exit_date'] = $row->exitDate;
            $qr['origin'] = $row->origin;
            $qr['owner'] = $row->owner;
            //$qr['comment'] = $row->comment; // not picking up due to query, to be resolved later
            array_push($res, $qr);
            $qr = array();
        }
        //dd($result);
        //echo "number of rows got = ".count($result);echo "</br>";
        return $res;
    }



}
