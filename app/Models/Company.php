<?php

namespace App\Models;

use App\Enums\User\UserCompanyTypesEnum;
use App\Enums\User\UserTypesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property UserTypesEnum $type
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
}
