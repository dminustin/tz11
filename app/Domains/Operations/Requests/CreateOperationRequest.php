<?php

namespace App\Domains\Operations\Requests;

use App\BaseClasses\BaseRequest;
use App\Domains\Customers\Models\User;
use App\Domains\Operations\Enums\OperationTypeEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Numeric;

/**
 * @property int $user_id
 * @property int $operation_type
 * @property float $amount
 * @property string $description
 */
class CreateOperationRequest extends BaseRequest
{
    public int $user_id;
    public int $operation_type;
    public float $amount;
    public string $description;
    public function getRules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'amount' => ['required', 'min:0', 'decimal:0', function ($attribute, $value, $fail) {
                if (!$this->checkBalance($value)) {
                    $fail('Недостаточно средств на балансе пользователя.');
                }
            }],
            'description' => 'required|string|max:255',
            'operation_type' => ['required', 'integer', new Enum(OperationTypeEnum::class)],
        ];
    }


    protected function checkBalance($amount): bool
    {
        if ($this->operation_type === OperationTypeEnum::OPERATION_TYPE_DEBIT->value) {
            return true;
        }
        $user = User::find($this->user_id);

        return $user->balance >= $amount;
    }
}
