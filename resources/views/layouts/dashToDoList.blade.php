  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">
        <i class="ion ion-clipboard mr-1"></i>
        To Do List
      </h3>
      
      <!--
      <div class="card-tools">
        <ul class="pagination pagination-sm">
        <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
        <li class="page-item"><a href="#" class="page-link">1</a></li>
        <li class="page-item"><a href="#" class="page-link">2</a></li>
        <li class="page-item"><a href="#" class="page-link">3</a></li>
        <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
        </ul>
      </div>
      -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      @if(isset($kbCards) )
      <ul class="todo-list" data-widget="todo-list">
        @foreach($kbCards as $card)
          <li>
            <!-- drag handle -->
            <span class="handle">
              <i class="fas fa-ellipsis-v"></i>
              <i class="fas fa-ellipsis-v"></i>
            </span>
            <!-- checkbox -->
            <div  class="icheck-primary d-inline ml-2">    
            </div>
            <!-- todo text -->
            <span class="text">{{ $card->item_desc }}</span>
            <!-- Emphasis label -->                  
            <!-- General tools such as edit or delete-->
            <div class="tools">
              <a href="{{ route('kanban-cards.edit',$card->kbocard_id) }}"><i class="fas fa-edit"></i></a>
            </div>
          </li>
        @endforeach  
      </ul>
      @else
        <ul class="todo-list" data-widget="todo-list">
          Nothing to Display
        </ul>
      @endif
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
      <a href="{{ route('kanban-cards.create') }}">
        <button type="button" class="btn btn-primary float-right">
          <i class="fas fa-plus"></i> 
            Add item
        </button>
      </a>
    </div>
  </div>