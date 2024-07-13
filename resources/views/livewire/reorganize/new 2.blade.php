
  
    @for($k = 0; $k < $levels; $k++)
      <?php $shelf = $k +1; ?>
      <table class="cagex table table-bordered table-hover text-nowrap">
        </br>
        @for($i = 0; $i < $row_limit; $i++)
          <tr>
            <td >Shelf # {{ $shelf }} </td>
            @for($j = 0; $j < $col_limit; $j++)
              <?php $seatNo = $j + $slotNo; ?>
              <?php $classno = ($seatNo + 1); ?>
              <?php $row = $rack_info[$seatNo]; ?>
              <?php //$pkey = $classno."_".$shelf; ?>
              <td class="{{ $classno }}">
                @if( $row["status"] == "O")
                  <div align="center">
                    <button class="btn btn-block btn-success event" class="event" draggable="true" id="<?php echo $row['cage_id']; ?>" >
                      <?php echo sprintf("%04d", $row['cage_id'] ); ?>
                    </button>
                  </div>
                @else 
                  <div align="center">
 
                  </div>
                @endif
              </td>
              
            @endfor
          </tr>
          <?php $slotNo = $slotNo +  $col_limit; ?>
        @endfor
      </table>
    @endfor
      