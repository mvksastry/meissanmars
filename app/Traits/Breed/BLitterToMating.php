<?php

namespace App\Traits\Breed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BCVTerms;

use App\Models\Breeding\Colony\Mouse;
use App\Models\Breeding\Colony\Mating;
use App\Models\Breeding\Cvterms\Matingunitlink;

use Illuminate\Support\Facades\Log;

trait BLitterToMating
{
		use BBase;

		use BCVTerms;

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
		public function addMatingThroughLitter($input)
		{
				// 1. setting the db
				//$mcmsTables = $this->setMcmsDB();
				// 2. preparing the data.
				$qResultMsg = "";
				//$purpose = $input['purpose'];
				//$speciesName = $input['speciesName'];
				$matingKey   = Mating::max('_mating_key') + 1;
				$matingRefID = Mating::max('matingRefID') + 1;
				//dd($this->newMatingId);
				$matingUnitTypeKey = null; //entry for second table
				
				//query the db to get the  keys by ID here for dam1, dam2 and sire IDs.
				if($input['dam1ID'] != null)
				{
					$dam1_key = Mouse::where('ID', $input['dam1ID'])->value('_mouse_key'); 
				}
				else {
					$dam1_key = null;
				}
				
				if($input['dam2ID'] != null)
				{
					$dam2_key = Mouse::where('ID', $input['dam2ID'])->value('_mouse_key'); 
				}
				else {
					$dam2_key = null;
				}
				
				if($input['sireID'] != null)
				{
					$sire_key = Mouse::where('ID', $input['sireID'])->value('_mouse_key'); 
				}
				else {
					$sire_key = null;
				}
				
				$newMatingEntry = new Mating();

				$newMatingEntry->_mating_key     = $matingKey;
				$newMatingEntry->matingRefID     = $matingRefID;
				$newMatingEntry->_species_key    = $input['_species_key'];
				$newMatingEntry->_matingType_key = $input['_matingType_key'];
				$newMatingEntry->_dam1_key       = $dam1_key;
				$newMatingEntry->_dam2_key       = $dam2_key;
				$newMatingEntry->_sire_key       = $sire_key;
				$newMatingEntry->_strain_key     = $input['_strain_key'];
				$newMatingEntry->matingID        = $matingKey;
				$newMatingEntry->suggestedPenID  = null; //this is slot_index accurate with
																															//rack info
				$newMatingEntry->weanTime        = $input['weanTime'];
				$newMatingEntry->matingDate      = $input['matingDate'];
				$newMatingEntry->generation      = $input['generation_key'];
				$newMatingEntry->owner           = $input['ownerwg'];
				$newMatingEntry->weanNote        = $input['weanNote'];
				$newMatingEntry->needsTyping     = $input['needsTyping'];
				$newMatingEntry->comment         = $input['comment'];
				$newMatingEntry->proposedDiet    = $input['proposedDiet'];
				$newMatingEntry->version         = $input['version'];
				//data collection complete
				//dd($newMatingEntry);
				$msg = 'Data collection for mating id [ '.$matingRefID.'] complete';
				array_push($this->msgLTM, $msg);
				Log::channel('coding')->info($msg);

					 //Stage 5. insert
					 //dd($newMouseEntry);
				try {
						$result = $newMatingEntry->save();
						$msg= 'Mating Id [ '.$matingRefID.' ] creation success';
						array_push($this->msgLTM, $msg);
						Log::channel('coding')->info($msg);

						if(!empty($input['_dam1_key'])){
								$mUnitTypeKey  = 1;
								//$result = $this->insertNewMULK($matingKey, $input['_dam1_key'], $sampleKey=null, $mUnitTypeKey);
								$msg = 'Mating unit link Id for [ '.$input['_dam1_key'].' ] success';
								array_push($this->msgLTM, $msg);
								Log::channel('coding')->info($msg);
						}
						if(!empty($input['_dam2_key'])){
								$mUnitTypeKey  = 1;
								//$result = $this->insertNewMULK($matingKey, $input['_dam2_key'], $sampleKey=null, $mUnitTypeKey);
								$msg = 'Mating unit link Id for [ '.$input['_dam2_key'].' ] success';
								array_push($this->msgLTM, $msg);
								Log::channel('coding')->info($msg);
						}
						if(!empty($input['_sire_key'])){
								$mUnitTypeKey  = 2;
								//$result = $this->insertNewMULK($matingKey, $input['_sire_key'], $sampleKey=null, $mUnitTypeKey);
								$msg = 'Mating unit link Id for [ '.$input['_sire_key'].' ] success';
								array_push($this->msgLTM, $msg);
								Log::channel('coding')->info($msg);
						}
				}

				catch (\Illuminate\Database\QueryException $e ) {
										$result2Fail = $mcmsTables->rollback();
										$eMsg = $e->getMessage();
										//dd($eMsg);
										$qResultMsg = $qResultMsg."</br>".$eMsg."</br>";
										array_push($this->msgLTM, $qResultMsg);
										Log::channel('coding')->info($qResultMsg);
										$result1 = false;
				}
				// With, we must have completed all entries and return the message to the user.
				//$msg = $qResultMsg;
				return $matingKey;
		}

}
