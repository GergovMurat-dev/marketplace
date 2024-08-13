<?php

namespace App\Models;

use App\Enums\Product\ProductStatusesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $short_description
 * @property float $price
 * @property float $old_price
 * @property int $company_id
 * @property int $brand_id
 * @property ProductStatusesEnum $status
 *
 * @property Company $company
 * @property Brand $brand
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
        'company_id',
        'brand_id',
        'status'
    ];

    protected $casts = [
        'price' => 'float',
        'old_price' => 'float',
        'sku' => 'int',
        'status' => ProductStatusesEnum::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
