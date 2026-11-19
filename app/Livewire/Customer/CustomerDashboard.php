<?php

namespace App\Livewire\Customer;

use App\Models\Price;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

#[Layout('layouts.customer-layout')]
class CustomerDashboard extends Component
{
    use WithPagination;

    #[Url(as: 'search', history: true)]
    public string $search = '';

//    #[Url(as: 'status', history: true)]
//    public string $status = 'all';

    #[Url(as: 'sort', history: true,except: 'newest')]
    public string $sort = 'newest';

    public array $quantities = [];

    public array $cartonMode = [];

    public ?string $successMessage = null;

    protected string $paginationTheme = 'tailwind';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

//    public function updatedStatus(): void
//    {
//        $this->resetPage();
//    }

    public function updatedSort(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {

        $this->reset([
            'search',
//            'status',
            'sort',
        ]);

        $this->resetPage();
    }

    /**
     * محدودیت سفارش بر اساس نوع خرید
     */
    private function getOrderLimits(Product $product, bool $isCarton): array
    {
        if ($isCarton) {
            if (
                $product->min_order_carton_qty === null ||
                $product->max_order_carton_qty === null
            ) {
                throw new \InvalidArgumentException(
                    'خرید کارتنی برای این محصول مجاز نیست.'
                );
            }

            return [
                'min' => (int)$product->min_order_carton_qty,
                'max' => (int)$product->max_order_carton_qty,
                'unit' => 'کارتن',
            ];
        }

        return [
            'min' => (int)$product->min_order_qty,
            'max' => (int)$product->max_order_qty,
            'unit' => 'عدد',
        ];
    }

    /**
     * تغییر نوع خرید
     */
    public function updatedCartonMode($value, $productId): void
    {
        $product = Product::find($productId);

        if (!$product) {
            return;
        }

        $isCarton = filter_var($value, FILTER_VALIDATE_BOOLEAN);

        // بررسی مجاز بودن خرید کارتنی
        if (
            $isCarton &&
            (
                $product->min_order_carton_qty === null ||
                $product->max_order_carton_qty === null
            )
        ) {
            $this->cartonMode[$productId] = false;

            return;
        }

        $limits = $this->getOrderLimits($product, $isCarton);

        // با تغییر نوع خرید، تعداد روی حداقل مجاز قرار می‌گیرد.
        $this->quantities[$productId] = $limits['min'];

        $this->resetErrorBag("quantities.{$productId}");
    }

    /**
     * افزودن محصول به سبد خرید
     */
    public function addToCart(int $productId): void
    {
        $product = Product::query()
            ->with('customerPrice')
            ->where('status', 'active')
            ->findOrFail($productId);

        $isCarton = filter_var(
            $this->cartonMode[$productId] ?? false,
            FILTER_VALIDATE_BOOLEAN
        );

        $limits = $this->getOrderLimits($product, $isCarton);

        $quantity = filter_var(
            $this->quantities[$productId] ?? $limits['min'],
            FILTER_VALIDATE_INT
        );

        if (
            $quantity === false ||
            $quantity < $limits['min'] ||
            $quantity > $limits['max']
        ) {
            $this->addError(
                "quantities.{$productId}",
                "تعداد سفارش باید بین {$limits['min']} و {$limits['max']} {$limits['unit']} باشد."
            );

            return;
        }

//        if ((int)$product->stock_quantity <= 0) {
//            $this->addError(
//                "quantities.{$productId}",
//                'موجودی این محصول به پایان رسیده است.'
//            );
//
//            return;
//        }

        $price = $product->customerPrice;

        if (!$price) {
            $this->addError(
                "quantities.{$productId}",
                'برای این محصول قیمت فعالی ثبت نشده است.'
            );

            return;
        }

        $cart = session()->get('cart', []);

        // خرید عددی و کارتنی هر محصول، ردیف جداگانه دارند.
        $cartKey = $product->id . '_' . ($isCarton ? 'carton' : 'unit');

        $currentQuantity = (int)($cart[$cartKey]['quantity'] ?? 0);

        $newQuantity = $currentQuantity + $quantity;

        if ($newQuantity > $limits['max']) {
            $this->addError(
                "quantities.{$productId}",
                "حداکثر مقدار مجاز برای این سفارش {$limits['max']} {$limits['unit']} است."
            );

            return;
        }

        $cart[$cartKey] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'product_code' => $product->erp_code,
            'price' => $price->price,
            'quantity' => $newQuantity,
            'purchase_type' => $isCarton ? 'carton' : 'unit',
            'unit_label' => $limits['unit'],
            'settlement_deadline_days' => $product->settlement_deadline_days,
        ];

        session()->put('cart', $cart);


        $this->successMessage = 'محصول با موفقیت به سبد خرید اضافه شد.';

        $this->resetErrorBag("quantities.{$productId}");

        $this->dispatch('cart-updated');

        $this->dispatch(
            'notify',
            type: 'success',
            message: 'محصول با موفقیت به سبد خرید اضافه شد.'
        );
    }

    public function increaseQuantity(int $productId): void
    {
        $product = Product::find($productId);

        if (!$product) {
            return;
        }

        $isCarton = filter_var(
            $this->cartonMode[$productId] ?? false,
            FILTER_VALIDATE_BOOLEAN
        );

        $limits = $this->getOrderLimits($product, $isCarton);

        $quantity = (int)($this->quantities[$productId] ?? $limits['min']);

        if ($quantity < $limits['max']) {
            $this->quantities[$productId] = $quantity + 1;
        }

        $this->resetErrorBag("quantities.{$productId}");


        $this->dispatch('cart-updated');


    }

    public function decreaseQuantity(int $productId): void
    {
        $product = Product::find($productId);

        if (!$product) {
            return;
        }

        $isCarton = filter_var(
            $this->cartonMode[$productId] ?? false,
            FILTER_VALIDATE_BOOLEAN
        );

        $limits = $this->getOrderLimits($product, $isCarton);

        $quantity = (int)($this->quantities[$productId] ?? $limits['min']);

        if ($quantity > $limits['min']) {
            $this->quantities[$productId] = $quantity - 1;
        }

        $this->resetErrorBag("quantities.{$productId}");


        $this->dispatch('cart-updated');
    }

    /**
     * کوئری محصولات
     */
    private function productsQuery(): Builder
    {
        $query = Product::query()
            ->with('customerPrice');

        if (trim($this->search) !== '') {
            $search = trim($this->search);

            $query->where(function (Builder $query) use ($search) {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('erp_code', 'like', "%{$search}%");
            });
        }

//        if ($this->status === 'available') {
//            $query->where('stock_quantity', '>', 0);
//        } elseif ($this->status === 'unavailable') {
//            $query->where('stock_quantity', '<=', 0);
//        }

        switch ($this->sort) {
            case 'price_asc':
                $query->orderBy(
                    Price::query()
                        ->select('price')
                        ->whereColumn('prices.product_id', 'products.id')
                        ->where('is_approved', true)
                        ->latest('created_at')
                        ->limit(1)
                );
                break;

            case 'price_desc':
                $query->orderByDesc(
                    Price::query()
                        ->select('price')
                        ->whereColumn('prices.product_id', 'products.id')
                        ->where('is_approved', true)
                        ->latest('created_at')
                        ->limit(1)
                );
                break;

            case 'best_selling':
                $query->orderByDesc('sold_count');
                break;

            case 'name':
                $query->orderBy('name');
                break;

            case 'erp_code':
                $query->orderBy('erp_code');
                break;

            default:
                $query->latest('created_at');
                break;
        }

        return $query;
    }

    #[Title('پنل ثبت سفارش رادمان')]
    public function render()
    {
//        session()->flush();
        $products = $this->productsQuery()->paginate(10);

        foreach ($products as $product) {
            // حالت پیش‌فرض خرید: عددی
            if (!array_key_exists($product->id, $this->cartonMode)) {
                $this->cartonMode[$product->id] = false;
            }

            // مقدار اولیه تعداد: حداقل سفارش عددی
            if (!array_key_exists($product->id, $this->quantities)) {
                $this->quantities[$product->id] = (int)$product->min_order_qty;
            }
        }

        return view('livewire.customer.customer-dashboard', [
            'products' => $products,
        ])->layout('layouts.customer-layout');
    }


}
