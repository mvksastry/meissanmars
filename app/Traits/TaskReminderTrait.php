<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Immunization;
use App\Models\Event;
use App\Models\User;
use App\Models\Task;

use DateTime;

use App\Traits\Base;

trait TaskReminderTrait
{
  public function groupsTasks()
  {
    return Task::with('user')->where('category', 'group')->get();
  }

  public function personalTasks()
  {
    return Task::with('user')
                  ->where('self_id', Auth::id())
                  ->where('status', 'Active')->where('category', 'personal')
                  ->get();
  }  
  public function dueDates()
  {
    $today = date('Y-m-d');
    $tomorrow = date('Y-m-d', strtotime("+1 day", strtotime($today)));
    $within2days = date('Y-m-d', strtotime('+2 days', strtotime($today)));

    $eventsusers['events'] = Event::where('start_date','=', $within2days)->get();

    $eventsusers['users'] = User::where('role', 'herdmanager')->get();

    return $eventsusers;
  }
}