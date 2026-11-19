<?php

namespace App\Livewire\BranchAdmin;

use App\Enums\CustomerStatus;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

class BranchAdminShowCustomer extends Component
{
    public Customer $customer;
    public string $status_reason = '';
//    public string $credit = '';

    public string $status = '';

    public function mount(Customer $customer): void
    {
        $this->customer = $customer->load([
            'user',
            'province',
            'city',
        ]);

        $this->status = $customer->status->value
            ?? $customer->status;

        $this->status_reason = $customer->status_reason ?? '';
        $this->credit = $customer->credit ?? '';

    }

    public function updateStatus(): void
    {
        $isApproved = $this->status === CustomerStatus::Active->value;

        $validated = $this->validate([
            'status' => [
                'required',
                Rule::enum(CustomerStatus::class),
            ],
            'status_reason' => [
                $isApproved ? 'nullable' : 'required',
                'string',
                'max:1000',
            ],
        ]);

        $this->customer->update([
            'status' => $validated['status'],

            'status_reason' => $isApproved
                ? null
                : $validated['status_reason'],
//            'status_reason' => $isApproved
//                ? null
//                : $validated['status_reason'],

            'approved_by' => $isApproved
                ? auth()->id()
                : null,

            'approved_at' => $isApproved
                ? now()
                : null,
        ]);

        $this->customer->refresh();

        $this->dispatch('notify',
            type: 'success',
            message: 'وضعیت مشتری با موفقیت تغییر کرد.'
        );
    }

    public function statusLabel(string $status): string
    {
        $enum = CustomerStatus::tryFrom($status);

        if (!$enum) {
            return $status;
        }

        return method_exists($enum, 'label')
            ? $enum->label()
            : Str::headline($enum->value);
    }

    #[Title('مشاهده اطلاعات مشتری')]
    public function render()
    {
        return view('livewire.branch-admin.branch-admin-show-customer', [
            'statuses' => CustomerStatus::cases(),
        ])->layout('layouts.branch-admin-layout');
    }
}
