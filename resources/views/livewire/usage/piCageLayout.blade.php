
<?php
    $ttrow =  $rackInfo;
    //$building_id    = $rackInfo->building_id;
    //$floor_id       = $ttrow->building_name;
    //$floor_id       = $rackInfo->floor_id;
    $rack_name      = $rackInfo['rackName'];
    $rack_id        = $rackInfo['rack_id'];
    $row            = $rackInfo['rows'];
    $col            = $rackInfo['cols'];
    $levels         = $rackInfo['levels'];
    $dtrow = $row;
    $booked_seats=array();
    $booked_seats = $ro_own;
    $height = intval($row)*intval($levels)*42+28;
    $width = intval($col)*36+15;
    $n = 1; $j = 0; $slotNo = 0; $seatNo = 0;
    $row_limit = $row; $col_limit = $col; $shelf = 1;
?>

<div class="w-1/2 md:w-1/2">
    <div class="bg-orange-100 border border-gray-800 rounded shadow">
        <div class="border-b border-gray-800 p-3">
            <h5 class="font-bold uppercase text-gray-900">Layout Information</h5>
        </div>
        <div class="w-full p-1">
            <table id="userIndex2" class="table table-bordered table-sm table-hover">
            
      				<thead>
      					<tr>
      						<th> Item </th>
      						<th> Details </th>
      					</tr>
      				</thead>
                <tbody>
                    <tr>
                        <td> Cage Id </td>
                        <td> {{ $cage_id }} </td>
                    </tr>
                    <tr>
                        <td> Building </td>
                        <td> XYZ Building </td>
                    </tr>
                    <tr>
                        <td> Room </td>
                        <td> ABC Room </td>
                    </tr>
                    <tr>
                        <td> Rack Name </td>
                        <td>{{ $rack_name }} </td>
                    </tr>
                    <tr>
                        <td> Marked Cages </td>
                        <td>{{ $markedCages }}</td>
                    </tr>
                </tbody>
            </table>

<?php

for($k = 0; $k < $levels; $k++)
{
    $shelf = $k +1;
    echo '<table class="p-1 mt-2 text-xs font-normal" align="center">';
    echo "</br>";
    for($i = 0; $i < $row_limit; $i++)
    {
?>
        <table class="flex mb-2">
            <thead>
            </thead>
            <tbody>
            <tr>
                <td class="text-gray-900 text-sm font-normal mx-2 p-1">
                    S#<?php echo $shelf?>
                </td>
<?php
                for($j = 0; $j < $col_limit; $j++)
                {
                    $seatNo = $j + $slotNo;
?>
                  <td class="text-yellow-200 text-sm font-normal mx-4 ">
<?php
                  $row = $rackInfo[$seatNo];
                  if( $row['status'] == 'O' )
                  {

?>

                    <span wire:click="markCages('{{ $row['cage_id'] }}')" >

                        <button class="btn btn-success rounded p-1" data-toggle="popover" title="Cage ID: <?php echo $row['cage_id']; ?>" data-trigger="hover" data-content="Cage ID: <?php echo $row['cage_id']; ?>" >

                            <i class="fa fa-square" aria-hidden="true"></i>
                         <?php echo sprintf("%02d", $row['slot_id'] ); ?>
                        </button>
                    </span>
<?php               } else {  ?>
                    <span>
                        <button class="btn btn-danger rounded p-1" data-toggle="popover" title="Occupied/Other's Cage" data-trigger="hover" data-content="Other's Cage" >
                            <i class="fa fa-square" aria-hidden="false"></i>
                        <?php echo sprintf("%02d", $row['slot_id'] ); ?>
                        </button>
                    </span>
<?php           }
                //echo $seatNo;
                echo "</td>";
            }
            echo "</tr>";
            $slotNo = $slotNo +  $col_limit;
    }
    }
    echo "</table>";
?>

                    <tr>
                    </tr>
                    <tr >
                        <td align="center">
                        </br>
                        <button wire:click="terminateCages()" class="btn btn-warning rounded mx-3">
                        Terminate Marked Cages
                        </button>

                        <button wire:click="clearMarkedCages()" class="btn btn-secondary rounded">
                        Clear Selection
                        </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- / End of Left Panel Graph Card-->
