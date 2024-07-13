  <div class="card-body">
    @hasexactroles('pient')
    <div class="form-group">
      <label for="exampleInputEmail1">Principal Investigator*</label>
      <input type="text" class="form-control" name="pi" id="pi" value="{{ Auth::user()->id }}" placeholder="Project Title">
    </div>
    @endhasexactroles
    
    @hasexactroles('manager')
    <div class="form-group col">
      <label for="exampleInputBorderWidth2">Principal Investigator*</label>
      <select class="custom-select form-control rounded-1" 
        name="pi" id="pi">
        @foreach($users as $user)
          <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
      </select>
      @if($errors->has('pi'))
        <p class="help-block text-danger">
          {{ $errors->first('pi') }}
        </p>
      @endif
    </div>
    @endhasexactroles
    
    <div class="form-group">
      <label for="exampleInputEmail1">Project Title</label>
      <input type="text" class="form-control" name="title" id="title" placeholder="Project Title">
        @if($errors->has('title'))
          <p class="text-danger">
          {{ $errors->first('title') }}
          </p>
        @endif  
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Start Date</label>
      <input type="date" class="form-control" name="start_date" id="start_date" placeholder="Start Date">
        @if($errors->has('start_date'))
          <p class="text-danger">
          {{ $errors->first('start_date') }}
          </p>
        @endif   
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">End Date</label>
      <input type="date" class="form-control" name="end_date" id="end_date" placeholder="End Date">
    </div>
      @if($errors->has('end_date'))
        <p class="text-danger">
        {{ $errors->first('end_date') }}
        </p>
      @endif    
    <div class="form-group">
      <label for="exampleInputFile">Project File (Signed)</label>
      <div class="input-group">
        <div class="custom-file">
          <input type="file" class="custom-file-input" name="projfile" id="projfile">
          <label class="custom-file-label" for="projfile"></label>
          @if($errors->has('projfile'))
            <p class="text-danger">
            {{ $errors->first('projfile') }}
            </p>
          @endif
        </div>
      </div>
    </div>
  </div>

  <label class="py-2 block text-gray-900 text-sm font-normal mt-3 mb-2" for="end date">
    Strain Details: For all years  will be calculated based on species/strain/year wise.
  </label>



  <table class="w-full p-5 text-gray-700">
    <tbody>
      <tr>
      </tr>
      <?php $prevName = '';
        $stnInfo = $freestrains->merge($own_strains);
      ?>
      @if(!empty($stnInfo))
        <tr bgcolor="#E1BEE7" class="">              
          <td class="text-sm font-normal text-center"> Check Strain </td>
          <td class="text-sm font-normal text-center"> Year 1 </td>
          <td class="text-sm font-normal text-center"> Year 2 </td>
          <td class="text-sm font-normal text-center"> Year 3 </td>
          <td class="text-sm font-normal text-center"> Year 4 </td>
          <td class="text-sm font-normal text-center"> Year 5 </td>
        </tr>
        @foreach ($stnInfo as $val)
          {{ $val->species_name }}
          @if ($val->species->species_name != $prevName)
            <tr bgcolor="#BBDEFB"class="pt-1 pb-1">
              <td colspan="6 ">
                <div class="form-check">
                  <input type="checkbox" name="species[]" value="{{ $val->species->species_name.'_'.$val->species->species_id }}" class="form-check-input" id="exampleCheck1">
                  <label class="form-check-label" for="exampleCheck1">                     
                    Check box if {{ $val->species->species_name }} Required
                  </label>
                </div>
              </td>
            </tr>
          @endif
          <tr bgcolor="#FFFFED">
            <td class="block text-gray-900 text-xs mt-1 mb-1 font-normal">
              <div class="form-check">
                <input type="checkbox" name="exp_strain[]" value="{{ $val->species->species_name.'_'.$val->uuid }}" class="form-check-input" id="exampleCheck1">
                {{ $val->strain_name }}
              </div>
            </td>
            <td>
              <div class="form-check w-20">
                <input type="number" name="{{ $val->uuid }}[]"class="form-control" id="exampleInputEmail1" placeholder="Year 1">
              </div>
            </td>
            <td>
              <div class="form-check">
                <input type="number" name="{{ $val->uuid }}[]"class="form-control" id="exampleInputEmail1" placeholder="Year 2">
              </div>
            </td>
            <td>
              <div class="form-check">
                <input type="number" name="{{ $val->uuid }}[]"class="form-control" id="exampleInputEmail1" placeholder="Year 3">
              </div>
            </td>
            <td>
              <div class="form-check">
                <input type="number" name="{{ $val->uuid }}[]"class="form-control" id="exampleInputEmail1" placeholder="Year 4">
              </div>
            </td>
            <td>
              <div class="form-check">
                <input type="number" name="{{ $val->uuid }}[]"class="form-control" id="exampleInputEmail1" placeholder="Year 5">
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="6">
              @if($errors->has('species'))
                <p class="text-danger">
                {{ $errors->first('species') }}
                </p>
              @endif
              @if($errors->has('exp_strain'))
                <p class="text-danger">
                  {{ $errors->first('exp_strain') }}
                </p>
              @endif
            </td>
          </tr>
          <?php $prevName = $val->species->species_name; ?>
        @endforeach
          <tr>
            <td colspan="6"></td>
          </tr>
      @endif
    </tbody>
  </table>


  <table id="userIndex2" class="table table-bordered table-hover">
    <thead>
      <tr bgcolor="#BBDEFB">												
        <th>Notes</th>
        <th></th>
      </tr>
      
    </thead>
    <tbody>
      <tr bgcolor="#E1BEE7"   data-entry-id="">
        <td>Comments</td>
        <td>
          <div class="form-group">
            <input type="text" id="spcomments" name="spcomments" class="form-control" placeholder="IAEC Comments">
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  
  <table id="userIndex2" class="table table-bordered table-hover">
    <tbody>                      
      <tr>
        <td>
          <button type="submit" class="btn btn-lg btn-info">
            Submit
          </button>
        </td>
       </tr>			
    </tbody>
  </table>
  