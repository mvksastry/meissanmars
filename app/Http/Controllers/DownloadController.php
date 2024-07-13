<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Iaecproject;
use App\Models\Tempproject;
use App\Models\Maintenance;

use File;


use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class DownloadController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware(['auth:web,admin']);
    }

    public function getProjFile($id)
    {
    	$projSearch = Iaecproject::with('user')->where('filename', $id)
                                        ->first();
        if(!empty($projSearch) )
        {
            // get pis folder, modify the column
            $instns = "/institutions/";
            $piFolder = $projSearch->user->folder;
            $file_path = $instns.$piFolder.'/';
            //dd($file_path);
            $headers = array(
              'Content-Type: application/pdf',
            );
            return response()->download(storage_path("app/public/".$file_path.$id));
        }
        else {
            abort(404);  //404 page
        }
    }
    
    public function getPiTempProjFile($id)
    {
    	$projSearch = Tempproject::where('pi_id', Auth::id())->where('filename', $id)
                                        ->first();
        if(!empty($projSearch) )
        {
            // get pis folder, modify the column
            $instns = "/institutions/";
            $piFolder = $projSearch->user->folder;
            $file_path = $instns.$piFolder.'/';
            //dd($file_path);
            $headers = array(
              'Content-Type: application/pdf',
            );
            return response()->download(storage_path("app/public/".$file_path.$id));
        }
        else {
            abort(404);  //404 page
        }
    }
    
    public function getSubProjFile($id)
    {
    	$tProjSearch = Tempproject::with('user')->where('filename', $id)
                                        ->first();
      //dd($tProjSearch);
        if(!empty($tProjSearch) )
        {
            // get pis folder, modify the column
            $instns = "/institutions/";
            $piFolder = $tProjSearch->user->folder;
            $file_path = $instns.$piFolder.'/';
            //dd($file_path);
            $headers = array(
              'Content-Type: application/pdf',
            );
            return response()->download(storage_path("app/public/".$file_path.$id));
        }
        else {
            abort(404);  //404 page
        }
    }
    
    public function getTempProjectFile($id)
    {
        $tProjSearch = Tempproject::with('user')->where('filename', $id)
                                        ->first();
        if(!empty($tProjSearch) )
        {
            // get pis folder, modify the column
            $instns = "/institutions/";
            $piFolder = $projSearch->user->folder;
            $file_path = $instns.$piFolder.'/';
            
            $file = Storage::disk('public')->get($id);
            $headers = array(
                  'Content-Type: application/pdf',
                );
            return (new Response($file, 200))
                  ->header('Content-Type', 'application/pdf');
        }
        else {
            abort(404);  //404 page
        }
    }
    

    public function getMaintainReportFile($idx)
    {
        $srp = Maintenance::with('infra')->where('filename', $idx)->first();

        if(!empty($srp) )
        {
            // get pis folder, modify the column
            $instns = "/facility/infra/";
            $equipFolder = $srp->infra->name;
            $file_path = $instns.$equipFolder.'/';
            //dd($file_path);
            
            $headers = array(
              'Content-Type: application/pdf',
            );
            //original line below works
            return response()->download(storage_path("app/public/".$file_path.$idx)); //works
            //this line below does not work, left as an example
            //return response()->download(storage_path($file_path.$idx)); 
        }
        else {
            abort(404);  //404 page
        }
    }

    public function getPiProjFile($id)
    {
    	$projSearch = Iaecproject::with('user')->where('filename', $id)->where('pi_id', Auth::id() )
                                        ->first();
        if(!empty($projSearch) )
        {
            // get pis folder, modify the column
            $instns = "/institutions/";
            $piFolder = $projSearch->user->folder;
            $file_path = $instns.$piFolder.'/';
            //dd($file_path);
            $headers = array(
              'Content-Type: application/pdf',
            );
            return response()->download(storage_path("app/public/".$file_path.$id));
        }
        else {
            abort(404);  //404 page
        }
    }
   //
}
