<?php

namespace App\Livewire;

//use Livewire\Component;
use App\Models\Products;

use LivewireUI\Modal\ModalComponent;
use Livewire\Attributes\On;

class ModalTest extends ModalComponent
{
 
    public Products $product_id;
        
    public function mount(Products $product_id)
    {
      $this->product_id = $product_id;
      //dd($this->product_id);
      
    }
    
    public function render()
    {
      $prodetails = Products::where('product_id', $this->product_id)->first();
      dd($prodetails);
        return view('livewire.modal-test')->with(['prodetails'=>$prodetails]);
    }
    
    public static function modalMaxWidth(): string
    {
      return 'sm';
    }
}
