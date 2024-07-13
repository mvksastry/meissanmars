<?php

namespace App\Traits\Breed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BEntrySearch;

trait BEditMice
{
  use BBase;
  use BEntrySearch;

  public    $entrySearchResult = false;

  public    $iaMessage, $id, $_mouse_key, $_owner_key, $dobto, $dobfrom, $_sex_key, $cage_id,
            $cageIdParam, $lifeStatus, $_strain_key, $mouse_id,
            $mouseId_contains, $species_name, $queryResult, $searchFor;

	public function pullDetails()
    {
        $input['searchFor'] = $this->searchFor;
        $input['_owner_key'] = $this->_owner_key;
        $input['dobto'] = $this->dobto;
        $input['dobfrom'] = $this->dobfrom;
        $input['_sex_key'] = $this->_sex_key;
        $input['cage_id'] = $this->cage_id;
        $input['cageIdParam'] = $this->cageIdParam;
        $input['lifeStatus'] = $this->lifeStatus;
        $input['_strain_key'] = $this->_strain_key;
        $input['mouse_id'] = $this->mouse_id;
        $input['mouseId_contains'] = $this->mouseId_contains;
        $input['species_name'] = $this->species_name;
        //dd($input);
        $queryResult = $this->searchEntry($input);
        //dd($queryResult);
        $this->queryResult = $queryResult;

        $this->entrySearchResult = true;
    }





}
