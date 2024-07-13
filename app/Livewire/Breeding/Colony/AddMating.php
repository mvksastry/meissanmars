<?php

namespace App\Livewire\Breeding\Colony;

use Livewire\Component;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Support\Facades\Route;

use App\Models\Breeding\Cvterms\CVSpecies;
use App\Models\Breeding\Cvterms\UseScheduleTerm;
use App\Models\Breeding\Cvterms\CVProtocol;
use App\Models\Breeding\Cvterms\Strain;
use App\Models\Breeding\Cvterms\CVGeneration;
use App\Models\Breeding\Cvterms\CVPhenotype;
use App\Models\Breeding\Cvterms\Lifestatus;
use App\Models\Room;
use App\Models\Breeding\Cvterms\CVCoatcolor;
use App\Models\Breeding\Cvterms\CVDiet;
use App\Models\Breeding\Cvterms\Owner;
use App\Models\Breeding\Cvterms\CVOrigin;
use App\Models\Breeding\Cvterms\Container;
use App\Models\Breeding\Cvterms\CVMatingtype;
use App\Models\Breeding\Colony\Mouse;
use App\Models\Breeding\Colony\Mating;

// Traits below
use App\Traits\Breed\BEditMice;
use App\Traits\Breed\BContainer;
use App\Traits\Breed\BAddMating;

class AddMating extends Component
{
    // display panels/divisions default state
    use BEditMice, BContainer, BAddMating;

    //message here
    public $iaMessage;

    //form state declarations
    public $showMatingEntryForm, $showEntrySearchForm = false, $formCageSelect =false, $formCageNew = false;

    public $strains, $generations, $diets;

    //variable declarations
    public $speciesName, $purpose, $newmatingId;
    public $dam1Key, $dam1Msg, $dam2Key, $dam2Msg, $sireKey, $sireMsg;
    public $dam1Id, $dam2Id, $sireId, $diet_key, $strain_key, $matgType, $generation_key;
    public $genotypeneed, $ownerwg, $matingDate,  $weantime, $cage_id, $weannote, $comments;
    public $matingType, $species_name, $lifestatus, $owners, $dam1=1, $dam2=2, $sire=3;

    public $rooms, $cageChars, $cageParams, $cageName, $cageStatus, $cageRooms, $datex;
    public $cageCreateMessage="", $cageComment, $dam1CageId, $dam2CageId, $sireCageId;

    public $dam1Strain, $dam2Strain, $sireStrain, $dam1Diet, $dam2Diet, $sireDiet;

    public $asdam1, $asdam2, $assire, $iaSearchMessage, $searchFor;
    //status declarations

    public function render()
    {
      $this->dam1IdCheck($this->dam1Id);
      $this->dam2IdCheck($this->dam2Id);
      $this->sireIdCheck($this->sireId);

      return view('livewire.breeding.colony.add-mating');
    }

    public function dam1IdCheck($dam1Id)
    {
      $qry = Mouse::with('strainSelected')->where('ID', $this->dam1Id)->where('sex', 'F')->first();
      if(!empty($qry))
      {
          $this->dam1Key = $qry->_mouse_key;
          $qry2 = Mating::where('_dam1_key', $qry->_mouse_key)
                          ->orWhere('_dam2_key', $qry->_mouse_key)->get();
          if(count($qry2) == 0 ){
              $this->dam1Strain = $qry->strainSelected->strainName;
              $this->dam1CageId = $qry->_pen_key;
              $this->dam1Diet = $qry->diet;
              $this->dam1Msg = 'Yes; No Entries';
          }
          else {
              $this->dam1Msg = 'No; Part of other';
          }
      }
      else{
          $this->dam1Msg = "Not Found/Female";
      }
    }

    public function dam2IdCheck($dam2Id)
    {
      $qry = Mouse::with('strainSelected')->where('ID', $this->dam2Id)->where('sex', 'F')->first();
      if(!empty($qry)){
          $this->dam2Key = $qry->_mouse_key;
          $qry2 = Mating::where('_dam1_key', $qry->_mouse_key)
                          ->orWhere('_dam2_key', $qry->_mouse_key)->get();
          if(count($qry2) == 0 ){
              $this->dam2Strain = $qry->strainSelected->strainName;
              $this->dam2CageId = $qry->_pen_key;
              $this->dam2Diet = $qry->diet;
              $this->dam2Msg = 'Yes; No Entries';
          }
          else {
              $this->dam2Msg = 'No; Part of other';
          }
      }
      else{
          $this->dam2Msg = "Not Found/Female";
      }
    }

    public function sireIdCheck($sireId)
    {
      $qry = Mouse::with('strainSelected')->where('ID', $this->sireId)->where('sex', 'M')->first();
      if(!empty($qry)){
          $this->sireKey = $qry->_mouse_key;
          $qry2 = Mating::where('_sire_key', $qry->_mouse_key)->get();
          if(count($qry2) == 0 ){
              $this->sireStrain = $qry->strainSelected->strainName;
              $this->sireCageId = $qry->_pen_key;
              $this->sireDiet = $qry->diet;
              $this->sireMsg = 'Yes; No Entries';
          }
          else {
              $this->sireMsg = 'No; Part of other';
          }
      }
      else{
          $this->sireMsg = "Not Found/Male";
      }
    }

    public function show($id)
    {
      if($id == 1) { $speciesName = "Mice"; $this->iaMessage = "Selected Mice"; }
      if($id == 4) { $speciesName = "Rat";  $this->iaMessage = "Selected Rat"; }
          $this->speciesName = $speciesName;
          $this->strains = Strain::where('_species_key', $id)->get();
          $this->generations = CVGeneration::all();
          $this->matingType = CVMatingtype::all();
          $this->diets = CVDiet::where('_species_key', $id)->get();
          $this->owners = Owner::all();
          $this->purpose = "New";

      $this->showMatingEntryForm = true;
    }

    public function search($speciesName)
    {

      $exr = explode('_', $speciesName);

      $this->species_name = $speciesName;
      if( $exr[0] == "Mice" )     { $_species_key = 1; }
      if( $exr[0] == "Rat" )      { $_species_key = 2; }
      if( $exr[0] == "Rabbit" )   { $_species_key = 3; }
      if( $exr[0] == "Guinea_Pig"){ $_species_key = 4; }
      
      $this->searchFor = $exr[1];
      $this->strains = Strain::where('_species_key', $_species_key)->get();
      $this->generations = CVGeneration::all();
      $this->matingType = CVMatingtype::all();
      $this->lifestatus = Lifestatus::all();
      $this->owners = Owner::all();

      $this->showEntrySearchForm = true;
    }

    public function post()
    {
      $this->iaMessage = "Welcome, Pay attention to fields";

      $input['speciesName'] = $this->speciesName;
      //$this->validate(['speciesName' => 'required|alpha']);
      $input['purpose'] = $this->purpose;
      //$this->validate(['purpose' => 'required|alpha']);
      $input['dam1Id'] = $this->dam1Id;
      //$this->validate(['purpose' => 'required|numeric']);
      $input['dam1Key'] = $this->dam1Key;

      $input['dam2Id'] = $this->dam2Id;
      //$this->validate(['purpose' => 'required|numeric']);
      $input['dam2Key'] = $this->dam2Key;

      $input['sireId'] = $this->sireId;
      //$this->validate(['purpose' => 'required|numeric']);
      $input['sireKey'] = $this->sireKey;

      $input['diet_key'] = $this->diet_key;
      //$this->validate(['_diet_key' => 'required|numeric']);
      $input['strain_key'] = $this->strain_key;
      //$this->validate(['_strain_key' => 'required|numeric']);
      $input['matgType'] = $this->matgType;
      //$this->validate(['_strain_all' => 'required|numeric']);
      $input['generation_key'] = $this->generation_key;
      //$this->validate(['_generation_key' => 'required|numeric']);
      $input['genotypeneed'] = $this->genotypeneed;
      //$this->validate(['dob' => 'required|date_format:Y-m-d']);
      $input['ownerwg'] = $this->ownerwg;
      //$this->validate(['_sex_key' => 'required|numeric']);
      $input['matingDate'] = $this->matingDate;
      //$this->validate(['_breedingStatus_key' => 'required|numeric']);
      $input['weantime'] = $this->weantime;
      //$this->validate(['weantime' => 'required|numeric']);
      $input['cage_id'] = $this->cage_id;
      //$this->validate(['cage_id' => 'required|numeric']);
      $input['weannote'] = $this->weannote;
      //$this->validate(['weannote' => 'required|numeric']);
      $input['comments'] = $this->comments;
      //$this->validate(['comments' => 'required|numeric']);

      //dd($input);
      $result = $this->addMating($input);

      $this->iaMessage = "Mating Creation Success";
    }

    public function pick($id)
    {
      $ix = explode('_', $id);
      if($ix[0] === "Dam1"){
          $this->dam1Id = $ix[1];
      }
      if($ix[0] === "Dam2"){
          $this->dam2Id = $ix[1];
      }
      if($ix[0] === "Sire"){
          $this->sireId = $ix[1];
      }
      $this->entrySearchResult = false;
      $this->showEntrySearchForm = false;
    }

    public function cageSearch()
    {
      $this->rooms = Room::all();
      $this->formCageSelect = true;
    }

    public function searchCage()
    {
      $input['cageParams'] = $this->cageParams;
      $input['cageChars'] = $this->cageChars;
      $input['cageName'] = $this->cageName;
      $input['cageStatus'] = $this->cageStatus;
      $input['cageRooms'] = $this->cageRooms;

      dd($input);
    }


    // make an entry in container table and a
    // corresponding entry in containerhistory
    public function cageNew()
    {
      $this->cageChars = Container::max('containerID') + 1;
      $this->datex = date('Y-m-d');
      $this->rooms = Room::all();
      $this->formCageNew = true;
    }

    public function addNewCage()
    {
      if($this->nextCageId){
          $input['cage_id'] = $this->cageChars + 1;
      }
      else {
          $input['cage_id'] = $this->cageChars;
      }

      $input['cageName'] = $this->cageName;
      $input['cageStatus'] = $this->cageStatus[0];
      $input['datex'] = $this->datex;
      $input['cageRooms'] = $this->cageRooms[0];
      $input['cageComment'] = $this->cageComment;

      // all info collection complete, go for db entry
      $newCageId = $this->addNew($input); // finish creating new cage

      //now set the new cage to the form field
      $this->cage_id = $newCageId;

      $this->cageCreateMessage = "New cage Id [ ".$newCageId." ] created";
    }

    public function closeSearchCage()
    {
      $this->formCageSelect = false;
    }

    public function closeNewCage()
    {
      $this->formCageNew = false;
    }

    public function resetform(){

    }

    
}
