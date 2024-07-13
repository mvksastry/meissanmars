@include('layouts.partials.flash-message')
@if (Session::has('message'))
    <div class="note note-info">
        <p>
          Error
        </p>
        <p>
          <font color="red"><strong>
            {{ Session::get('message') }}
          </strong></font>
        </p>
    </div>
@endif
@if ($errors->count() > 0)
    <div class="note note-danger">
        <p>
          <font color="red"><strong>Error</strong></font>
        </p>
        <ul class="list-unstyled">
            @foreach($errors->all() as $error)
                <li>
                  <font color="red"><strong>{{ $error }}</strong></font>
                </li>
            @endforeach
        </ul>
    </div>
@endif