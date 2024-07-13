<?php

namespace App\Livewire\Duties;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Support\Facades\Route;

use App\Models\Project;
use App\Models\Assent;
use App\Models\Task;

use App\Traits\Base;

use Validator;

class Tasks extends Component
{
    
	use Base;

	public $taskText, $category, $lwMessage;

    public function render()
    {
		if( Auth::user()->hasAnyRole('investigator','researcher','facility_help','veterinarian') )
		{
				$personalTasks = Task::with('user')->where('self_id', Auth::id())
																->where('status', 'Active')->where('category', 'personal')
												->get();

				$groupTasks = Task::with('user')->where('category', 'group')
												->get();

				//implement here cost, issues and consumption details one by one
				return view('livewire.duties.tasks')
								->with(['personalTasks'=>$personalTasks, 'groupTasks'=> $groupTasks]);
		}
		else {
			return view('livewire.permError');
		}

    }

	public function markAsDone($id)
	{
		$task = Task::where('task_id', $id)
									->where('self_id', Auth::id())
									->first();
		$task->status = 'Done';
		$task->save();
		$this->lwMessage = "Status updated";
	}

	public function saveTask()
	{
		$newTask = new Task();

		$newTask->self_id = Auth::id();
		$newTask->category = $this->category;
		$newTask->text = $this->taskText;
		$newTask->date = date('Y-m-d');
		$newTask->status = 'Active';
		$newTask->save();
		$this->resetTaskForm();
	}

	public function resetTaskForm()
	{
		$this->category = "";
		$this->taskText = "";
	}
/////////////////////////////////////
    
    
    
    
}
