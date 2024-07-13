<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


use App\Traits\Base;


trait NewFormDTable
{
	public function makeFormDNoteBookTables($id)
	{
		$formd_tablename = $id."formd";
		$nbook_tablename = $id."notebook";

		$dropx = DB::statement('DROP TABLE IF EXISTS '.$formd_tablename);
		$dropy = DB::statement('DROP TABLE IF EXISTS '.$nbook_tablename);

		$resx = DB::statement('CREATE TABLE '. $formd_tablename. ' LIKE formd');
		$resy = DB::statement('CREATE TABLE '. $nbook_tablename. ' LIKE notebook');
				
		if ($resy)
		{
			return true;
		}
		else {
			return false;
		}
	}
}
