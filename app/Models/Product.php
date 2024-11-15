<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * Get all of the sales for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function saleProducts(): HasMany
    {
        return $this->hasMany(SaleProduct::class);
    }
}
