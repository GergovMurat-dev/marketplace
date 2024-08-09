<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $company_id
 * @property string $short_description
 * @property float $price
 * @property float $old_price
 *
 * @property Company $company
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
        'sku',
        'company_id'
    ];

    protected $casts = [
        'price' => 'float',
        'old_price' => 'float',
        'sku' => 'int'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
