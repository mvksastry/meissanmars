<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
	// activate collapse right menu when the windows is resized
	$(document).ready(function() {
		//host = 'view/';
		////////////////////////////////////////////////////
		$.ajaxSetup({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$(".room").click(function(e) {
			var fulladdress = '/reshuffle/fetchRacks/';
			var room = $(this).attr('id');

			$.ajax({
				url: fulladdress,
				type:"GET",
				data:{
					room:room,
					_token: '{{csrf_token()}}'
				},
				success:function(response){
					console.log(response);
					if(response) {
					//$('.success').text(response.success);
					//$("#ajaxform")[0].reset();
					$("#racksInfo").html(response);
					}
				},
			});
		});
	});
	///////////
</script>
@extends('layouts.nGlobal')
@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
	<div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
	<!--Console Content-->
	<h5 class="font-normal uppercase text-gray-900">Facility >> Reshuffle Cages</h5>
	<!--Divider-->
	<hr class="border-b-2 border-gray-600 my-8 mx-4">
	<!--Divider-->
	<div class="flex flex-wrap">

	</div>
	<!--End of Console content-->
	<?php 
		$roomPath = "/facility/rooms/";
	?>
	<div class="flex flex-row flex-wrap flex-grow mt-2">
		<!-- Left Panel Graph Card-->
		<div class="w-1/2 md:w-1/2 p-3">
			<div class="bg-orange-100 border border-gray-800 rounded shadow">
				<div class="border-b border-gray-800 p-3">
					<h5 class="font-bold uppercase text-gray-900">Rooms</h5>
				</div>
				<div class="p-5">
					@foreach ($rooms as $room)
					<button>
						<img class="room m-4" src="{{ tenant_asset($roomPath.$room->image_id) }}" alt="" width="75px" id="{{ $room->image_id }}" height="75px">
					</button>
					@endforeach
				</div>
			</div>
		</div>

		<div class="w-1/2 md:w-1/2 p-3">
			<div class="bg-orange-100 border border-gray-800 rounded shadow">
				<div class="border-b border-gray-800 p-3">
					<h5 class="font-bold uppercase text-gray-900">Racks in Room</h5>
				</div>
				<div class="errors">
					@if (session()->has('formmessage'))
					<div class="alert alert-success">
						{{ session('message') }}
					</div>
					@endif
				</div>
				<div class="errors">

				</div>
				<div class="p-5">
					<div id="racksInfo">

					</div>
				</div>
			</div>
		</div>
		<!-- / End of Left Panel Graph Card-->
	</div>


	<div class="flex flex-row flex-wrap flex-grow mt-2">
		<!--Table Card-->
		<div class="w-full p-3">
			<div class="bg-orange-100 border border-gray-800 rounded shadow">
				<div class="border-b border-gray-800 p-3">
					<h5 class="font-bold uppercase text-gray-900">Racks</h5>
				</div>
				<div class="p-5">
					<div id="cageLayout">

					</div>
				</div>
			</div>
		</div>
		<!--/table Card-->
	</div>
	<!--/ Console Content-->
	</div>
</div>
<!--/container-->
