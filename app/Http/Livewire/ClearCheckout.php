<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ClearCheckout extends Component
{
    public function mount()
    {
        if (!request()->is('checkout*')) {
            session()->forget('direct_checkout');
        }
    }


    public function render()
    {
        return view('livewire.clear-checkout');
    }
}
