<?php

namespace App\Traits\Breed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BCVTerms;

trait BCageSearch
{
  use BBase, BCVTerms;


	public function searchEntry($input)
    {
        // 1. setting the db
        //$mcmsTables = $this->setMcmsDB();

        //$db_connection = "mysql2";
        //$this->tables = DB::connection($db_connection);

        $contains = $input['cageParams'];
        $id = $input['cageChars'];
        $Name = $input['cageName'];
        $status = $input['cageStatus'];
        $Rooms = $input['cageRooms'];


        $baseSqlStatement = "select * from container";

        //dd($mouseIdParam);
        if( $contains == "equals")
        {
            $baseSqlStatement = $baseSqlStatement." AND container.containerID = ".$id;
        }

        if( $contains == "greaterthan")
        {
            $baseSqlStatement = $baseSqlStatement." AND container.containerID > ".$id;
        }

        if( $contains == "lessthan")
        {
            $baseSqlStatement = $baseSqlStatement." AND container.containerID < ".$id;
        }

        if( $name != "")
        {
            $baseSqlStatement = $baseSqlStatement." AND container.containerName LIKE '%".$name."%'  ";
        }

        if( $status != "")
        {
            $baseSqlStatement = $baseSqlStatement." AND container.status = ".$status;
        }

        if( $room != "")
        {
            $baseSqlStatement = $baseSqlStatement." AND container.room = '".$room."'";
        }

        /*  Mouse::with('strain')->where('_species_key', $species_key)
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
            $qr['1'] = $row->_mouse_key;
            $qr['1'] = $row->ID;
            $qr['1'] = $row->strainName;
            $qr['1'] = $row->generation;
            $qr['1'] = $row->protocol;
            $qr['1'] = $row->birthDate;
            $qr['1'] = $row->sex;
            $qr['1'] = $row->lifeStatus;
            $qr['1'] = $row->breedingStatus;
            $qr['1'] = $row->origin;
            $qr['1'] = $row->owner;
            //$qr['comment'] = $row->comment; // not picking up due to query, to be resolved later
            array_push($res, $qr);
            $qr = array();
        }
        //dd($result);
        //echo "number of rows got = ".count($result);echo "</br>";
        return $res;
    }



}
