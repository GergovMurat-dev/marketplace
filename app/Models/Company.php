<?php

namespace App\Models;

use App\Enums\User\UserCompanyTypesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Collection\Collection;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property UserCompanyTypesEnum $type
 *
 * @property Collection<Product> $products
 * @property Collection<Category> $categories
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type'
    ];

    protected $casts = [
        'type' => UserCompanyTypesEnum::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
