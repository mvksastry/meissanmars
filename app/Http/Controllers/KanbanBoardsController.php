<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

//models
use App\Models\Kanbanboards;
use App\Models\Kanbancards;

//Uuid import class
use Webpatser\Uuid\Uuid;

class KanbanBoardsController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $kanban_boards = Kanbanboards::all();
        return view('layouts.kanban.indexBoards', compact('kanban_boards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('layouts.kanban.createBoard');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();   
        
        $kboard = new Kanbanboards();
        $kboard->uuid = Uuid::generate()->string;
        $kboard->name = $input['board_name'];
        $kboard->description = $input['description'];
        $kboard->color = $input['color'];
        $kboard->status_date = date('Y-m-d');
        $kboard->posted_by = Auth::user()->name;
        //dd($kboard);
        $kboard->save();
        
        return redirect()->route('kanban-boards.index')
          ->with('flash_message',
              'New Board Registered successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
      $kboard = Kanbanboards::where('uuid', $id)->first();
      //dd($kboard);
      return view('layouts.kanban.edit', compact('kboard'));
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $input = $request->all();
        
        $kboard = Kanbanboards::where('uuid', $id)->first();
        
        $kboard->name = $input['name'];
        $kboard->description = $input['description'];
        $kboard->color = $input['color'];
        $kboard->edited_by = Auth::user()->name;
        //dd($kboard);
        $kboard->save();
        return redirect()->route('kanban-boards.index')
          ->with('flash_message',
              'New Board Registered successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
