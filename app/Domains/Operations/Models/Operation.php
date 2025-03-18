<?php

namespace App\Domains\Operations\Models;

use App\Domains\Customers\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property string $operation_type
 * @property float $amount
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 */
class Operation extends Model
{
    protected $fillable = [
        'user_id',
        'operation_type',
        'amount',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

