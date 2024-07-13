<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Infrastructure;

use App\Http\Requests\Infra\InfraFormRequest;

use App;
use File;

use App\Traits\Infrasave;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class InfrastructureController extends Controller
{
  use Infrasave;
  
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infras = Infrastructure::all();
        return view('facility.infrastructure.index')->with('infras', $infras);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('facility.infrastructure.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InfraFormRequest $request)
    {
      $input = $request->all();
 
      $result = $this->save_infra_item($input);
      
      return redirect()->route('infrastructure.index')
            ->with('flash_message',
             'Infrastructure entry successfully added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $infra = Infrastructure::with('user')->where('infra_id', $id)->first();
        return view('infrastructure.nedit')->with('infra', $infra);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $infra = Infrastructure::find($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
