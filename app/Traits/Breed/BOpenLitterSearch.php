<?php

namespace App\Traits\Breed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BCVTerms;


trait BOpenLitterSearch
{
  use BBase, BCVTerms;


	public function searchOpenLitterEntries($input)
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

		$baseSqlStatement = "select * from litter where litter._species_key = ".$speciesKey;

		//dd($mouseIdParam);

		if( $litterId_contains == "contains")
		{
				$baseSqlStatement = $baseSqlStatement." AND litter.litterID LIKE '%".$matingId."%'  ";
		}

		if( $litterId_contains == "equals" )
		{
				$baseSqlStatement = $baseSqlStatement." AND litter.litterID = '".$matingId."'";
		}

		if( $strainKey != "")
		{
				$baseSqlStatement = $baseSqlStatement." AND litter._strain_key = ".$strainKey;
		}

		if ($weanFromDate != "")
		{
				$baseSqlStatement = $baseSqlStatement." AND litter.weanDate > '".$weanFromDate."'";
		}

		if ($weanToDate != "")
		{
				$baseSqlStatement = $baseSqlStatement." AND litter.weanDate < '".$weanToDate."'";
		}

		if ($entry_status != "")
		{
				$baseSqlStatement = $baseSqlStatement." AND litter.entry_status = '".$entry_status."'";
		}
		//dd($baseSqlStatement);
		//echo "Query to be executed = ".$baseSqlStatement;echo "</br>";
		$result = DB::select($baseSqlStatement);
		//dd($result);
		$res = array();
		foreach($result as $row)
		{
				$qr['mating_key'] = $row->_mating_key;
				$qr['matingID'] = $row->matingID;
				$qr['matingRefID'] = $row->matingRefID;
				$qr['_dam1_key'] = $row->_dam1_key;
				$qr['_dam2_key'] = $row->_dam2_key;
				$qr['_sire_key'] = $row->_sire_key;
				$qr['matingDate'] = $row->matingDate;
				$qr['weanTime'] = $row->weanTime;
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
