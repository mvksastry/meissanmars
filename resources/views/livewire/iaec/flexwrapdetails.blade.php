<div class="container w-full mx-auto pt-20">
	<div class="w-full px-4 md:px-0 md:mt-8 mb-0 text-gray-800 leading-normal">
		<!--Console Content-->
		<div class="flex flex-wrap">
		    @hasanyrole('pisg|pilg|piblg')
			<!--Metric Card -->
			<div class="w-full md:w-1/3 xl:w-1/3 p-3">
				<div class="bg-orange-100 border border-gray-800 rounded shadow p-2">
					<div class="flex flex-row items-center">
						<div class="flex-shrink pr-4">
							<div class="rounded p-3 bg-green-600">
								<a href="/strain-manage/create">
									<i class="fa fa-wallet fa-1x fa-fw fa-inverse"></i>
								</a>
							</div>
						</div>
						<div class="flex-1 text-left md:text-center">
							<h5 class="font-bold uppercase text-gray-900">Add Strain</h5>
						</div>
					</div>
				</div>
			</div>
			<!--/End Metric Card -->
			@endhasanyrole
			
			@hasanyrole('pisg|pilg|piblg|pient|researcher')
			<!--Metric Card -->
			<div class="w-full md:w-1/3 xl:w-1/3 p-3">
				<div class="bg-orange-100 border border-gray-800 rounded shadow p-2">
					<div class="flex flex-row items-center">
						<div class="flex-shrink pr-4">
							<div class="rounded p-3 bg-green-600">
								<a href="manage-protocol">
									<i class="fa fa-wallet fa-1x fa-fw fa-inverse"></i>
								</a>
							</div>
						</div>
						<div class="flex-1 text-left md:text-center">
							<h5 class="font-bold uppercase text-gray-900">Add Protocol</h5>
						</div>
					</div>
				</div>
			</div>
			<!--/End Metric Card -->
			@endhasanyrole
			
			@hasanyrole('pisg|pilg|piblg|pient')
			<!--Metric Card-->
			<div class="w-full md:w-1/3 xl:w-1/3 p-3">
				<div class="bg-orange-100 border border-gray-800 rounded shadow p-2">
					<div class="flex flex-row items-center">
						<div class="flex-shrink pr-4">
							<div class="rounded p-3 bg-yellow-600">
								<a href="{{ route('piprojects.create') }}">
									<i class="fas fa-user-plus fa-1x fa-fw fa-inverse"></i>
								</a>
							</div>
						</div>
						<div class="flex-1 text-right md:text-center">
							<h5 class="font-bold uppercase text-gray-900">New Project</h5>
						</div>
					</div>
				</div>
			</div>
			<!--/Metric Card-->
			@endhasanyrole
			
			@hasanyrole('pisg|pilg|piblg|pient')
			<!--Metric Card-->
			<div class="w-full md:w-1/3 xl:w-1/3 p-3">
				<div class="bg-orange-100 border border-gray-800 rounded shadow p-2">
					<div class="flex flex-row items-center">
						<div class="flex-shrink pr-4">
							<div class="rounded p-3 bg-yellow-600">
								<a href="{{ route('piprojects.index') }}">
									<i class="fas fa-user-plus fa-1x fa-fw fa-inverse"></i>
								</a>
							</div>
						</div>
						<div class="flex-1 text-right md:text-center">
							<h5 class="font-bold uppercase text-gray-900">Edit Project</h5>
						</div>
					</div>
				</div>
			</div>
			<!--/Metric Card-->
			@endhasanyrole
			
			@hasanyrole('pisg|pilg|piblg')
			<!--Metric Card -->
			<div class="w-full md:w-1/3 xl:w-1/3 p-3">
				<div class="bg-orange-100 border border-gray-800 rounded shadow p-2">
						<div class="flex flex-row items-center">
							<div class="flex-shrink pr-4">
								<div class="rounded p-3 bg-green-600">
									<a href="/projectapprovals">
										<i class="fa fa-wallet fa-1x fa-fw fa-inverse"></i>
									</a>
								</div>
							</div>
							<div class="flex-1 text-left md:text-center">
								<h5 class="font-bold uppercase text-gray-900">Approve Project</h5>
							</div>
						</div>
				</div>
			</div>
			<!--/End Metric Card -->
			@endhasanyrole
			
			@hasanyrole('pisg|pilg|piblg')
			<!--Metric Card -->
			<div class="w-full md:w-1/3 xl:w-1/3 p-3">
				<div class="bg-orange-100 border border-gray-800 rounded shadow p-2">
					<div class="flex flex-row items-center">
						<div class="flex-shrink pr-4">
							<div class="rounded p-3 bg-green-600">
								<a href="/show-usage">
									<i class="fa fa-wallet fa-1x fa-fw fa-inverse"></i>
								</a>
							</div>
						</div>
						<div class="flex-1 text-left md:text-center">
							<h5 class="font-bold uppercase text-gray-900">IAEC Usage</h5>
						</div>
					</div>
				</div>
			</div>
			<!--/End Metric Card -->
			@endhasanyrole
			
	    </div>
		<!-- End of Console Content-->
	</div>
</div>
