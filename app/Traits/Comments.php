<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait Comments
{
    //
  /**
   * Check file validity and move to uploads folder
   *
   * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
   * @return boolean
   */
  
  public function addComment($old, $new)
  {
  return $old.' ;;;'.Auth::user()->name.':  '.date('d-m-Y').':  '.$new;			
  }
		
	public function addTimeStamp($new)
  {
		return Auth::user()->name.': '.date('Y-m-d').': '.$new;			
  }
		
}