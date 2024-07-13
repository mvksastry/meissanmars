@extends('layouts.nGlobal')
@section('content')
	<!--Container-->
	<div class="container min-h-screen mx-auto pt-20">
		<div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">

			<!--Divider-->
			<hr class="border-b-2 border-gray-600 my-2 mx-4">
			<!--Divider-->

      <div class="flex flex-row flex-wrap flex-grow mt-2">
				<div class="w-full p-3">
          <div class="bg-purple-100 border border-gray-800 rounded shadow">

            <div class="border-b border-gray-800 p-3">
              <h5 class="font-bold uppercase text-gray-900">Add New Floor</h5>
            </div>

            <div class="w-2/4 p-5">
							{!! Form::open(['method' => 'POST', 'route' => ['roomsnracks.store']]) !!}
								<label class="block text-pink-200 text-sm font-normal mb-2" for="username">
									Floor Name*
								</label>

								<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" value="" id="floor" name="floor" type="text" placeholder="Floor Name">

								<div class="py-4 mt-2">
									<x-jet-button class="btn btn-xs text-xs text-gray-200 btn-info p-1">Submit</x-jet-button>
								</div>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
			<!--/table Card-->
		<!--/ Console Content-->
		</div>
	</div>
	<!--/container-->
@stop
