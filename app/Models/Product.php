<?php

namespace App\Models;

use App\Enums\CartUnit;
use App\Enums\ProductDefaultUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * کالاها
 * جدول: products
 */
class Product extends Model
{
    protected $fillable = [
        'erp_code',
        'erp_id',
        'name',
        'default_unit',
        'main_unit',
        'brand_id',
        'category_id',
        'erp_attributes',
        'type',
        'status',
        'image',
        'description',
        'min_order_qty',
        'max_order_qty',
        'min_order_carton_qty',
        'max_order_carton_qty',
        'settlement_deadline_days',
        'carton_qty',
        'erp_synced_at',
    ];

    public function prices() :HasMany
    {
        return $this->hasMany(Price::class);
    }

    public function customerPrice(): HasOne
    {
        return $this->hasOne(Price::class)->where('is_approved', true)->latestOfMany();
    }


    protected function casts(): array
    {
        return [
            'erp_attributes' => 'array',
            'erp_synced_at' => 'datetime',
            'default_unit' => ProductDefaultUnit::class,
            'main_Unit' => ProductDefaultUnit::class
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class, 'product_vehicle');
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(ProductWarehouseStock::class);
    }

    public function substitutes(): HasMany
    {
        return $this->hasMany(ProductSubstitute::class);
    }

    public function syncErrors(): HasMany
    {
        return $this->hasMany(ProductSyncError::class);
    }

    /** یکدست‌سازی متن برای جست‌وجو؛ مقدار اصلی ذخیره‌شده تغییر نمی‌کند و صفرهای ابتدایی حفظ می‌شود. */
    public static function normalize(?string $value): string
    {
        $value = strtr((string)$value, [
            'ي' => 'ی', 'ك' => 'ک', 'ى' => 'ی', 'ۀ' => 'ه', 'ة' => 'ه',
            '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
            '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
            '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
            '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
            "\u{200C}" => '', "\u{200F}" => '',
        ]);

        return mb_strtolower(preg_replace('/[\s\-_.\/]+/u', '', $value));
    }

    public function scopeOrderable($q)
    {
        return $q->where('is_active', true)->where('is_orderable', true);
    }

    public function supportsCarton(): bool
    {
        return $this->carton_qty !== null && $this->carton_qty > 0;
    }

    /** تبدیل مقدار واردشده به تعداد پایه؛ کارتن فقط برای کالای دارای carton_qty. */
    public function toBaseQty(int $qty, CartUnit $unit): int
    {
        if ($unit === CartUnit::Carton) {
            abort_unless($this->supportsCarton(), 422, 'فروش کارتنی برای این کالا فعال نیست.');
            return $qty * $this->carton_qty;
        }

        return $qty;
    }
}
