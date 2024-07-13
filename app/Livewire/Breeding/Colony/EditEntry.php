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

use App\Models\Breeding\Colony\Mouse;
use App\Models\Breeding\Cvterms\CVSpecies;
use App\Models\Breeding\Cvterms\Usescheduleterm;
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
use App\Models\Breeding\Cvterms\Phenotypemouselink;
use App\Models\Breeding\Cvterms\Useschedule;

// Traits below
use App\Traits\Breed\BEditMice;
use App\Traits\Breed\BContainer;

class EditEntry extends Component
{
      // display panels/divisions default state
    use BEditMice, BContainer;

    public $iaMessage;

    public $showEditForm, $entry, $purpose="Edit", $formEditDetail, $speciesName, $strains, $lifestatus, $owners;
    public $formCageSelect =false, $formCageNew = false;
    public $_protocol_key, $containerId, $generations, $rooms, $coatcolors, $diets, $origins;
    public $usescheduleterm_key, $_litter_key, $_strain_all, $_strain_key;
    public $_generation_key, $dob, $_sex_key, $_lifeStatus_key, $_breedingStatus_key, $cage_id,
    $_room_key, $_coatColor_key, $_diet_key, $_owner_key, $_origin_key, $cmsg,
    $replacement_tag, $comments, $cage_card, $automiceid, $usenextid, $count=0, $vialId, $vialIdposition,
    $_phenotype_key, $pad=3, $aumIdFlag = false, $lastIdVal=1, $cage_code;

    public $protocols, $phenotypes, $av, $av2, $roomInfo, $protoSelected, $useScheduleTerms;

    public $cageParams, $cageChars, $nextCageId, $cageName, $datex, $cageRooms, $cageComment, $cageStatus;
    public $cageCreateMessage="";
    
    public function render()
    {
        return view('livewire.breeding.colony.edit-entry');
    }
    
    public function show($id)
    {
        switch ($id){
            case 1:
                $this->iaMessage = "Selected Mice";
                $this->species_name = "Mice";
            break;
    		case 4:
                $this->iaMessage = "Selected Rat";
                $this->species_name = "Rat";
            break;
            default:
            $this->iaMessage = "Whoops! I couldn't get any";
        }

        $this->strains = Strain::where('_species_key', $id)->get();
        $this->lifestatus = Lifestatus::all();
        $this->owners = Owner::all();
        //finally open the view
        $this->showEditForm = true;
    }

    public function edit($id)
    {
        $this->formCageSelect = false;
        $this->formCageNew = false;
        //now fetch the details and show in edit form
        //use the same code to post edit.
        $this->entry = Mouse::with('protoSelected')
                            ->with('strainSelected')
                            ->with('genSelected')
                            ->with('lifestatusSelected')
                            ->with('originSelected')
                            ->with('ownerSelected')
                            ->where('ID', $id)->first();
        //dd($this->entry);
        $this->speciesKey = $this->entry->_species_key;

        $q1 = CVSpecies::where('_species_key', $this->speciesKey)->first();
		$this->speciesName = $q1->species;


        $this->useScheduleTerms = Usescheduleterm::all();
		$this->protocols = CVProtocol::where('_species_key', $this->speciesKey)->get();
		$this->strains = Strain::where('_species_key', $this->speciesKey)->get();
		$this->generations = CVGeneration::all();
		$this->phenotypes = CVPhenotype::where('_species_key', $this->speciesKey)->get();
		$this->lifestatus = Lifestatus::all();
		$this->rooms = Room::all();
		$this->coatcolors = CVCoatcolor::where('_species_key', $this->speciesKey)->get();
		$this->diets = CVDiet::where('_species_key', $this->speciesKey)->get();
		$this->owners = Owner::all();
		$this->origins = CVOrigin::all();
		$this->containerId = Container::max('containerID');
		$this->cage_code = $this->containerId;

        $this->roomInfo = Container::where('_container_key', $this->entry->_pen_key )->first();

        //$this->cage_id = $this->entry->_pen_key;

        //dd($this->entry); //everything is supposed as it should be

        //now get the keys of phenotype mouse link selected
        //we need to process for the form so that loops are avoided.
        $phenolinks = Phenotypemouselink::with('phenotypeDesc')
                                                ->where('_mouse_key', $this->entry->_mouse_key)->get();
        foreach($phenolinks as $link)
        {
            $va = $link->phenotypeDesc;
            foreach($va as $row){
                $av[] = $row->phenotype;
            }
        }
        $this->av = $av;
        //dd($av);

        //get the use schedules selected by the user and show him
        // the original options.
        $uschterms = Useschedule::with('useSchTerms')->where('_mouse_key', $this->entry->_mouse_key)->get();
        foreach($uschterms as $link){
            $xc = $link->useSchTerms;
            foreach($xc as $row){
                $av2[] = $row->useScheduleTermName;
            }

        }
        $this->av2 = $av2;
        //with the above use schedules are also corrected


        //now render form fields to set preexisting values.
        foreach($this->entry as $row){
            $xd = $this->entry->protoSelected;
            foreach($xd as $val){
                $protoSelected = $xd->id;
            }
        }
        $this->protoSelected = $protoSelected;

        $this->formEditDetail = true;
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
    public function cagenew()
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


    //update the edited mouse data
    public function update($id)
    {
        $this->iaMessage = "Welcome, Pay attention to fields";
        $input['id'] = $id;
        $input['speciesName'] = $this->speciesName;
        //$this->validate(['speciesName' => 'required|alpha']);
        $input['purpose'] = $this->purpose;
        //$this->validate(['purpose' => 'required|alpha']);
        $this->iaMessage = $input['speciesName'];
        //$input['strainId'] = $this->strainId; //to get from the db..
        $input['_protocol_key'] = $this->_protocol_key;
        //$this->validate(['purpose' => 'required|numeric']);
        $input['usescheduleterm_key'] = $this->usescheduleterm_key;
        //if($input['usescheduleterm_key'] == null) { $input['usescheduleterm_key'] = array(); }
        //$this->validate(['usescheduleterm_key' => 'required|numeric']);
        $input['_litter_key'] = $this->_litter_key;
        //$this->validate(['_litter_key' => 'required|numeric']);
        $input['_strain_all'] = $this->_strain_all;
        //$this->validate(['_strain_all' => 'required|numeric']);
        $input['_strain_key'] = $this->_strain_key;
        //$this->validate(['_strain_key' => 'required|numeric']);
        //$input['_generation_key'] = $this->_generation_key;
        //$this->validate(['_generation_key' => 'required|numeric']);
        //$input['dob'] = $this->dob;
        //$this->validate(['dob' => 'required|date_format:Y-m-d']);
        //$input['_sex_key'] = $this->_sex_key;
        //$this->validate(['_sex_key' => 'required|numeric']);
        $input['_lifeStatus_key'] = $this->_lifeStatus_key;
        //$this->validate(['lifeStatus' => 'required|numeric']);
        $input['_breedingStatus_key'] = $this->_breedingStatus_key;
        //$this->validate(['_breedingStatus_key' => 'required|numeric']);
        //$input['cage_id'] = $this->cage_id;
        //$this->validate(['cage_id' => 'required|numeric']);
        /*
        if($this->usenextid)
        {
            $this->count = $this->count + 1;
            if($this->count > $this->deflimit )
            {
                $input['cage_id'] = $this->nextid($this->cage_code, $this->lastIdVal);
                $this->count = 0;
            }
        }
        else {
            $this->cage_id = $this->cage_code;
            $input['cage_id'] = $this->cage_code;
            $this->count = $this->count + 1;

            if($this->deflimit == null )
            {
                $this->cmsg = "Note: Set Default capacity";
            }

            if($this->count > $this->deflimit )
            {
                $this->cmsg = "Note: Default capacity breached";
            }
        }
        */
        $input['_room_key'] = $this->_room_key;
        //$this->validate(['_room_key' => 'required|numeric']);
        $input['_coatColor_key'] = $this->_coatColor_key;
        //$this->validate(['_coatColor_key' => 'required|numeric']);
        $input['_diet_key'] = $this->_diet_key;
        //$this->validate(['_diet_key' => 'required|numeric']);
        //$input['_owner_key'] = $this->_owner_key;
        //$this->validate(['_owner_key' => 'required|numeric']);
        $input['_origin_key'] = $this->_origin_key;
        //$this->validate(['_origin_key' => 'required|numeric']);
        $input['replacement_tag'] = $this->replacement_tag;
        //$this->validate(['replacement_tag' => 'required|numeric']);
        $input['_phenotype_key'] = $this->_phenotype_key;
        //$this->validate(['phenotypes' => 'required|numeric']);
        $input['comments'] = $this->comments;
        //$this->validate(['comments' => 'required|numeric']);
        $input['cage_card'] = $this->cage_card;
        //$this->validate(['cage_card' => 'required|numeric']);
        //$this->iaMessage = $input['speciesId'];
        //$this->iaMessage = "Entering Trait";
        $input['vialId'] = $this->vialId;
        $input['vialIdposition'] = $this->vialIdposition;

        // with this all collectable fields are obtianed
        // verify that the values are collected properly and go
        // insert into db.
        dd($input);
    }




    
}
