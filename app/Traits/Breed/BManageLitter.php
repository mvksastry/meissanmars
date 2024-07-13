<?php

namespace App\Traits\Breed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BCVTerms;


use App\Models\Breeding\Colon\Mouse;
use App\Models\Breeding\Colon\Mating;
use App\Models\Breeding\Colon\Litter;
use App\Models\Breeding\Cvterms\Phenotypemouselink;
use App\Models\Breeding\Cvterms\Usescheduleterm;
use App\Models\Breeding\Cvterms\Useschedule;

use Illuminate\Support\Facades\Log;

trait BManageLitter
{
    use BBase, BCVTerms;

	    /* Before addition, we must do the following.
       1. First add a cage to the system.
          select that cage and add the new mice
          We can also select an existing cage for this purpose.
       2. Add the mouse info phenotype of the mouse to the phenotypemouselink table
       3. Add info to the mouseusage table for each row.
       4. Add the mouse info to useschedule table

       Everywhere the following procedure is to be followed

       1. set the db first.
       2. prepare the data from request object passed.
       3. Do all calculations etc, like getting the id, max number etc...
       4. prepare the sql insert array
       5. insert with try catch and catch all exception.
       6. prepare the return message with errors if any.

    */
    ///////////////////////////////////////////////////////////////////////
    public function addLitterData($input)
    {
        // 1. setting the db
        // 2. preparing the data.
        $version = 1;

                switch ($input['purpose']) {
                    case "Edit" :
                    break;
                    case "New":
                    break;
                    default:
                    echo "Whoops! Something wrong in selection.";
                }

                    //4. inset sql array prepartion.

                    $litterKey = Litter::max('_litter_key') + 1;
                    //dd($addMiceEntry);
                    $newLitterEntry = new Litter();

                    $newLitterEntry->_litter_key         = $litterKey;
                    $newLitterEntry->_mating_key         = $input['matKey'];
                    $newLitterEntry->_theilerStage_key   = null;
                    $newLitterEntry->litterID            = $litterKey * 10;
                    $newLitterEntry->totalBorn           = $input['totalBorn'];
                    $newLitterEntry->birthDate           = $input['dateBorn'];
                    $newLitterEntry->numFemale           = $input['numFemales'];
                    $newLitterEntry->numMale             = $input['numMales'];
                    $newLitterEntry->numberBornDead      = $input['bornDead'];
                    $newLitterEntry->numberCulledAtWean  = $input['culledAtWean'];
                    $newLitterEntry->numberMissingAtWean = $input['missAtWean'];
                    $newLitterEntry->weanDate            = $input['weanDate'];
                    $newLitterEntry->tagDate             = $input['tagDate'];
                    $newLitterEntry->status              = $input['birthEventStatusKey'];
                    $newLitterEntry->comment             = $input['coment'];
                    $newLitterEntry->version             = $version;
                    $newLitterEntry->_litterType_key     = $input['litType'];
                    $newLitterEntry->harvestDate         = null;
                    $newLitterEntry->numberHarvested     = null;


	       Log::channel('coding')->info('array ready for insert, before try');
           //Stage 5. insert
           //dd($newMouseEntry);
           try {
               // ehck for duplicate entry and prevent it
               $qry = Litter::where('_mating_key', $input['matKey'])->first();

               if(empty($qry) || $qry == null){
                   $newLitterEntry->save();
                   $msg = "Litter Entry Success";
               }
               else {
                   $msg = "Rejected: Duplicate Litter Entry";
               }
            }
            catch (\Illuminate\Database\QueryException $e ) {
                $result2Fail = Litter::rollback();
                $msg = $e->getMessage();

                $qResultMsg = $qResultMsg."</br>".$eMsg."</br>";
                $result1 = false;
            }
        return $msg;
    }

}
