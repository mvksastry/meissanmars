<?php

namespace App\Traits\Breed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BCVTerms;

use App\Models\Mortality;

use App\Models\Breeding\Colony\Mouse;
use App\Models\Breeding\Colony\Mating;
use App\Models\Breeding\Colony\Litter;
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
    public function addLitterData($purpose, $input)
    {
			  // 1. setting the db
        // 2. preparing the data.
				$totalRemoved = 0;
				
				if($input['numFemales'] == "")
				{
					$input['numFemales'] = null;
				}
				
				if($input['numMales'] == "")
				{
					$input['numMales'] = null;
				}

				if($input['culledAtWean'] == "")
				{
					$input['culledAtWean'] = 0;
				}
				
				if($input['missAtWean'] == "")
				{
					$input['missAtWean'] = 0;
				}
				
				if($input['bornDead'] == "")
				{
					$input['bornDead'] = 0;
				}
					
        $version = 1;

				switch ($purpose) {
					
						case "Update" :
							$litterKey = $this->curLitterKey;
							$litterEntry = Litter::where('_litter_key', $litterKey)->first();
						break;
						
						case "New":
							$litterKey = Litter::max('_litter_key') + 1;
							$litterEntry = new Litter();									
						break;
						
						default:
						echo "Whoops! Something wrong in selection.";
				}

				//4. inset sql array prepartion.

				$litterEntry->_litter_key         = $litterKey;
				$litterEntry->_mating_key         = $input['matKey'];
				$litterEntry->_theilerStage_key   = null;
				$litterEntry->_species_key        = $input['xspecies_id'];
				$litterEntry->_strain_key         = $input['xstrain_id'];
				$litterEntry->litterID            = $litterKey * 10;
				$litterEntry->totalBorn           = $input['totalBorn'];
				$litterEntry->birthDate           = $input['dateBorn'];
				$litterEntry->numFemale           = $input['numFemales'];
				$litterEntry->numMale             = $input['numMales'];
				$litterEntry->numberBornDead      = $input['bornDead'];
				$litterEntry->numberCulledAtWean  = $input['culledAtWean'];
				$litterEntry->numberMissingAtWean = $input['missAtWean'];
				$litterEntry->weanDate            = $input['weanDate'];
				$litterEntry->tagDate             = $input['tagDate'];
				$litterEntry->status              = $input['birthEventStatusKey'];
				$litterEntry->entry_status        = 'open';
				$litterEntry->entry_status_date   = date('Y-m-d');
				$litterEntry->comment             = $input['coment'];
				$litterEntry->version             = $version;
				$litterEntry->_litterType_key     = $input['litType'];
				$litterEntry->harvestDate         = date('Y-m-d');
				$litterEntry->numberHarvested     = $input['totalBorn'] - $input['bornDead'];

				$totalRemoved = $input['bornDead'] + $input['culledAtWean'] + $input['missAtWean'];
				
	      Log::channel('coding')->info('array ready for insert, before try');
           //Stage 5. insert
           //dd($purpose, $litterKey, $input, $litterEntry);
					 
           try {
								$result = $litterEntry->save();		
								
								if($result)
								{
									if($totalRemoved > 0 )
									{
										$result = $this->postLitterMortality($input);
									}
								}
								
								$msg = $purpose." Litter Entry Success";
								Log::channel('coding')->info($msg);
								return true;
            }
            catch (\Illuminate\Database\QueryException $e ) {
								$result2Fail = DB::rollback();
                $eMsg = $e->getMessage();
                Log::channel('coding')->info($eMsg);
								$msg = $purpose." Litter Entry Failed";
								Log::channel('coding')->info($msg);
								return false;
            }
        //return $msg;
    }
		
		public function putPupsToDB($input)
		{
			
			
		}
		
		public function postLitterMortality($input)
		{
			//now make an entry in mortality table
				$mort = new Mortality(); 
				$mort->species_id = $input['xspecies_id'];
				$mort->strain_id = $input['xstrain_id'];
				$mort->project_id = null;
				$mort->pi_id = null;
				$mort->number_dead = $input['bornDead']+$input['culledAtWean']+$input['missAtWean'];
				$mort->colony_info = $input['colonyInfo'];
				$mort->strain_incharge_id = Auth::id();
				$mort->cage_id = null;
				$mort->slot_index = Mating::where('_mating_key', $input['matKey'])->value('suggestedPenID');
				$mort->date_death = date('Y-m-d');
				$mort->cod = $input['cofdeath'];
				$mort->notes = $input['mortNotes'];
				$mort->posted_by = Auth::id();
				$mort->date_posted = date('Y-m-d');
				$mort->save();
				$msg = "Dead Litter/still born Entry Success";
				Log::channel('coding')->info($msg);
				return true;
		}

}
