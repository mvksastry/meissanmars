	<!--Table Card-->
	<div class="w-full md:w-1/full p-3">
        <div class="bg-orange-100 border border-gray-800 rounded shadow">
            <div class="border-b border-gray-800 p-3">
                <h5 class="font-bold uppercase text-gray-900">Bulk Upload Instructions: Input Fields with * Mandatory</h5>
            </div>
            <div class="p-5">
                
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
                            <th align="center">
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr>
                            <td> 
                            <label class="block text-gray-900 text-sm font-normal mb-2" for="username">
                                New Sample Code* (Suggestion)
                            </label>
                            <input  class="shadow appearance-none border border-red-500 rounded w-auto py-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline" id="title" wire:model="sampCode" type="text">
                            </td>
                        </tr>
                        
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
                                <button wire:click="downloadTemplate()" class="bg-orange-800 w-22 hover:bg-blue-800 text-white font-normal py-2 px-4 mx-3  rounded">Download Template</button>
                                <button wire:click="processBulkUpload()" class="bg-green-800 w-22 hover:bg-blue-800 text-white font-normal py-2 px-4 mx-3  rounded">Upload Sample Data</button>
                                @endhasanyrole
                            </td>
                        </tr>
                    </tbody>    
                </table>
            </div>
		</div>
	</div>
	<!--/table Card-->