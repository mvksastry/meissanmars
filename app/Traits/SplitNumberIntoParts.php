<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Hop;
use App\Models\Path;
use App\Models\User;

trait SplitNumberIntoParts
{

    public function splitNumber($x, $n)
    {
			$narray = [];
			// If we cannot split the number into exactly 'N' parts
			if($x < $n){

			}
			else if ($x % $n == 0)
			{
				// If x % n == 0 then the minimum difference is 0 and
				// all numbers are x / n
				for($i = 0; $i < $n; $i++)
				{
					$narray[] = intval($x / $n);
				}
			}
			else
			{
				// upto n-(x % n) the values will be x / n
				// after that the values will be x / n + 1
				$zp = intval($n - ($x % $n));
				$pp = intval($x / $n);
				for ($i = 0; $i < $n; $i++)
				{
					if($i >= $zp)
					{
						$narray[] = $pp + 1;
					}
					else
					{
						$narray[] = $pp;
					}
				}
			}
			return $narray;
    }

}