<!-- Right Panel Graph Card-->
	
		<div class="bg-orange-100 border border-gray-800 rounded shadow">
			<div class="p-2">


        <div>
          <button class="btn btn-block btn-default" for="title">
            Click on Red button to get Cage details of <?php echo $rackName; ?>
          </button>
        </div>
        <?php
          //$ttrow = $rack_dims;
          $row = $rows;
          $col = $cols;
          $levels = $levels;
        ?>


<?php

    $n = 1;
    $j = 0;
    $slotNo = 0;
    $seatNo = 0;
    $row_limit = $row;
    $col_limit = $col;
    $shelf = 1;

    for($k = 0; $k < $levels; $k++)
    {
      $shelf = $k + 1;
      echo '<table class="p-1 mt-1 text-xs font-normal" align="center">';
      echo "</br>";

      for($i = 0; $i < $row_limit; $i++)
      {
			?>
           
					<tr>
						<td class="text-gray-900 text-xs font-normal mx-1 p-1">
              Level#<?php echo $shelf?>
            </td>
        			<?php
                for($j = 0; $j < $col_limit; $j++)
                {
                  $seatNo = $j + $slotNo;
        			?>
                  <td class="text-yellow-200 text-xs font-normal mx-2 ">
                    <?php
                        $row = $rack_info[$seatNo];
                        
                        if( $row['status'] == 'O' )
                        {
                    ?>
                            <span wire:click="cageinfo({{ $row['cage_id'] }})" id="<?php echo $row['cage_id']; ?>" >
                              <button class="btn btn-block btn-danger btn-sm" 
                                id="test-button" data-toggle="popover" 
                                title="Cage ID: <?php echo $row['cage_id']; ?>" 
                                data-trigger="hover" 
                                data-content="Cage ID: <?php echo $row['cage_id']; ?>" >
                							<i class="fa fa-square" aria-hidden="true"></i>
                                 <?php echo sprintf("%02d", $row['slot_id'] ); ?>
                              </button>
                            </span>
                    <?php  
                    } 
                    else {  ?>
            				<span id="<?php echo $row['cage_id']; ?>" >
                      <button class="btn btn-block btn-success btn-sm" 
                        id="test-button" data-toggle="popover" 
                        title="Availabile" data-trigger="hover" 
                        data-content="This slot is available" >
                        <i class="fa fa-square" aria-hidden="true"></i>
                        <?php echo sprintf("%02d", $row['slot_id'] ); ?>
                      </button>
                    </span>
                <?php }

                    //echo $seatNo;
                    echo "</td>";
                }
               echo "</tr>";
               $slotNo = $slotNo +  $col_limit;
            }
        }
        echo "</table>";
    ?>
    				<div class="mt-5">
    					<button class="btn btn-block btn-danger btn-sm" for="title">
    						Occupied
    					</button>
    					<button class="btn btn-block btn-success btn-sm" for="title">
    						Available
    					</button>
    				</div>
				</div>
			</div>
	

