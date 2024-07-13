<?php 
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Webpatser\Uuid\Uuid;

use App\Models\Event;
use App\Models\Group;
use App\Models\Hop;
use App\Models\Tour;
use App\Models\User;

use App\Traits\Baseinfo;
use App\Traits\Comments;
use App\Traits\Fileupload;
use App\Traits\Groupidentity;
use App\Traits\Nexthop;
use App\Traits\Checks;
use App\Traits\Queries;
use App\Traits\Trail;

use File;

trait Eventhandler 
{
	//use Baseinfo;
  use Trail, Comments, Fileupload, Groupidentity, Nexthop, Queries, Checks;

  
  protected $user;

  public function calendarEvents()
  {
    $stDate = date('Y-m-d', strtotime("-4 days"));;
    $enDate = date('Y-m-d', strtotime("+36 days"));;
  
    $dres = Event::with('eventype')->whereDate('event_start', '>=', $stDate)
                  ->whereDate('event_end',  '<=', $enDate)
                  ->get(['event_id','event_type','event_start', 'event_end']);
                  
    $ide = array();
    
    foreach($dres as $key => $val)
    {
      $data['title'] = $val->eventype->eventname;
      $data['start'] = $val->event_start;
      $data['end'] = $val->event_end;
      $data['backgroundColor'] = '#f56954'; //red
      $data['borderColor'] = '#f56954'; //red
      $data['allDay'] = false;
      array_push($ide, $data);
      unset($data);
    }
   
    $events = json_encode($ide);   

    return $events;
    
  }
  
	public function setCalanderEvent($input)
	{
		// everything ok generate the uuid, 
		$res = $this->verifyMatchingEvents($input);
    
		if($res)
		{    
      $event = new Event();
      $event->employee_id = Auth::id();	
      $event->event_type = $input['event_type'];
      
      if(array_key_exists("form", $input))
      {
        $event->event_start = $this->mergeDateAndTime($input['start_date'], $input['start_time']);
        $event->event_end = $this->mergeDateAndTime($input['end_date'], $input['end_time']);
      }
      else {
        $event->event_start = date('Y-m-d H:i:s', strtotime($input['eventdatetime1']));
        $event->event_end = date('Y-m-d H:i:s', strtotime($input['eventdatetime2']));
      }
      
      $event->event_venue = $input['event_venue'];
      $event->condition = $input['conditions'];
      $event->council = null;
      $event->comment = $this->addTimeStamp($input['comment']);			
      $event->status = 1;				
      $event->uuid = Uuid::generate()->string;	
      $result = $event->save();
      return true;
		}
		else {
			return false;
		}
    
	}	

  public function verifyMatchingEvents($input)
  {
    //check here for already if an event present at same time at same venue
		$res = Event::where('event_venue', $input['event_venue'] )
					->where('event_start', '<', $this->mergeDateAndTime($input['end_date'], $input['end_time']))
					->where('event_end', '>', $this->mergeDateAndTime($input['start_date'], $input['start_time']))
					->get();
          
    if(count($res) > 0 )
		{
			return false;
		}
		else {
			return true;
		}
    
  }
  
////////////////////////////////////////////////////////
}
