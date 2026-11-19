<?php

namespace App\Livewire\BranchAdmin;

use App\Models\Customer;
use App\Enums\CustomerStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BranchAdminDashboard extends Component
{
    use WithPagination;

    #[Url(as: 'search', except: '', history: true)]
    public string $search = '';

    #[Url(as: 'status', except: '', history: true)]
    public string $status = '';

    public int $perPage = 20;

    protected string $paginationTheme = 'tailwind';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'status']);
        $this->resetPage();
    }

    protected function customersQuery(): Builder
    {
        return Customer::query()
            ->where('status', '<>', CustomerStatus::Active->value)
            ->with([
                'user:id,name,mobile',
                'province:id,name',
                'city:id,name',
            ])
            ->when($this->status !== '', function (Builder $query) {
                $query->where('status', $this->status);
            })
            ->when(trim($this->search) !== '', function (Builder $query) {
                $search = '%' . trim($this->search) . '%';

                $query->where(function (Builder $query) use ($search) {
                    // Business name
                    $query->where('business_name', 'LIKE', $search)

                        // User name and mobile
                        ->orWhereHas('user', function (Builder $user) use ($search) {
                            $user->where('name', 'LIKE', $search)
                                ->orWhere('mobile', 'LIKE', $search);
                        })

                        // Province name
                        ->orWhereHas('province', function (Builder $province) use ($search) {
                            $province->where('name', 'LIKE', $search);
                        })

                        // City name
                        ->orWhereHas('city', function (Builder $city) use ($search) {
                            $city->where('name', 'LIKE', $search);
                        });
                });
            })
            ->latest();
    }

    public function getStatusLabel(string $status): string
    {
        $enum = CustomerStatus::tryFrom($status);

        if (!$enum) {
            return $status;
        }

        if (method_exists($enum, 'label')) {
            return $enum->label();
        }

        return Str::headline($enum->value);
    }

    public function getStatusClasses(string $status): string
    {
        return match ($status) {
            'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
            'rejected' => 'bg-red-50 text-red-700 ring-red-600/20',
            'suspended' => 'bg-orange-50 text-orange-700 ring-orange-600/20',
            'inactive' => 'bg-gray-100 text-gray-700 ring-gray-500/20',
            default => 'bg-slate-100 text-slate-700 ring-slate-500/20',
        };
    }

    #[Title('لیست مشتری ها')]
    public function render()
    {
//        $inActiveCustomers = Customer::query()->where('status','<>',CustomerStatus::Active)->with(['user','province','city'])->paginate(20);

        return view('livewire.branch-admin.branch-admin-dashboard',[
            'customers' => $this->customersQuery()->paginate($this->perPage),
            'statuses' => collect(CustomerStatus::cases())
                ->reject(fn ($case) => $case === CustomerStatus::Active),
        ])->layout('layouts.branch-admin-layout');
    }
}
