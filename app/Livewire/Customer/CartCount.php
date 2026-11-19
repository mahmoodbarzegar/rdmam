<?php

namespace App\Livewire\Customer;

use Livewire\Attributes\On;
use Livewire\Component;

class CartCount extends Component

{
    public int $count = 0;

    public function mount(): void
    {
        $this->updateCount();
    }

    #[On('cart-updated')]
    public function updateCount(): void
    {
        $cart = session()->get('cart', []);

        $this->count = count($cart);


    }

    public function render()
    {
        return view('livewire.customer.cart-count');
    }

}
