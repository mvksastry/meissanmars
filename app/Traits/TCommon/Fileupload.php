<?php

namespace App\Traits\TCommon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use File;
use App\Traits\Base;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

trait Fileupload
{
    use Base;

		 /**
         * Check file validity and move to uploads folder
         *
         * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
         * @return boolean
         */

		public function projFileUpload($request)
		{
			$projFileName = "";
			$oExt = $request->file('resprojfile')->getClientOriginalExtension();
			//for testing, in reality, pass on the user's folder name fromm DB.
			$piFolder = Auth::user()->folder;
			$destPath = "/public/institutions"."/".$piFolder."/";
			$code15 = $this->generateCode(15);
			$projFileName = $code15."_".$request->user()->id."."."$oExt";
			//delete old file if any here before upload
			$path = $request->file('resprojfile')->storeAs($destPath, $projFileName);
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] uploaded project file name [ '.$projFileName.']');
			return $projFileName;
		}

		public function resprojAppLettFileUpload($request)
		{
			$filename = "";
			$oExt = $request->file('appletterfile')->getClientOriginalExtension();
			//for testing, in reality, pass on the user's folder name fromm DB.
			$piFolder = Auth::user()->folder;
			$destPath = "/public/institutions"."/".$piFolder."/";
			$code15 = $this->generateCode(15);
			$filename = $code15."_".$request->user()->id."."."$oExt";
			//delete old file if any here before upload
			$path = $request->file('appletterfile')->storeAs($destPath, $filename);
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Res project approval letter [ '.$filename.']');
			return $filename;
		}

		public function resprojReportFileUpload($request)
		{
			$filename = "";
			$oExt = $request->file('reportfile')->getClientOriginalExtension();
			//for testing, in reality, pass on the user's folder name fromm DB.
			$piFolder = Auth::user()->folder;
			$destPath = "/public/institutions"."/".$piFolder."/";
			$code15 = $this->generateCode(12);
			$filename = $code15."_".$request->user()->id."."."$oExt";
			//delete old file if any here before upload
			$path = $request->file('reportfile')->storeAs($destPath, $filename);
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Res project report [ '.$filename.']');
			return $filename;
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
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Service report [ '.$servRepFileName.']');
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
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] uploaded Experimental Files [ '.$fileName.']');
			return $fileName;
			
		}
		
		/**
         * Check file validity and move to uploads folder
         *
         * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
         * @return boolean
         */

		public function iaecProjFileUpload($request)
		{
			$projFileName = "";
			$oExt = $request->file('userfile')->getClientOriginalExtension();
			//for testing, in reality, pass on the user's folder name fromm DB.
			$piFolder = Auth::user()->folder;
			$destPath = "/public/institutions"."/".$piFolder."/";
			$code15 = $this->generateCode(15);
			$projFileName = $code15."_".$request->user()->id."."."$oExt";
			//delete old file if any here before upload
			$path = $request->file('userfile')->storeAs($destPath, $projFileName);
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] uploaded IAEC project file [ '.$projFileName.']');
			return $projFileName;
		}		
        
}
