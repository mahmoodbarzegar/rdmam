<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\Attributes\On;

class CartDrawer extends Component
{
    public bool $open = false;

    public array $cart = [];

    public function mount(): void
    {
        $this->loadCart();
    }

    #[On('open-cart-drawer')]
    public function openDrawer(): void
    {
        $this->loadCart();
        $this->open = true;
    }

    #[On('cart-updated')]
    public function refreshCart(): void
    {
        $this->loadCart();
    }

    public function closeDrawer(): void
    {
        $this->open = false;
    }

    public function loadCart(): void
    {
        $this->cart = session()->get('cart', []);
    }

    public function removeItem(string $key): void
    {
        $cart = session()->get('cart', []);

        unset($cart[$key]);

        session()->put('cart', $cart);

        $this->cart = $cart;

        $this->dispatch('cart-updated');

        $this->dispatch(
            'notify',
            type: 'success',
            message: 'محصول از سبد خرید حذف شد.'
        );
    }

    public function getTotalProperty(): int
    {
        return collect($this->cart)->sum(
            fn($item) => $item['price'] * $item['quantity']
        );
    }

    public function getWeightedSettlementDeadlineProperty(): ?float
    {
        $weightedDays = 0;
        $totalWeight = 0;

        foreach ($this->cart as $item) {
            $days = $item['settlement_deadline_days'] ?? null;

            if (!is_numeric($days) || (float) $days < 0) {
                return null;
            }

            $weight = (float) $item['price'] * (int) $item['quantity'];

            if ($weight <= 0) {
                continue;
            }

            $weightedDays += (float) $days * $weight;
            $totalWeight += $weight;
        }

        if ($totalWeight <= 0) {
            return null;
        }

        return round($weightedDays / $totalWeight, 2);
    }


    public function render()
    {
        return view('livewire.customer.cart-drawer');
    }
}
