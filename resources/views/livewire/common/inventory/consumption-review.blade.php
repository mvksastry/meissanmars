<div>
	{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
	{{-- Do your work, then step back. --}}
	<!--End of Console content-->
	<!--Container-->
	<div class="container w-full mx-auto pt-20">
		<div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
			<!--Console Content-->
			<div class="flex flex-wrap">
				<!--Metric Card 1 -->
				<div class="w-full md:w-1/3 xl:w-1/3 p-3">
					<div class="bg-purple-100 border border-gray-800 rounded shadow p-2">
						<div class="flex flex-row items-center">
							<div class="flex-shrink pr-4">
								<div class="rounded p-3 bg-green-600">
									<a href="/manage-inventory">
										<i class="fa fa-wallet fa-1x fa-fw fa-inverse"></i>
									</a>
								</div>
							</div>
							<div class="flex-1 text-left md:text-center">
									<h4 class="font-bold uppercase text-gray-900">Add Inventory</h4>
									<h5 class="font-normal text-left text-sm text-gray-900">Total Fine: Bulk: Parts: Stationery</h5>
							</div>
						</div>
					</div>
				</div>
				<!--/End Metric Card 1-->
			
				<!--Metric Card 2 -->
				<div class="w-full md:w-1/3 xl:w-1/3 p-3">
					<div class="bg-purple-100 border border-gray-800 rounded shadow p-2">
						<div class="flex flex-row items-center">
							<div class="flex-shrink pr-4">
								<div class="rounded p-3 bg-orange-600">
									<a href="/update-consumption">
										<i class="fas fa-users fa-1x fa-fw fa-inverse"></i>
									</a>
								</div>
							</div>
							<div class="flex-1 text-right md:text-center">
								<h4 class="font-bold uppercase text-gray-900">Update Consumption</h4>
								<h5 class="font-normal text-left text-sm text-gray-900">Update usage</h5>
							</div>
						</div>
					</div>
				</div>
				<!--/End Metric Card 2-->
				
				<!-- Metric Card 2-->
				<div class="w-full md:w-1/3 xl:w-1/3 p-3">
					<div class="bg-purple-100 border border-gray-800 rounded shadow p-2">
						<div class="flex flex-row items-center">
							<div class="flex-shrink pr-4">
								<div class="rounded p-3 bg-yellow-600">
									<a href="replenishment-review">
										<i class="fas fa-tasks fa-1x fa-fw fa-inverse"></i>
									</a>
								</div>
							</div>
							<div class="flex-1 text-right md:text-center">
								<h5 class="font-bold uppercase text-gray-900">Review Replinishment</h5>
								<h5 class="font-normal text-left text-sm text-gray-900">Search All Categories</h5>
							</div>
						</div>
					</div>
				</div>
				<!-- Metric Card-->
			</div>

			<!--End of Console content-->
			<!--Divider-->
			<hr class="border-b-2 border-gray-600 my-2 mx-2">
			<!--Divider-->
			<div class="flex flex-row flex-wrap flex-grow mt-2">
				<!-- Left Panel Graph Card-->
				<div class="w-full md:w-full p-3">
					<div class="bg-orange-100 border border-gray-800 rounded shadow">
						<div class="border-b border-gray-800 p-3">
							<h5 class="font-bold uppercase text-gray-600">{{ $panel_title }}</h5>
						</div>
						<div class="p-5">
							<livewire:common.inventory.consumption-search
								searchable="pack_mark_code, name, catalog_id"
								exportable
							/>
							<canvas id="chartjs-7" class="chartjs" width="undefined" height="undefined"></canvas>
						</div>
					</div>
				</div>
				<!-- / End of Left Panel Graph Card-->

				<!-- Right Panel Graph Card-->
				<!-- / End of right Panel Graph Card-->
				<!--Table Card-->
				<!--/table Card-->
			</div>
			<!--/ Console Content-->
		</div>
	</div>
	<!--/container-->
</div>