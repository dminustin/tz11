<?php

namespace App\Domains\Customers\Models;

use App\Domains\Operations\Models\Operation;
use App\Models\User as BaseUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property float $balance
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection|Operation[] $operations
 */
class User extends BaseUser
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'balance',
    ];
    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class);
    }
}
