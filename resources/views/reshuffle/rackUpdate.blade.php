<script>
	// activate collapse right menu when the windows is resized
	$(document).ready(function() {
		////////////////////////////////////////////////////
		$.ajaxSetup({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$(".rack").click(function(e) {
			fulladdress = '/reshuffle/fetchCages/';
			var rackName = $(this).attr('id');
			$.ajax({
				url: fulladdress,
				type:"GET",
				data:{
					rackName:rackName,
					_token: '{{csrf_token()}}'
				},
				success:function(response){
					console.log(response);
					if(response)
					{
						//$('.success').text(response.success);
						//$("#ajaxform")[0].reset();
						//$("#racksInfo").load(" #divid");
						$("#cageLayout").html(response);
					}
				},
			});
		});
	});
	///////////
</script>

<!-- Left Panel Graph Card-->
<?php 
	$rackPath = "/facility/racks/";
?>
@foreach($racks as $rack)
	<div class="text-gray-900 px-4">{{ $rack->rack_name }}</div>
	<img class="rack inline px-2 py-2 m-2" src="{{ tenant_asset($rackPath.'shelf.png') }}" alt="" width="100px" id="{{ $rack->rack_name }}"height="100px">
@endforeach
<!-- / End of Left Panel Graph Card-->
