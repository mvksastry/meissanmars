<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use File;
use App\Traits\Base;

trait DeleteOldFile
{
    use Base;

		/**
     * Check file validity and move to uploads folder
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return boolean
     */

		public function OldFileDelete($folder, $oldFileName)
		{

  			$from_path = "/institutions"."/".$folder."/";

  			$to_path = $from_path."junk";
  			//delete old file if any here before upload
  			//delete any old file in the directory by the same name
  			if(\File::exists(public_path('upload/bio.png')))
  			{
  				\File::delete(public_path('upload/bio.png'));
  			}else{
  				return false;
  			}

  			if(Storage::exists($from_path.$oldFileName))
  			{
  				Storage::move($from_path.$oldFileName, 'public/movedfiles/'.$oldFileName);
  				//$res = Storage::disk('public')->delete($junkFolder, $oldFileName);
  				//Storage::delete($path, $oldFileName);
  				if(Storage::exists($from_path.$oldFileName))
  				{
  					return true;
  				}
  				else {
  					return false;
  				}
  			}
  			else {
  				return false;
  			}

		}

}
