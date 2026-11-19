<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * خودروها
 * جدول: vehicles
 */
class Vehicle extends Model
{
    protected $fillable = [
        'name',
    ];



    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_vehicle');
    }
}
