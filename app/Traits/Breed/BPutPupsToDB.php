<?php

namespace App\Traits\Breed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BCVTerms;

use App\Models\Slot;
use App\Models\Breeding\Bcage;
use App\Models\Cage;
use App\Models\Breeding\Colony\Mouse;

use App\Models\Breeding\Cvterms\Phenotypemouselink;
use App\Models\Breeding\Cvterms\Usescheduleterm;
use App\Models\Breeding\Cvterms\Useschedule;

use Illuminate\Support\Facades\Log;

trait BPutPupsToDB
{

	public function processPupsToDBEntries($cagesMF, $numMFPerCage, $MFGroup, $rack_id, $rarray)
	{

		$lk = 0;
		for($k=0; $k < $cagesMF; $k++)
		{
			$mice_idx = array();
			$numberF = $numMFPerCage[$k];

			for($i=0; $i < $numberF; $i++)
			{
				$miceArrayInfo = $MFGroup[$lk]; //first mice entry in the array
				
				unset($miceArrayInfo['RefID']);
				
				array_push($mice_idx, $miceArrayInfo['ID']);
				
				$miceArrayInfo['_mouse_key'] = $this->getMaxMouseKey();
				//perfect untill here.
				//dd($mice_idx, $miceArrayInfo);
				$msgx2 = 'Data collection for [ '.$miceArrayInfo['ID'].'] insert array complete';
				Log::channel('coding')->info($msgx2);
				array_push($this->success_box, $msgx2);

				//now insert into db here using try catch to revert if any error
				
				try {
							$result = Mouse::UpdateOrCreate($miceArrayInfo);
							$msgx1 = 'Mouse Id [ '.$miceArrayInfo['ID'].' ] creation success';
							array_push($this->success_box, $msgx1);
							Log::channel('coding')->info($msgx1);
				}

				catch (\Illuminate\Database\QueryException $e ) {
                $result = DB::rollback();
                $eMsg = $e->getMessage();
								array_push($this->error_box, $eMsg);
								Log::channel('coding')->info('Entry ID [ '.$eMsg.' ] creation fail');
                //dd($eMsg);
                $result = false;
				}
				//before loop restarts, no need to unset the key you are done with
				//as we are using for loop, loop will pick running index value
				$lk = $lk + 1;
			}
			
			//dd($mice_idx);
			$miceArrayInfo['animal_count'] = $numberF;
			$miceArrayInfo['mice_ids'] = $mice_idx;
			$miceArrayInfo['rack_id'] = $rack_id;
			$miceArrayInfo['slot_id'] = $rarray[0];
			
			$result = $this->updateRackSlotCageInfo($miceArrayInfo);
			//$result = true;
			if($result)
			{
				array_push($this->success_box, "Cage Insertion, Rack Update and Mouse location updates success");
			}
			else {
				array_push($this->error_box, "Cage Insertion, Rack Update and Mouse location updates failed");
			}

			//before the loop goes back
			//prepare for cage insertion
			//this must be $this->rarray because the array must be adjusted after every entry.
			unset($rarray[0]);  
			$this->mice_idx = [];
			if(count($rarray) != 0)
			{
				$rarray = array_values($rarray);
				$this->slot_id = $rarray[0];
			}
			else {
				$this->slot_error_msg = "Select New Rack";
				array_push($this->error_box, $this->slot_error_msg);
			}	
		}

	}
}