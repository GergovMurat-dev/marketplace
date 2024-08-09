<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $short_description
 * @property float $price
 * @property float $old_price
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'short_description',
        'price',
        'old_price',
        'sku'
    ];

    protected $casts = [
        'price' => 'float',
        'old_price' => 'float',
        'sku' => 'int'
    ];
}
