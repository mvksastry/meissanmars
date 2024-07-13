	<!--Table Card-->
	<div class="w-full md:w-3/5 p-3">
		<div class="bg-purple-100 border border-gray-800 rounded shadow">
            <div class="border-b border-gray-800 p-3">
                <h5 class="font-bold uppercase text-gray-900">Bulk Upload Instructions: Input Fields with * Mandatory</h5>
            </div>
            <div class="p-5">
                @if($bulkUploadSuccess)
                    <div
                      class="font-regular relative block w-full max-w-screen-md rounded-lg bg-green-500 px-4 py-4 text-base text-white"
                      data-dismissible="alert"
                    >
                        <i class="fas fa-exclamation mr-2"></i>
                      Bulkupload module not yet commissioned
                    </div>
                @endif
                
                @if($bulkUploadFail)
                    <div class="font-regular relative block w-full rounded-lg bg-gradient-to-tr from-red-600 to-red-400 px-4 py-4 text-base text-white" data-dismissible="alert">
                        <div class="absolute top-4 left-4">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              viewBox="0 0 24 24"
                              fill="currentColor"
                              aria-hidden="true"
                              class="h-6 w-6"
                            >
                              <path
                                fill-rule="evenodd"
                                d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd"
                              ></path>
                            </svg>
                        </div>
                        <div class="ml-8 mr-12">Bulkupload Failed, errors in data</div>
                    </div>
                @endif
                
                <!-- insert table -->
                <table class="w-full p-5 text-gray-700">
                    <thead>
                        <tr>
                          <th class="text-left text-gray-900">Instructions: Please take note of the following</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-sm text-gray-900" align="left">
                                Use the Excel template provided and fill all the columns as desired
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- insert a table containing buttons of various types of entry -->
                
                <!-- insert table -->
                <table class="w-full p-5 text-gray-700">
                    <thead>
                        <tr>
                            <th align="center"></th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr>
                            <td> 
                            <label class="block text-gray-900 text-sm font-normal mb-2" for="username">
                                Upload Excel File* 
                            </label>
                                <input type="file" placeholder="Upload File" wire:model="sampleExcel" multiple>
                                @error('exptFiles') <span class="text-danger error">{{ $message }}</span>@enderror
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3" class="text-sm text-gray-900">
                                </br></br>
                                @hasanyrole('pisg|researcher')
                                    <button wire:click="downloadBulkTemplate()" class="bg-orange-800 w-22 hover:bg-blue-800 text-white font-normal py-2 px-4 mx-3  rounded">Download Template</button>
                                    <button wire:click="processBulkInventoryUpload()" class="bg-green-800 w-22 hover:bg-blue-800 text-white font-normal py-2 px-4 mx-3  rounded">Upload New Products</button>
                                @endhasanyrole
                            </td>
                        </tr>
                    </tbody>    
                </table>
            </div>
		</div>
	</div>
	<!--/table Card-->