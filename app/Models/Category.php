<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Collection\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property bool $is_active
 * @property int $parent_id
 * @property int $company_id
 *
 * @property Category $parent
 * @property Company $company
 * @property Collection<Category> $children
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'parent_id',
        'company_id'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
