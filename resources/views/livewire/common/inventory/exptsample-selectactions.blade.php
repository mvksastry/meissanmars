<div class="flex space-x-1 justify-around">
   <modal :value="$exptsample_id">
      <slot name="trigger">
            <button 
					@click="open = false" class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded">
               <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
            </button>
      </slot>
			Selected Details will appear on the left side panel
			</br>
		<button wire:click="selectedExptsampleId('{{$exptsample_id}}')" @click="open = false"  class="bg-green-800 w-22 hover:bg-blue-800 text-white font-normal py-2 px-4 mx-3  rounded">Selected {{ $exptsample_id }}</button>
   </modal>
</div>