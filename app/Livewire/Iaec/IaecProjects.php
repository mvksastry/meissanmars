<?php

namespace App\Livewire\Iaec;

use Livewire\Component;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Iaecproject;
use App\Models\Iaecassent;
use App\Models\Tempproject;
use App\Models\Projectstrains;
use App\Models\User;
use App\Models\Usage;
use App\Models\Species;
use App\Models\Strain;
use App\Models\Report;
use App\Models\Cage;
use App\Models\Image;
use App\Models\Notebook;

use App\Traits\Base;
use App\Traits\IssueRequest;
use App\Traits\StrainConsumption;
use App\Traits\ProjectStrainsById;
use App\Traits\FormD;
use App\Traits\costByProjectId;
use App\Traits\ProjectQueries;
use App\Traits\IssueRequestQueries;
use App\Traits\Fileupload;
use Livewire\WithFileUploads;
use Validator;

use File;

class IaecProjects extends Component
{
    use Base;
    use ProjectQueries;
    use IssueRequest;
    use StrainConsumption;
    use ProjectStrainsById;
    use IssueRequestQueries;
    use FormD, costByProjectId;
    use Fileupload;
    use WithFileUploads;

    public $project_id, $title, $start_date, $end_date, $comments;
    public $date_approved, $filename, $iaec_meeting_info, $iaec_comments;
    public $iaec_approval_ref;
    
    public $pstx, $pstx1, $irqMessage, $swc, $formD, $nbes, $nbimages;
    public $strains, $sex, $age, $ageunit, $number, $cagenumber, $termination;
    public $products, $remarks, $agree, $issueConfirmed, $cageProjectCostInfos;
    public $duration, $expt_desc;
    
    public $ic, $pc, $projfile, $projReps, $breederId, $exptdesc1;

    public $issueId, $issueIdx, $protocolId, $expdate;

    public $cages,  $cageId, $nbqs, $picid;

    public $expimages = [], $legend;

    public $id_project, $idissue, $idcage, $idprotocol, $dateexpt, $descexpt, $exptimages;
    
    // report form variables
    public $reportx, $repFromDate, $repToDate;

    //panel openings
    public $updateMode = false;
    public $updateFormD = false;
    public $updateReports = false;
    public $updateCosts = false;
    public $updateNotebook = false;
    public $notebookUpdate = false;

    public $photo, $fxt=[];

    public function render()
    {
      if( Auth::user()->hasAnyRole(['pisg','pient', 'researcher', 'veterinarian']) )
  		{
  		    
        if($this->updateFormD)
        {
          $this->showFormDInfo($this->project_id);
        }
        if($this->notebookUpdate)
        {
          $this->nbUpdate($this->picid);
        }
			
        $submitProjs = $this->allowedSubmittedProjectIds();
        $actvProjs = $this->allowedProjectIds();
        //dd($submitProjs, $actvProjs);
        //implement here cost, issues and consumption details one by one
        return view('livewire.iaec.iaec-projects')
                ->with(['actvProjs'=>$actvProjs, 'submitProjs' => $submitProjs]);
  		}
  		else {
  			return view('livewire.permError');
  		}
    }

    public function show($id)
    {
        if( Auth::user()->hasRole(['pisg','pient','researcher', 'veterinarian']) )
        {
          $this->updateMode = true;
          $this->updateFormD = false;
          $this->updateReports = false;
          $this->updateCosts = false;
          $this->updateNotebook = false;
          $project = $this->projectById($id);
          $this->project_id = $id;
          $this->title = $project->title;
          $this->start_date = $project->start_date;
          $this->end_date = $project->end_date;
          $this->date_approved = $project->date_approved;
          $this->filename = $project->filename;
          $this->iaec_meeting_info = $project->iaec_meeting_info;
          $this->iaec_approval_ref = $project->iaec_approval_ref;
          $this->iaec_comments = $project->iaec_comments;
          $this->projfile = $project->filename;
          $this->issueConfirmed	= Usage::with('strain')->where('iaecproject_id', $id )
                            //	->whereIn('issue_status', ['confirmed','approved'])
                                ->get();
          $this->pstx = $this->fetchProjectStrainsById($id);;
          $swc = $this->consumptionByProjectId($id);
          $this->swc = $swc;
        }
        else {
          return view('livewire.permError');
        }
    }

    public function edit($id)
    {
        if( Auth::user()->hasAnyRole(['pisg','pient','researcher', 'veterinarian']) )
        {
          $this->updateMode = true;
          $project = $this->projectById($id);
          $this->project_id = $id;
          $this->title = $project->title;
          $this->start_date = $project->start_date;
          $this->end_date = $project->end_date;
          $this->date_approved = $project->date_approved;
          $this->filename = $project->filename;
          $this->iaec_meeting_info = $project->iaec_meeting_info;
          $this->iaec_approval_ref = $project->iaec_approval_ref;
          $this->iaec_comments = $project->iaec_comments;
          $this->pstx = $this->fetchProjectStrainsById($id);;
          $swc = $this->consumptionByProjectId($id);
          $this->swc = $swc;
        }
        else {
          return view('livewire.permError');
        }
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->updateCosts = false;
        $this->resetInputFields();
      }

    public function store()
    {
        if( Auth::user()->hasAnyRole(['pisg','pient','researcher', 'veterinarian']) )
        {

          $this->irqMessage = "";
          $this->irqMessage = "Welcome, Pay attention to fields";

          $ps = $this->pstx1;
          $this->validate(['pstx1' => 'required']);

          $xs = explode(";", $ps);
          $input['species_id'] = $xs[0];
          $input['strain_id'] = $xs[1];

          $input['project_id'] = $this->project_id;
          $input['pi_id'] = Auth::id();
          $input['sex'] = $this->sex;
          $this->validate(['sex' => 'required|alpha']);

          $input['age'] = $this->age;
          $this->validate(['age' => 'required']);

          $input['ageunit'] = $this->ageunit;
          $this->validate(['ageunit' => 'required|alpha']);

          $input['number'] = $this->number;
          $this->validate(['number' => 'required|numeric']);

          $input['cagenumber'] = $this->cagenumber;
          $this->validate(['cagenumber' => 'required|numeric']);

          $input['termination'] = $this->termination;
          $this->validate(['termination' => 'required|regex:/^[\pL\s\- ;0-9_]+$/u|max:150']);

          $input['duration'] = $this->duration;
          $this->validate(['duration' => 'required|regex:/^[0-9]+$/u|max:52']);
          
          $input['expt_desc'] = $this->expt_desc;
          $this->validate(['expt_desc' => 'required|regex:/^[\pL\s\- .,;0-9_]+$/u|max:500']);
          
          $input['products'] = $this->products;
          $this->validate(['products' => 'required|regex:/^[\pL\s\- ,;0-9_]+$/u|max:150']);

          $input['remarks'] = $this->remarks;
          $this->validate(['remarks' => 'required|regex:/^[\pL\s\- ,;0-9_]+$/u|max:150']);

          $input['agree'] = $this->agree;
          $this->validate(['agree' => 'required:numeric']);

          $input['status_date'] = date('Y-m-d');
          $input['issue_status'] = "submitted";

          $input['issue_id'] = null;
          //now post to trait because, everything is ok
          // and get it posted after verification of strain balance.

          $result = $this->postIssueRequest($input);

          if($result){
            $msg = "Issue Request Submission Successful";
            $this->irqMessage = $msg;
          }
          else {
            $msg = "Issue Request Submission Failed, Contact Admin";
            $this->irqMessage = $msg;
          }

          $this->resetIssueForm();

        }
        else {
          return view('livewire.permError');
        }

    }

    public function update()
    {
        if( Auth::user()->hasAnyRole(['pisg','pient','researcher', 'veterinarian']) )
        {
            $validatedDate = $this->validate([
                'strains' =>     'required|regex:/^[\pL\s\- ;0-9_]+$/u|max:25',
                'sex' =>         'required|regex:/^[\pL\s\- ;0-9_]+$/u|max:6',
                'age' =>         'required|numeric|max:30',
                'ageunit' =>     'required|regex:/^[\pL\s\- ;0-9_]+$/u|max:6',
                'number' =>      'required|numeric|max:1000',
                'cagenumber' =>  'required|numeric|max:30',
                'termination' => 'required|regex:/^[\pL\s\- ;0-9_]+$/u|max:150',
                'duration' =>    'required|numeric|max:52',
                'expt_desc' =>   'required|regex:/^[\pL\s\- .,;0-9_]+$/u|max:500',
                'products' =>    'required|regex:/^[\pL\s\- ,;0-9_]+$/u|max:150',
                'remarks' =>     'required|regex:/^[\pL\s\- ,;0-9_]+$/u|max:250',
                'agree' =>       'required|numeric|max:2'
            ]);

            if ($this->project_id) {
                $usage = new Usage();
                    //dd($usage);
                    
                    $usage->update([
                        'strains' => $this->strains
                    ]);
                    
                $this->updateMode = false;
                session()->flash('message', 'Issue Request Posted Successfully.');
                $this->resetInputFields();
            }

        }
        else {
          return view('livewire.permError');
        }
    }

      public function reports($id)
      {
          if( Auth::user()->hasAnyRole(['pisg','pient','investigator', 'researcher', 'veterinarian']) )
          {
            $this->updateMode = false;
            $this->updateFormD = false;
            $this->updateCosts = false;

            $this->project_id = $id;

            $qry = Report::where('iaecproject_id', $id)->get();

            $this->projReps = $qry;

            $this->updateReports = true;
          }
          else {
            return view('livewire.permError');
          }
      }

      public function costs($id)
      {
          $this->updateMode = false;
          $this->updateFormD = false;
          $this->updateReports = false;
          $cageProjectCostInfos = $this->ProjectWiseCost($id);
          $this->ic = $cageProjectCostInfos[0];
          $this->pc = $cageProjectCostInfos[1];
          //dd($cageProjectCostInfos);
          $this->updateCosts = true;
      }

      public function piprojectDownload($id)
      {
        dd($id);
          $projSearch = Project::with('user')->where('filename', $id)->where('pi_id', Auth::id() )
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

      public function piReportDownload($id)
      {
          $projSearch = Iaecproject::with('user')->where('iaecproject_id', $this->project_id)->where('pi_id', Auth::id() )
                                              ->first();
          if(!empty($projSearch) )
          {
            // get pis folder, modify the column
            $instns = "/institutions/";
            $piFolder = $projSearch->user->folder;
            $file_path = $instns.$piFolder.'/';

            $headers = array(
              'Content-Type: application/pdf',
            );
            return response()->download(storage_path("app/public/".$file_path.$id));
          }
          else {
            abort(404);  //404 page
          }
      }

      // all form resets
      private function resetInputFields()
      {
          $this->title = '';
      }

      public function resetIssueForm(){
          $this->pstx1 = '';
          $this->sex = '';
          $this->age = '';
          $this->ageunit = '';
          $this->number = '';
          $this->cagenumber = '';
          $this->termination = '';
          $this->duration;
          $this->expt_desc;
          $this->products = '';
          $this->remarks = '';
          $this->agree = 0;
      }

      public function resetFormD(){

          $this->sex = "";
          $this->age = "";
          $this->ageunit = "";
          $this->breeder_add = "";
          $this->approval_date = "";
          $this->expt_date = "";
          $this->expt_description = "";
          $this->remarks = "";
      }

      public function resetNotebook(){
          $this->idissue = "";
          $this->idcage = "";
          $this->dateexpt = "";
          $this->idprotocol = "";
          $this->descexpt = "";
          $this->images = "";
      }

      public function showFormDInfo($id)
      {
          if($this->checkProjectAllowedOrNot($id))
          {
            $this->updateMode = false;
            $this->updateFormD = true;
            $this->updateNotebook = false;
            //$this->notebookUpdate = false;
            $this->updateReports = false;
            $this->updateCosts = false;

            $this->keepHydrated($id);
          }
          else {
            $this->irqMessage = "No Permission to view";
          }

      }

      public function nbUpdate($id)
      {
          if( Auth::user()->hasAnyRole(['pisg','pilg','piblg','pient','investigator', 'researcher', 'veterinarian']) )
          {
              $this->picid = $id;
              $ids = explode('_', $id);
              $this->project_id = $ids[0];
              $this->idissue = $ids[1];
              $this->idcage = $ids[2];
              $this->updateMode = false;
              $this->updateFormD = true;
              $this->notebookUpdate = true;
              // table can be retrieved only the DB format not the other way
              //formd is replaced with notebook table for USA customers
              $this->keepHydrated($this->project_id);
              $this->notebookQuerySelect($this->project_id,$this->idissue,$this->idcage);
          }
          else {
            return view('livewire.permError');
          }

      }

      //form-d aka Notebook methods are here.
      public function saveNotebook()
      {
        if( Auth::user()->hasAnyRole(['pisg','pilg','piblg','pient','investigator', 'researcher', 'veterinarian']) )
        {

          $this->irqMessage = "";
          $this->irqMessage = "Welcome, Pay attention to fields";

          $table = $this->project_id.'notebook';

          $max_nb_id = DB::table($table)->max('notebook_id') + 1;
          $animNum = DB::table($table)->where('cage_id', '=', $this->idcage)->latest()->first();

          $input['issue_id'] = $this->idissue;
          $input['cage_id'] = $this->idcage;
          $input['staff_id'] = Auth::Id();
          $input['staff_name'] = Auth::user()->name;
          $input['entry_date'] = date('Y-m-d');
          $input['number_animals'] = $animNum->number_animals;
          $input['protocol_id'] = $this->idprotocol;
          $input['expt_date'] = $this->dateexpt;
          $input['expt_description'] = $this->descexpt;
          $input['authorized_person'] = "PI";
          $input['signature'] = Auth::user()->name;
          $input['remarks'] = $this->legend;

          //now upload image and video files;
          //for testing, in reality, pass on the user's folder name fromm DB.
          $piFolder = Auth::user()->folder;

          $destPath = "/institutions"."/".$piFolder."/";

          if(count($this->expimages) > 0 )
          {

              foreach ($this->expimages as $key => $value)
              {

                  $this->validate([
                    'expimages.*' => 'image|mimes:jpeg,png,jpg|max:2048', // 1MB Max
                  ]);
                  $fname = $value->getClientOriginalName();
                  $txe = explode('.', $fname);
                  $code15 = $this->generateCode(15);
                  $imgFileName = $code15."_".Auth::user()->id.'.'.$txe[1];
                  $image = new Image();
                  $image->tablename = $table;
                  $image->notebook_id = $max_nb_id;
                  $image->staff_id = Auth::Id();
                  $image->staff_name = Auth::user()->name;
                  $image->entry_date = date('Y-m-d');
                  $image->cage_id = $this->idcage;
                  $image->image_file = $imgFileName;
                  $image->video_file = null;
                  $image->remarks = $this->legend;
                  //dd($input, $image);
                  $fxt[$key] = $value->storeAs($destPath, $imgFileName);
                  $image->save();
                  $input['av_info'] = 'yes';
              }
          }

          //now post to trait because, everything is ok
          // and get it posted after verification of strain balance.
          $result = DB::table($table)->insert($input);
          //$result = true;
          if($result)
          {
            $msg = "Notebook Update Successful";
            $this->irqMessage = $msg;
          }
          else {
            $msg = "Notebook Update Failed, Contact Admin";
            $this->irqMessage = $msg;
          }

          $this->resetNotebook();
          $this->notebookUpdate = false;
          //$this->resetNotebooks();

        }
        else {
          return view('livewire.permError');
        }

      }

    public function keepHydrated($id)
    {

      $this->project_id = $id;
      $result = $this->projectById($id);
      $this->start_date = $result->start_date;
      $this->end_date = $result->end_date;
      $this->date_approved = $result->date_approved;
      $this->notebookQuery($id);
    }

    public function notebookQuery($id)
    {
      // table can be retrieved only the DB format not the other way
      //formd is replaced with notebook table for USA customers

      if($this->checkProjectAllowedOrNot($id))
      {
            $qr = array();
            $qresult = array();
            $tablename = $id.'notebook';
            //$tablename = $id.'formd';
            //$test = Image::where('tablename', $tablename)->get();  
            $this->nbes = DB::table($tablename)
                            ->leftJoin('usages','usages.usage_id', '=', $tablename.'.usage_id')
                            ->leftJoin('cages','cages.cage_id', '=', $tablename.'.cage_id')
                            ->leftJoin('strains', 'strains.strain_id', '=', 'cages.strain_id')
                            ->leftJoin('species', 'species.species_id', '=', 'cages.species_id')
                            ->select()
                            ->get();
        }
        else {
        return view('livewire.permError');
        }

    }

    public function notebookQuerySelect($id,$issId,$cagId)
    {
        // table can be retrieved only the DB format not the other way
        //formd is replaced with notebook table for USA customers
        if($this->checkProjectAllowedOrNot($id))
        {
           //$tname = $id.'formd';
            $tname = $id.'notebook';
            $this->nbqs = DB::table($tname)
                                ->leftJoin('usages','usages.usage_id', '=', $id.'notebook.usage_id')
                                ->leftJoin('cages','cages.cage_id', '=', $id.'notebook.cage_id')
                                ->leftJoin('strains', 'strains.strain_id', '=', 'cages.strain_id')
                                ->leftJoin('species', 'species.species_id', '=', 'cages.species_id')
                                ->where($id.'notebook.usage_id', '=', $issId)
                                ->where($id.'notebook.cage_id', '=', $cagId)
                                ->select()
                                ->get();
                                
            $imgs = Image::where('tablename', $id.'notebook')->where('cage_id', $cagId)->get();
            
            if(count($imgs) != 0)
            {
                $this->nbimages = $imgs;
            }
            else {
                $this->nbimages = 'None';
            }
        }
        else {
            return view('livewire.permError');
        }
        
    }


    
    public function saveFormD()
    {
      $this->irqMessage = "";
      $this->irqMessage = "Welcome, Pay attention to fields";

      $input['formD'] = $result->formD;

      $input['pi_id'] = Auth::id();
      $input['project_id'] = $this->project_id;
      $input['staff_id'] = Auth::Id();
      $input['staff_name'] = Auth::user()->name;
      $input['entry_date'] = date('Y-m-d');
      $input['req_anim_number'] = null;

      $ps = $this->pstx1;

      $this->validate(['pstx1' => 'required']);
      $xs = explode(";", $ps);
      $input['species'] = $xs[0];
      $input['strain'] = $xs[1];

      $input['sex'] = $this->sex;
      $this->validate(['sex' => 'required|alpha']);

      $input['age'] = $this->age;
      $this->validate(['age' => 'required']);

      $input['ageunit'] = $this->ageunit;
      $this->validate(['ageunit' => 'required|alpha']);

      $input['breeder_add'] = $this->breeder_add;
      $this->validate(['breeder_add' => 'required|alpha']);

      $input['approval_date'] = $this->approval_date;
      $this->validate(['approval_date' => 'required|alpha']);

      $input['expt_date'] = $this->expt_date;
      $this->validate(['expt_date' => 'required|date']);

      $input['expt_description'] = $this->expt_description;
      $this->validate(['expt_description' => 'required|regex:/^[\pL\s\- ;0-9_]+$/u|max:150']);

      $input['signature'] = Auth::user()->name;

      $input['remarks'] = $this->remarks;
      $this->validate(['remarks' => 'required|regex:/^[\pL\s\- ;0-9_]+$/u|max:150']);
      //now post to trait because, everything is ok
      // and get it posted after verification of strain balance.
      $result = $this->postFormD($input);

      if($result)
      {
        $msg = "Issue Request Submission Successful";
        $this->irqMessage = $msg;
      }
      else {
        $msg = "Issue Request Submission Failed, Contact Admin";
        $this->irqMessage = $msg;
      }

      $this->resetFormD();

    }
    




}
