@props(['name', 'title'])
<?php $name = "Test"; ?>
<div 
     x-data ="{ show: false,name: '{{ $name }}' }"
    x-show = "show"
    x-on:open-modal.window = "show = ($event.detail.name === name)"
    x-on:close-modal.window = "show = false"
    x-on:keydown.escape.window="show=false"
    x-on:open-modal.window = "console.log($event.detail); show = true"
    class="fixed z-50 inset-0">
    
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <x-modal name="product-confirm" wire:modal="displayingModal">
        <x-slot name="title">
            {{ $state['title'] }}
        </x-slot>

        <x-slot name="content">
            <p>
                {{ $state['message'] }}
            </p>
        </x-slot>
        
        <x-slot:body>
        product: 1
        </x-slot:body>
        
        <x-slot name="footer">
            <x-button wire:click="cancel" wire:loading.attr="disabled">
                {{ __('No') }}
            </x-button>

            <x-button class="ml-3" wire:click="confirm" wire:loading.attr="disabled">
                {{ __('Yes') }}
            </x-button>
        </x-slot>
    </x-modal>
    
   
    
    
    </div>

