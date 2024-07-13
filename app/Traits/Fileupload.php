<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use File;
use App\Traits\Base;

trait Fileupload
{
    //use Base;

		/**
     * Check file validity and move to uploads folder
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return boolean
     */

		public function projFileUpload($request)
		{
			$projFileName = "";
			$oExt = $request->file('projfile')->getClientOriginalExtension();
			//for testing, in reality, pass on the user's folder name fromm DB.
			$piFolder = Auth::user()->folder;
			$destPath = "/public/institutions"."/".$piFolder."/";
      
			$code15 = $this->generateCode(15);
			$projFileName = $code15."_".$request->user()->id."."."$oExt";
			//delete old file if any here before upload
			$path = $request->file('projfile')->storeAs($destPath, $projFileName);
			return $projFileName;
		}

    public function serviceReportFileUpload($request, $infraName, $infra_id)
    {
      $servRepFileName = "";
      $oExt = $request->file('userfile')->getClientOriginalExtension();
      //for testing, in reality, pass on the user's folder name fromm DB.
      $destPath = "/pulic/facility/infra"."/".$infraName."/";
      $code10 = $this->generateCode(15)."_";
      $servRepFileName = $code10.$infra_id."."."$oExt";
      //delete old file if any here before upload
      $path = $request->file('userfile')->storeAs($destPath, $servRepFileName);
      return $servRepFileName;
    }
        
    public function uploadExptFiles($request, $theme_id, $experiment_id)
    {
      $fileName = "";
      //for testing, in reality, pass on the user's folder name fromm DB.
      $piFolder = Auth::user()->folder;
      $destPath = "/institutions"."/".$piFolder."/";
      $code8 = $this->generateCode(8);
      $oExt = $request->file('userfile')->getClientOriginalExtension();
      $fileName = $code8."_".$request->user()->id.".".$oExt;
      //delete old file if any here before upload
      $path = $request->file('userfile')->storeAs($destPath, $projFileName);
      return $fileName;  
    }
    
    public function uploadRoomImageFile($request)
    {
      $destPath = "public/facility/rooms/";
      $oExt     = $request->file('imageFile')->getClientOriginalExtension();
      $fileName = time().".".$oExt;
      $path     = $request->file('imageFile')->storeAs($destPath, $fileName);
      return $fileName;      
    }
        
}
