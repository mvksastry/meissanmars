<?php

namespace App\Traits\Breed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BCVTerms;

trait BLitterSearch
{
  use BBase, BCVTerms;

	public function searchLiiterEntries($input)
    {
        // 1. setting the db
        //$mcmsTables = $this->setMcmsDB();
        //$db_connection = "mysql2";
        
        $contains     = $input['litterId_contains'];
        $speciesName  = $input['speciesName'];
        $litterId     = $input['litterId'];
        $fromDate     = $input['fromDate'];
        $toDate       = $input['toDate'];
        $ownerWg  = $input['ownerWg'];
        $baseSqlStatement = "select * from litter";
        if( $contains == "contains")
        {
            $baseSqlStatement = $baseSqlStatement." Where litter.matingID LIKE '%".$matingId."%'  ";
        }
        if( $contains == "equals" )
        {
            $baseSqlStatement = $baseSqlStatement." AND litter.matingID = '".$matingId."'";
        }
        if ($fromDate != "")
        {
            $baseSqlStatement = $baseSqlStatement." AND litter.DATE(matingDate) > '".$fromDate."'";
        }
        if ($toDate != "")
        {
            $baseSqlStatement = $baseSqlStatement." AND litter.DATE(matingDate) < '".$toDate."'";
        }
        $result = DB::select($baseSqlStatement);
        //dd($result);
        $res = array();
        foreach($result as $row)
        {
            $qr['_litter_key'] = $row->_litter_key;
            $qr['litterID'] = $row->litterID;
            $qr['totalBorn'] = $row->totalBorn;
            $qr['numFemale'] = $row->numFemale;
            $qr['numMale'] = $row->numMale;
            array_push($res, $qr);
            $qr = array();
        }
        return $res;
    }

}
