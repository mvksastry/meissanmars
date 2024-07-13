<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Models
use Auth;
use App\Models\Projectgoals;
use App\Models\Projtask;
use App\Models\User;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $tasks = Projtask::with('project')
                        ->with('taskowner')
                        ->with('goal')
                        ->with('updatedby')
                        ->get();
     
      return view('projects.indexProjectTasks',compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
      return view('projects.createProjectTasks',compact('goalId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
      $input = $request->all();
      
      $pTask = new Projtask();
      
      
      $pTask->project_id  =  $input['project_id'];
      $pTask->projectgoal_id  = $input['goal_id'];
      $pTask->taskowner_id  =  $input['taskowner_id'];
      $pTask->uuid  =  $input['uuid'];
      $pTask->activity  =  $input['activity'];
      $pTask->task_desc  =  $input['task_desc'];
      $pTask->task_starts  =  $input['task_starts'];
      $pTask->task_ends  =  $input['task_ends'];
      $pTask->budget  =  $input['budget'];
      $pTask->date_posted  =  date('Y-m-d');
      $pTask->updated_by  =  Auth::user()->id;
      $pTask->percent_progress  =  $input['percent_progress'];
      $pTask->comment  =  $input['comment'];
      //dd($input, $pTask);
      $pTask->save();
      
      $message =  "Task Assigned and Saved";
      return redirect()->route('projects.show',  $input['uuid']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $goalId = Projectgoals::with('project')->where('projectgoal_id', $id)->first();
      $users = User::whereHas(
                              'roles', function($q){
                                  $q->where('name', 'employee');
                              }
                      )->get();
      //dd($users);
      
      return view('projects.createProjectTasks',compact('goalId', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      $taskId = Projtask::with('project')
                        ->with('taskowner')
                        ->with('goal')
                        ->with('updatedby')
                        ->where('projtask_id', $id)->first();
      
      $users = User::whereHas('roles', function($q){
                                  $q->where('name', 'employee');
                              })->get();
      return view('projects.updateProjectTasks',compact('taskId', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
      $input = $request->all();
      
      dd($id, $input);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
