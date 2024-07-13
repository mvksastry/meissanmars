<?php

namespace App\Traits\Breed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BCVTerms;

use App\Models\Breeding\Cvterms\Container;
use App\Models\Breeding\Cvterms\Containerhistory;
use Illuminate\Support\Facades\Log;

trait BContainer
{
    use BBase;

	use BCVTerms;

    public function addNew($input )
    {
        // 1. setting the db
        //now make an entry in container history table
        $newContainer = new Container();

        $newContainer->containerID = $input['cage_id'];
        $newContainer->containerName = $input['cageName'];
        $newContainer->comment = $input['cageComment'];
        $newContainer->_containerHistory_key = Containerhistory::max('_containerHistory_key') + 1;
        $newContainer->save();
        Log::channel('coding')->info('New Cage id [ '.$newContainer->_container_key.'] created');

        $newContainerhistory = new Containerhistory();

        $newContainerhistory->_room_key = $input['_room_key'];
        $newContainerhistory->_container_key = $newContainer->_container_key;
        $newContainerhistory->actionDate = $input['datex'];
        $newContainerhistory->_containerStatus_key = $input['cageStatus'];
        $newContainerhistory->save();
        Log::channel('coding')->info('Containerhistory for Cage id [ '.$newContainer->_container_key.'] inserted');

        return true;

    }

}
