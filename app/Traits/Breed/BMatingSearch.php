<?php

namespace App\Traits\Breed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BCVTerms;


trait BMatingSearch
{
  use BBase, BCVTerms;


	public function searchMatings($input)
    {
        // 1. setting the db
        //$mcmsTables = $this->setMcmsDB();

        //$db_connection = "mysql2";
        //$this->tables = DB::connection($db_connection);

        //$species_name = $input['species_name'];
        $contains = $input['matingId_contains'];
        $speciesKey     = $input['speciesKey'];
        $speciesName       = $input['speciesName'];
        $matingId     = $input['matingId'];
        $strainKey   = $input['strainKey'];
        $fromDate = $input['fromDate'];
        $toDate = $input['toDate'];


        $ownerWg  = $input['ownerWg'];

        $baseSqlStatement = "select * from mating where mating._species_key = ".$speciesKey;

        //dd($mouseIdParam);

            if( $contains == "contains")
            {
                $baseSqlStatement = $baseSqlStatement." AND mating.matingID LIKE '%".$matingId."%'  ";
            }

            if( $contains == "equals" )
            {
                $baseSqlStatement = $baseSqlStatement." AND mating.matingID = '".$matingId."'";
            }

            if( $strainKey != "")
            {
                $baseSqlStatement = $baseSqlStatement." AND mating._strain_key = ".$strainKey;
            }

            if ($fromDate != "")
            {
                $baseSqlStatement = $baseSqlStatement." AND mating.DATE(matingDate) > '".$fromDate."'";
            }

            if ($toDate != "")
            {
                $baseSqlStatement = $baseSqlStatement." AND mating.DATE(matingDate) < '".$toDate."'";
            }

            if ($ownerWg != "")
            {
                $baseSqlStatement = $baseSqlStatement." AND mating.owner = '".$ownerWg."'";
            }

        /*

            Mouse::with('strain')->where('_species_key', $species_key)
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
            $qr['mating_key'] = $row->_mating_key;
            $qr['matingID'] = $row->matingID;
            $qr['_dam1_key'] = $row->_dam1_key;
            $qr['_dam2_key'] = $row->_dam2_key;
            $qr['_sire_key'] = $row->_sire_key;
            $qr['matingDate'] = $row->matingDate;
            $qr['generation'] = $row->generation;
            $qr['owner'] = $row->owner;
            $qr['weanNote'] = $row->weanNote;
            $qr['comment'] = $row->comment;
            //$qr['comment'] = $row->comment; // not picking up due to query, to be resolved later

            array_push($res, $qr);
            $qr = array();
        }
        //dd($res);
        //echo "number of rows got = ".count($result);echo "</br>";
        return $res;
    }



}
