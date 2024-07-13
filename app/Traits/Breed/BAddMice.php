<?php

namespace App\Traits\Breed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Traits\Breed\BBase;
use App\Traits\Breed\BCVTerms;

use App\Models\Breeding\Colony\Mouse;
use App\Models\Breeding\Cvterms\Phenotypemouselink;
use App\Models\Breeding\Cvterms\Usescheduleterm;
use App\Models\Breeding\Cvterms\Useschedule;

use Illuminate\Support\Facades\Log;

trait BAddMice
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
public function addMice($input)
{
    // 1. setting the db
    //$mcmsTables = $this->setMcmsDB();
    // 2. preparing the data.
    $loginUserId         = Auth::id();
    $version = 1;
    $qResultMsg = "";

    $purpose             = $input['purpose'];
    $speciesName         = $input['speciesName'];

    $mouse_id            = $input['speciesId'];

    $_mouseProtocol_key  = $input['_protocol_key'];
    $usescheduleterm_key = $input['usescheduleterm_key'];
    $_litter_key         = $input['_litter_key'];
    $_strain_all         = $input['_strain_all'];
    $_strain_key         = $input['_strain_key'];
    $generation          = $input['_generation_key'];
    $dob                 = $input['dob'];
    $_sex_key            = $input['_sex_key'];
    $lifeStatus          = $input['_lifeStatus_key'];
    $_breedingStatus_key = $input['_breedingStatus_key'];
    $cage_id             = $input['cage_id'];
    $_room_key           = $input['_room_key'];
    $_coatColor_key      = $input['_coatColor_key'];
    $_diet_key           = $input['_diet_key'];
    $_owner_key          = $input['_owner_key'];
    $_mouseOrigin_key    = $input['_origin_key'];
    $replacement_tag     = $input['replacement_tag'];
    $phenotypes          = $input['_phenotype_key'];
    $comments            = $input['comments'];
    $cage_card           = $input['cage_card'];

    $species_key         = $this->getSpeciesKeyBySpeciesName($speciesName);

    Log::channel('coding')->info('data collection for [ '.$mouse_id.'] insert array seems complete');

    $use_schedulSelected = $usescheduleterm_key;

    $phenotypes_Selected = $phenotypes;

    switch ($purpose) {

        case "Edit" :
            $sampleVialId        = $input['sampleVialId'];
            $sam_vial_tag_pos    = $input['sampleVialTagPosition'];
            $mouse_key = $this->findMouseKeyMatchingMouseId($mouse_id);
        break;

        case "New":
            $sampleVialId        = null;
            $sam_vial_tag_pos    = null;
            $mouse_key = $this->getMaxMouseKey(); // new mouse_key going to be created
        break;

        default:
            echo "Whoops! Something wrong in selection.";
    }


    if(empty($phenotypes_Selected))
    {
      $phenotypes_Selected = array();
    }
    if(empty($use_schedulSelected))
    {
      $use_schedulSelected  = array();
    }
    if(empty($_litter_key))
    {
      $_litter_key = null;
    }
    if(empty($replacement_tag))
    {
      $replacement_tag = null;
    }
    if(empty($exit_date))
    {
      $exit_date = null;
    }
    if(empty($cod))
    {
      $cause_of_death = null;
    }
    if(empty($cod_notes))
    {
        $cod_notes = null;
    }
    if(empty($sampleVialId))
    {
      $sampleVialId = null;
    }
    if(empty($sam_vial_tag_pos))
    {
      $sam_vial_tag_pos = null;
    }
    if(empty($plugDate_key))
    {
      $plugDate_key = null;
    }
    if(empty($comment))
    {
      $comment = null;
    }
    if(empty($done))
    {
      $done = 0;
    }

    //4. inset sql array prepartion.
    $addMiceEntry = array(
                    '_species_key'          => $species_key,
                    '_mouse_key'            => $mouse_key,
                    '_litter_key'           => $_litter_key,
                    '_strain_key'           => $_strain_key,
                    '_pen_key'              => $cage_id,
                    'ID'                    => $mouse_id,
                    'newTag'                => $replacement_tag,
                    'birthDate'             => $dob,
                    'exitDate'              => $exit_date,
                    'cod'                   => $cause_of_death,
                    'codNotes'              => $cod_notes,
                    'generation'            => $generation,
                    'sex'                   => $_sex_key,
                    'lifeStatus'            => $lifeStatus,
                    'breedingStatus'        => $_breedingStatus_key,
                    'coatColor'             => $_coatColor_key,
                    'diet'                  => $_diet_key,
                    'owner'                 => $_owner_key,
                    'origin'                => $_mouseOrigin_key,
                    'protocol'              => $_mouseProtocol_key,
                    'comment'               => $comments,
                    'sampleVialID'          => $sampleVialId,
                    'sampleVialTagPosition' => $sam_vial_tag_pos,
                    'version'               => $version,
                    );


                    //dd($addMiceEntry);
                    $newMouseEntry = new Mouse();

                    $newMouseEntry->_mouse_key            = $mouse_key;
                    $newMouseEntry->_species_key          = $species_key;
                    $newMouseEntry->_litter_key           = $addMiceEntry['_litter_key'];
                    $newMouseEntry->_strain_key           = $addMiceEntry['_strain_key'];
                    $newMouseEntry->_pen_key              = $addMiceEntry['_pen_key'];
                    $newMouseEntry->ID                    = $addMiceEntry['ID'];
                    $newMouseEntry->newTag                = $addMiceEntry['newTag'];
                    $newMouseEntry->birthDate             = $addMiceEntry['birthDate'];
                    $newMouseEntry->exitDate              = $addMiceEntry['exitDate'];
                    $newMouseEntry->cod                   = $addMiceEntry['cod'];
                    $newMouseEntry->codNotes              = $addMiceEntry['codNotes'];
                    $newMouseEntry->generation            = $addMiceEntry['generation'];
                    $newMouseEntry->sex                   = $addMiceEntry['sex'];
                    $newMouseEntry->lifeStatus            = $addMiceEntry['lifeStatus'];
                    $newMouseEntry->breedingStatus        = $addMiceEntry['breedingStatus'];
                    $newMouseEntry->coatColor             = $addMiceEntry['coatColor'];
                    $newMouseEntry->diet                  = $addMiceEntry['diet'];
                    $newMouseEntry->owner                 = $addMiceEntry['owner'];
                    $newMouseEntry->origin                = $addMiceEntry['origin'];
                    $newMouseEntry->protocol              = $addMiceEntry['protocol'];
                    $newMouseEntry->comment               = $addMiceEntry['comment'];
                    $newMouseEntry->sampleVialID          = $addMiceEntry['sampleVialID'];
                    $newMouseEntry->sampleVialTagPosition = $addMiceEntry['sampleVialTagPosition'];
                    $newMouseEntry->version               = $addMiceEntry['version'];

	       Log::channel('coding')->info('array ready for insert, before try');
           //Stage 5. insert
           //dd($newMouseEntry);
    try {
          $version = 1;
          //the following three lines are needed for edit not for first posting.
          //$phenotypeKeysInDB   = $this->getPhenotypeKeysMatchingMouseKey($mouse_key);
          //$useScheduleKeysInDB = $this->getAllUseScheduleKeysMatchingMouseKey($mouse_key);
          //$usageKeysInDB       = $this->getAllMouseUseKeysMatchingMouseKey($mouse_key);
		  switch ($purpose) {

				case "New":

				Log::channel('coding')->info('case New encountered');
				//uncomment the line below and delete the line //$result1 = true;
                //$result4 = $mcmsTables->table('mouse')->insert($addMiceEntry);
                //dd($newMouseEntry);
                $result1 = $newMouseEntry->save();
                //dd($result1);
                //$result1 = true;
                if($result1)
                {
                     //block 1 begin
                    Log::channel('coding')->info('Mouse table insert complete');
                    $maxPhenotypeMouseLinkKey = $this->getMaxPhenotypeMouseLinkKey();
					if(!empty($phenotypes_Selected))
					{
						Log::channel('coding')
                                ->info('phenotypes selected = '. count($phenotypes_Selected));

                        for( $i=0; $i < count($phenotypes_Selected); $i++)
						{
						   	//here in case of new entry, there will not be any
							//entries in phenotypemouselink table
							$addSql1 = array(
                                  '_phenotypeMouseLink_key' => $maxPhenotypeMouseLinkKey,
                                  '_phenotype_key' => $phenotypes_Selected[$i],
                                  '_mouse_key' => $mouse_key,
                                  'version' => $version
                                );

                            //$newPhenotypeMouseLinkKey->_phenotypeMouseLink_key => $maxPhenotypeMouseLinkKey;
                            //$res = $mcmsTables->table('phenotypemouselink')->insert($addSql1);
                            $newPhenotypemouselink = new Phenotypemouselink();
                            $newPhenotypemouselink->_phenotype_key = $phenotypes_Selected[$i];
                            $newPhenotypemouselink->_mouse_key = $mouse_key;
                            $newPhenotypemouselink->version = $version;

							$result2 = $newPhenotypemouselink->save();

							Log::channel('coding')->info('phenotypes inserted');
                            // the below line is not needed if the save object works fine
							//$maxPhenotypeMouseLinkKey = $maxPhenotypeMouseLinkKey + 1;
                        }
						Log::channel('coding')->info("Phenotype Mouse Links established for ID [ ".$mouse_id." ] successfull");
					}
					else {
						Log::channel('coding')->info("No phenotype keys selected");
					}
                        //block 1 end
                        // Now, add info to useschedule table, however many useschedules selected by the user
                        $maxUseScheduleKey = $this->getMaxUseScheduleKey();
                        $useScheduleKeys = array();

					if(!empty($use_schedulSelected))
                    {
						Log::channel('coding')->info("total use schedules selected =".count($use_schedulSelected));

                        for( $i=0; $i < count($use_schedulSelected); $i++)
						{
							array_push($useScheduleKeys, $maxUseScheduleKey);

							$addSql2 = array(
                                    '_useSchedule_key' => $maxUseScheduleKey,
                                    '_mouse_key' => $mouse_key,
                                    '_useScheduleTerm_key' => $use_schedulSelected[$i],
                                    '_plugDate_key' => $plugDate_key,
                                    'startDate' => $dob,
                                    'comment' => $comment,
                                    'done' => $done,
                                    'version' => $version
                            );

                            //$mcmsTables->table('useschedule')->insert($addSql2);
                            $newEntryUseschedule = new Useschedule();

                            $newEntryUseschedule->_mouse_key = $mouse_key;
                            $newEntryUseschedule->_useScheduleTerm_key = $use_schedulSelected[$i];
                            $newEntryUseschedule->_plugDate_key = $plugDate_key;
                            $newEntryUseschedule->startDate = $dob;
                            $newEntryUseschedule->comment = $comment;
                            $newEntryUseschedule->done = $done;
                            $newEntryUseschedule->version = $version;

                            $result3 = $newEntryUseschedule->save();
						}
						Log::channel('coding')->info("Use Schedules for Mouse ID [ ".$mouse_key." ] established successfully");
                    }
					else {
					    Log::channel('coding')->info("No useschedules selected");
					}
                    //block 2 end

                    //block 3 begin
                    $plugDate_key = null;
                    $version = 1;
                    $usage_key = $this->getMaxMouseusageKey();
                    $projectedDate = "";
                    // get total number of use schedule terms, daysPostEvent present for a given use schedule
                    //
                    for( $i=0; $i < count($use_schedulSelected); $i++)
                    {
                      //echo " use schedule term key value = ". $use_schedulSelected[$i]; echo "</br>";
                      $daysPostEvent = $this->findAllDaysPostEvent($use_schedulSelected[$i]);
                      $mouseUse = $this->findMouseUseMatchingUseScheduleTermKey($use_schedulSelected[$i]);

                      foreach($daysPostEvent as $row)
                      {
                        $daysPostEvent = $row->daysPostEvent;
                        $projectedDate = date('Y-m-d', strtotime($dob. ' + '.$daysPostEvent.' days'));
                        //echo "Date of Birth = ".$dob; echo "</br>";
                        //echo "Projected Date = ".$projectedDate; echo "</br>";
                        $addSql3 = array(
                                        '_usage_key' => $usage_key,
                                        '_mouse_key' => $mouse_key,
                                        '_plugDate_key' =>  $plugDate_key,
                                        '_useSchedule_key' => $useScheduleKeys[$i],
                                        'use' => $mouseUse,
                                        'useAge' => $daysPostEvent,
                                        'projectedDate' => $projectedDate,
                                        'actualDate' => null,
                                        'done' =>  $done,
                                        'comment' => $comment,
                                        'D1' => null,
                                        'D2' => null,
                                        'D3' => null,
                                        'D4' => null,
                                        'D5' => null,
                                        'D6' => null,
                                        'D7' => null,
                                        'D8' => null,
                                        'D9' => null,
                                        'D10' => null,
                                        'version' => 1
                                     );
                            $result4 = $mcmsTables->table('mouseusage')->insert($addSql3);
                            Log::channel('coding')->info("mouse usage inserted for [ ".$mouse_id." ] Successfully");
                            $result4 = null;
                            $projectedDate = "";
                            $usage_key = $usage_key +1;
                        }
                    }
                    //block 3 end
                    $msg = "Mice with ID [ ".$mouse_id." ] Added Successfully";
					Log::channel('coding')->info($msg);
					return $msg;
                }
                else {
					Log::channel('coding')->info("Error: Mice with ID [ ".$mouse_id." ] Addition Failed");
					return false;
                }

				break;

				case "Edit":

					$mouse_key = $this->findMouseKeyMatchingMouseId($mouse_id);
					// all this code for editing mice entries
                    // first thing to do is to get the mouse data
                    //update the table using the mouse_key value.
                    $result1 = Mouse::where('_mouse_key','=', $mouse_key)->update($addMiceSql);
                    // block 1 non zero code
                    Log::channel('coding')->info("Updated the values of mouse table");
                    /*  steps are as follows:
                     *  1. first get all phenotype keys containing the mouse key.
                     *  2. loop through it against the phenotypes selected by the user.
                     *  3. if a match occurs, keep that entry.
                     *  4. if no match, then delete that entry in the db.
                     */
                    Log::channel('coding')->info("phenotype keys present in DB");

                    $phenotypeKeysToBeKept = array_intersect($phenotypes_Selected, $phenotypeKeysInDB);
                    //echo "phenotype keys to be retained"; print_r($phenotypeKeysToBeKept);echo "</br>";
                    foreach( $phenotypeKeysToBeKept as $key => $value)
                    {
                        //the corresponding phenotype mouse link keys will also be kept
                        //this for loop is just make sure everything is going on ok
                        // this loop does not do anything except for verfication of data
                        // so it is important.
                        //Log::channel('coding')->info("_phenotype key to be kept = ".$value);
                        //echo "_phenotype key to be kept = ".;echo "</br>";
                    }
                    //whatever values present here can be deleted in the db
                    $phenotypeKeysToBeDel = array_diff($phenotypeKeysInDB, $phenotypes_Selected);
                    foreach( $phenotypeKeysToBeDel as $key => $value)
                    {
                        $delResult = DB::table('phenotypemouselink')
                                                ->where('_phenotype_key', '=', $value)
                                                ->delete();
                        Log::channel('coding')->info("phenotype key [ ".$value." ] in phenotypemouselink table is deleted");
                    }

                    $maxPhenotypeMouseLinkKey = $this->getMaxPhenotypeMouseLinkKey();
                    //whatever values present here should be added to the db
                    $phenotypeKeysToBeAdded = array_diff($phenotypes_Selected, $phenotypeKeysToBeKept);
                    foreach( $phenotypeKeysToBeAdded as $key => $value)
                    {
                            //echo "_phenotype key to be added = ".$value;echo "</br>";
                            $newPhenotypeMouseLink = new Phenotypemouselink();

                            $pheMousLinkSql = array(
                                        '_phenotypeMouseLink_key' => $maxPhenotypeMouseLinkKey,
                                        '_phenotype_key' => $value,
                                        '_mouse_key' => $mouse_key,
                                        'version' => $version
                                        );

                            $newPhenotypeMouseLink->_phenotype_key = $value;
                            $newPhenotypeMouseLink->_mouse_key = $mouse_key;
                            $newPhenotypeMouseLink->version = $version;

                            $result2 = $newPhenotypeMouseLink->save();

                            Log::channel('coding')->info("New PhenotypeMouseLink key [ ".$maxPhenotypeMouseLinkKey." ] inserted");
                        //$maxPhenotypeMouseLinkKey = $maxPhenotypeMouseLinkKey +1;
                    }

                    // block 1 non zero code end
                    // block 2 non zero code begin
                    $plugDate_key = null;
                    $version = 1;

                    $usage_key = $this->getMaxMouseusageKey();
                    $projectedDate = "";
                    $useSchKeysForEditing = array();

                    // before proceeding further, get the matching use schedulekeys
                    // using the use schedule term keys.
                    // this is for edit only
                    $useSchTermKeysInDB = $this->getAllUseSchTermsKeysMatchingMouseKey($mouse_key);

                    $useSchTermKeysToBeKept = array_intersect($use_schedulSelected, $useSchTermKeysInDB);
                    foreach( $useSchTermKeysToBeKept as $key => $value)
                    {
                        //array_push($useSchKeysForEditing, $value);
                        //the corresponding use sch keys will also be kept
                        //this for loop is just make sure everything is going on ok
                        // this loop does not do anything except for verfication of data
                        // so it is important.
                        //echo "use sch term key to be kept = ".$value;echo "</br>";
                    }

                    //whatever values present here can be deleted in the db
                    $useSchTermKeysToBeDel = array_diff($useSchTermKeysInDB, $use_schedulSelected);
                    $useScheduleKey = array();
                    Log::channel('coding')->info("Attempting to Delete rows in mouseusage and useschedule tables");
                    foreach( $useSchTermKeysToBeDel as $key => $value)
                    {
                        //echo "use sch term key to be deleted = ".$value;echo "</br>";
                        $useScheduleKey = $this->getUseSchKeyBySchTermKeyAndMouseKey($value, $mouse_key);
                        $useScheduleKeys[] = $useScheduleKey;
                        $delResult = DB::table('mouseusage')
                                                    ->where('_useSchedule_key', '=', $useScheduleKey)
                                                    ->where('_mouse_key', '=', $mouse_key)
                                                    ->delete();
                        Log::channel('coding')->info("Row with UseScheduleKey value [ ".$useScheduleKey." ]deleted from mouseusage table");

                        $delResult = DB::table('useschedule')
                                                    ->where('_useScheduleTerm_key', '=', $value)
                                                    ->where('_mouse_key', '=', $mouse_key)
                                                    ->delete();
                        Log::channel('coding')->info("UseScheduleTerm key with value [ ".$value." ] in Useschedule table deleted");

                        //print_r($useScheduleKeysInDB); echo "</br>";
                        $useSchKeysForEditing =   array_diff($useScheduleKeysInDB,$useScheduleKeys);
                    }
                    //get fresh use sch key because there were some not deleted and
                    // some were deleted. so get fresh keys number from db and insert it.
                    $maxUseScheduleKey = $this->getMaxUseScheduleKey();
                    //whatever values present here should be added to the db
                    $useSchTermKeysToBeAdded = array_diff($use_schedulSelected, $useSchTermKeysToBeKept);

                    if( count($useSchTermKeysToBeAdded) !=0 )
                    {
                        foreach( $useSchTermKeysToBeAdded as $key => $value)
                        {
                            //echo "Adding new entries useschedule table"; echo "</br>";
                            //echo "use sch term key added = ".$value;echo "</br>";
                            array_push($useSchKeysForEditing, $maxUseScheduleKey);
                            $addUseSchSql = array(
                                        '_useSchedule_key' => $maxUseScheduleKey,
                                        '_mouse_key' => $mouse_key,
                                        '_useScheduleTerm_key' => $value,
                                        '_plugDate_key' => $plugDate_key,
                                        'startDate' => $dob,
                                        'comment' => $comment,
                                        //'done' => 0,
                                        'version' => $version
                                        );

                            $result3 = DB::table('useschedule')->insert($addUseSchSql);
                            //$result3=true;
                            Log::channel('coding')->info("New Useschedule key [ ".$maxUseScheduleKey." ] inserted");

                            $daysPostEvent = $this->findAllDaysPostEvent($value);
                            $mouseUse = $this->findMouseUseMatchingUseScheduleTermKey($value);

                            foreach($daysPostEvent as $row)
                            {
                                $daysPostEvent = $row->daysPostEvent;
                                $projectedDate = date('Y-m-d', strtotime($dob. ' + '.$daysPostEvent.' days'));
                                //$msg = $msg. "Date of Birth = ".$dob; echo "</br>";
                                //$msg = $msg. "Projected Date = ".$projectedDate; echo "</br>";

                                $addSql3 = array(
                                            '_usage_key' => $usage_key,
                                            '_mouse_key' => $mouse_key,
                                            '_plugDate_key' =>  $plugDate_key,
                                            '_useSchedule_key' => $maxUseScheduleKey,
                                            'use' => $mouseUse,
                                            'useAge' => $daysPostEvent,
                                            'projectedDate' => $projectedDate,
                                            'actualDate' => null,
                                            'done' =>  0,
                                            'comment' => $comment,
                                            'D1' => null,
                                            'D2' => null,
                                            'D3' => null,
                                            'D4' => null,
                                            'D5' => null,
                                            'D6' => null,
                                            'D7' => null,
                                            'D8' => null,
                                            'D9' => null,
                                            'D10' => null,
                                            'version' => 1
                                         );

                                $result4 = DB::table('mouseusage')->insert($addSql3);
                                Log::channel('coding')->info("New Mouseusage key [ ".$usage_key." ] inserted");
	                            $result4 = true;
                                $projectedDate = "";
                                $usage_key = $usage_key +1;
                            }
                            $maxUseScheduleKey = $maxUseScheduleKey +1;
                        }
                    }
                    else {
                        Log::channel('coding')->info("There are [ ".count($useSchKeysForEditing)." ] changes made in the Useschedule & Mouseusage Table");
                    }
                    // end of block 2 code
                    //$updatedUseSchKeysInDB = $this->getAllUseScheduleKeysMatchingMouseKey($mouse_key);

				break;

				default:

		  }
    }
    catch (\Illuminate\Database\QueryException $e ) {
                $result2Fail = DB::rollback();
                $eMsg = $e->getMessage();
                Log::channel('coding')->info($eMsg);
                $qResultMsg = $qResultMsg."</br>".$eMsg."</br>";
                $result1 = false;
    }
    // With, we must have completed all entries and return the message to the user.
    //$msg = $qResultMsg;
    return true;
}








    public function searchBreedingEntries($input_array)
    {
        // 1. setting the db
        //$mcmsTables = $this->setMcmsDB();
        //$db_connection = "manage_colony";

        $species_name = $input_array[0];
        $mouseIdParam = $input_array[1];
        $mouse_id     = $input_array[2];
        $strain_key   = $input_array[3];
        $lifeStatus   = $input_array[4];
        $cageIdParam  = $input_array[5];
        $cage_id      = $input_array[6];
        $sex_key      = $input_array[7];
        $fromDate     = $input_array[8];
        $toDate       = $input_array[9];
        $owner_key    = $input_array[10];

        $species_key         = $this->getSpeciesKeyBySpeciesName($species_name);

        $baseSqlStatement = "select * from mouse WHERE _species_key = ".$species_key;

        if($mouse_id !="")
        {
            if( $mouseIdParam == "contains")
            {
                $baseSqlStatement = $baseSqlStatement." AND ID LIKE '%".$mouse_id."%'  ";
            }
            if( $mouseIdParam == "equals")
            {
                $baseSqlStatement = $baseSqlStatement." AND ID = '".$mouse_id."'";
            }
            if( $strain_key != "")
            {
                $baseSqlStatement = $baseSqlStatement." AND _strain_key = ".$strain_key;
            }
            if ($cageIdParam != "")
            {
                if( $cageIdParam == "equals")
                {
                    $baseSqlStatement = $baseSqlStatement." AND _pen_key = ".$cage_id;
                }
                if( $cageIdParam == "greaterthan")
                {
                    $baseSqlStatement = $baseSqlStatement." AND _pen_key > ".$cage_id;
                }
                if( $cageIdParam == "lessthan")
                {
                    $baseSqlStatement = $baseSqlStatement." AND _pen_key < ".$cage_id;
                }
            }
            if( $lifeStatus != "")
            {
                $baseSqlStatement = $baseSqlStatement." AND lifeStatus = '".$lifeStatus."'";
            }
            if( $sex_key != "")
            {
                $baseSqlStatement = $baseSqlStatement." AND sex = '".$sex_key."'";
            }
            if ($fromDate != "")
            {
                $baseSqlStatement = $baseSqlStatement." AND DATE(birthDate) > '".$fromDate."'";
            }
            if ($toDate != "")
            {
                $baseSqlStatement = $baseSqlStatement." AND DATE(birthDate) < '".$toDate."'";
            }
            if ($owner_key != "")
            {
                $baseSqlStatement = $baseSqlStatement." AND owner = '".$owner_key."'";
            }
        }
        //echo "Query to be executed = ".$baseSqlStatement;echo "</br>";
        $result = DB::select($baseSqlStatement);
        //echo "number of rows got = ".count($result);echo "</br>";
        return $result;
    }

    public function fetchMouseIdInfo($mouseId)
    {
        //$mcmsTables = $this->setMcmsDB();

        $result = DB::table('mouse')
                            ->where('ID', '=', $mouseId)
                            ->select('*')
                            ->get();
        if( count($result) == 1 )
        {

            $MouseInfo = DB::table('mouse')
                                    ->leftJoin('strain', 'strain._strain_key', '=', 'mouse._strain_key')
                                    ->where('ID', $mouseId)
                                    ->select()
                                    ->get();

            //print_r($MouseInfo);
            //echo "Total mouse rows found = ".count($MouseInfo); echo "</br>";
            return $MouseInfo;
        }
        else {
            echo "No Information found for the ID:".$mouseId;echo "</br>";
        }
    }
}
