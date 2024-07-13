<script src="/js/interact.min.js"></script>
<style>
    .cagex th, .cagex td{
            height: 30px;
            width: 65px;
    
    }
    .cagex span{
            display:block;
            background-color: #ADD8E6;
            height: 80%;
            width: 80%;
            border-radius: 10px;
            text-align: center;
            padding: 4px;
    }
    
    #outer-dropzone {
      height: 140px;
    }
    
    #inner-dropzone {
      height: 80px;
    }
    
    .dropzone {
      background-color: #ccc;
      border: dashed 4px transparent;
      border-radius: 4px;
      margin: 10px auto 30px;
      padding: 10px;
      width: 80%;
      transition: background-color 0.3s;
    }
    
    .drop-active {
      border-color: #aaa;
    }
    
    .drop-target {
      background-color: #29e;
      border-color: #fff;
      border-style: solid;
    }
    
    .drag-drop {
      display: inline-block;
      min-width: 40px;
      padding: 2em 0.5em;
    
      color: #fff;
      background-color: #29e;
      border: solid 2px #fff;
    
      -webkit-transform: translate(0px, 0px);
              transform: translate(0px, 0px);
    
      transition: background-color 0.3s;
    }
    
    .drag-drop.can-drop {
      color: #000;
      background-color: #4e4;
    }
</style>

<script>

	$(document).ready(function(){

    $('.event').on("dragstart", function (event) {
      var dt = event.originalEvent.dataTransfer;
      dt.setData('Text', $(this).attr('id'));
    });

    $('table td').on("dragenter dragover drop", function (event) {
      event.preventDefault();

      if (event.type === 'drop')
      {
        var data = event.originalEvent.dataTransfer.getData('Text',$(this).attr('id'));
        var data_pos = event.originalEvent.dataTransfer.getData('Text',$(this).className);

        if($(this).find('span').length===0)
        {
          de=$('#'+data).detach();
          de.appendTo($(this));
          //tellNumbers();
        }
			};

    });

    $("#postreorg").click(function(e) {
      // function tellNumbers(){
      var tds = document.getElementsByTagName("td");
      var rackid = document.getElementById("rackid").value;
      //alert (tds.length);
      var dataString = 'rackid='+rackid;

      for (var i = 0; i<tds.length; i++)
      {
        // alert('class number = ' + i + ' == ' +tds[i].className);
        // If it currently has the ColumnHeader class...

        if(!($(tds[i]).find('span').length === 0))
        {
          var idx =    $(tds[i]).find('span').text();
          var vac = ' &cage_id='+idx+'@slot_id='+tds[i].className;
          dataString = dataString+vac;
          // alert('value = ' + idx + ' in cell number = ' + tds[i].className);
        }
      }

        //alert (dataString);
        var url = '/reshuffle/cageUpdate';
        //var functionname = 'updateCageReshuffleInfo';
        //var fulladdress = host+functionname;
        var p = {};
        p[dataString] = dataString;
		$.ajax({
            url: url,
            type:"POST",
            data:{
				dataString:dataString,
                rackid:rackid,
                _token: '{{csrf_token()}}'
            },
			success:function(response){
				console.log(response);
                //alert(response);
				if(response)
				{
					//$('.success').text(response.success);
					//$("#ajaxform")[0].reset();
					//$("#racksInfo").load(" #divid");
					$("#reorgmsg").html(response);
				}
			},
       });
       //alert ('Cage_id clicked = ' + p[dataString]);
    });
	})
// target elements with the "draggable" class
interact('.draggable')
  .draggable({
    // enable inertial throwing
    inertia: true,
    // keep the element within the area of it's parent
    restrict: {
      restriction: "parent",
      endOnly: true,
      elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
    },
    // enable autoScroll
    autoScroll: true,

    // call this function on every dragmove event
    onmove: dragMoveListener,
    // call this function on every dragend event
    onend: function (event) {
      var textEl = event.target.querySelector('p');

      textEl && (textEl.textContent =
        'moved a distance of '
        + (Math.sqrt(event.dx * event.dx +
                     event.dy * event.dy)|0) + 'px');
    }
  });

  function dragMoveListener (event) {
    var target = event.target,
        // keep the dragged position in the data-x/data-y attributes
        x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
        y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

    // translate the element
    target.style.webkitTransform =
    target.style.transform =
      'translate(' + x + 'px, ' + y + 'px)';

    // update the posiion attributes
    target.setAttribute('data-x', x);
    target.setAttribute('data-y', y);
  }


/* The dragging code for '.draggable' from the demo above
 * applies to this demo as well so it doesn't have to be repeated. */

// enable draggables to be dropped into this
interact('.dropzone').dropzone({
  // only accept elements matching this CSS selector
  accept: '#yes-drop',
  // Require a 75% element overlap for a drop to be possible
  overlap: 0.75,

  // listen for drop related events:

  ondropactivate: function (event) {
    // add active dropzone feedback
    event.target.classList.add('drop-active');
  },
  ondragenter: function (event) {
    var draggableElement = event.relatedTarget,
        dropzoneElement = event.target;

    // feedback the possibility of a drop
    dropzoneElement.classList.add('drop-target');
    draggableElement.classList.add('can-drop');
    draggableElement.textContent = 'Dragged in';
  },
  ondragleave: function (event) {
    // remove the drop feedback style
    event.target.classList.remove('drop-target');
    event.relatedTarget.classList.remove('can-drop');
    event.relatedTarget.textContent = 'Dragged out';
  },
  ondrop: function (event) {
    event.relatedTarget.textContent = 'Dropped';
  },
  ondropdeactivate: function (event) {
    // remove active dropzone feedback
    event.target.classList.remove('drop-active');
    event.target.classList.remove('drop-target');
  }
});
</script>

<?php
    //$ttrow =  $rack_dims;
    //$arrayImage = explode('_', $image_id);
        $rack_id = $racks->rack_id;
        $row = $racks->rows;
        $col = $racks->cols;
        $levels = $racks->levels;
        //$uploadpath = "assets/assets/img/".$institution_id."/";
?>

    <div class="p-5">
      <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 inline-block mx-auto w-full sm:px-6 lg:px-8">
            <div class="overflow-hidden">
              <input hidden type="text" id="rackid" name="rackid" value="{{ $racks->rack_id }}" readonly>
              <table class="w-3/4 table-auto  mx-auto whitespace-nowrap">
                <thead class="bg-white border-b">
                  <tr class="border-b bg-green-200 border-gray-200">
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-2 text-center rounded-lg">
                      Rack: {{ ucfirst($racks->rack_name) }}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="bg-gray-100 border-b">
                    <td class="text-sm text-gray-600 text-center font-light px-6 py-2 whitespace-nowrap">
                      (Drag & Drop the Cage Number to desired location & Update)
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php
    //echo $image_id; echo BR;
    $n = 1;
    $j = 0;
    $slotNo = 0;
    $seatNo = 0;
    $row_limit = $row;
    $col_limit = $col;
    $shelf = 1;

    for($k = 0; $k < $levels; $k++)
    {
        $shelf = $k +1;
				?>
        <table class='cagex table-auto  mx-auto w-3/4 whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>

        </br>
			<?php
        for($i = 0; $i < $row_limit; $i++)
        {
            $width = 10/($col_limit+1);
					?>
           <tr class="bg-gray-200 content-center">
            <td class="border content-center py-4 text-center text-semibold border-gray-400" width=".$width."%>Shelf # {{ $shelf }}  </td>
					<?php
            for($j = 0; $j < $col_limit; $j++)
            {

              $seatNo = $j + $slotNo;
              $classno= ($seatNo + 1);
              ?>
				<td class="{{ $classno }} content-center border py-2 border-gray-400">
			<?php
                $row = $rack_info[$seatNo];

                if( $row['status'] == 'O' )
                {
                  ?>
                  <div align="center">
                  <span style="border:2px solid red;" class="event" draggable="true" id="<?php echo $row['cage_id']; ?>" >
                        <?php echo sprintf("%04d", $row['cage_id'] ); ?>
                  </span>
                </div>
          <?php }
                else {  }
                  //echo $seatNo;
                echo "</td>";
            }
            echo "</tr>";
            $slotNo = $slotNo +  $col_limit;
        }
    }
    echo "</table>";
?>

</br>
</br>
    <div id="reorgmsg" class="block text-green-700 text-sm font-normal mb-2" align="center">

	</div>
	<div id="test" class="block text-pink-200 text-sm font-normal mb-2" align="center">
		<x-button class="btn btn-xs bg-blue-600 hover:bg-gray-200 text-xs text-gray-200 btn-info" id="postreorg">
			Update Cage Locations
		</x-button>
	</div>
</br>
</br>
</br>
