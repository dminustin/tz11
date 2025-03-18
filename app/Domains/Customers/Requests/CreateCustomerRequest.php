<?php

namespace App\Domains\Customers\Requests;

use App\BaseClasses\BaseRequest;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 * @property float $balance
 */
class CreateCustomerRequest extends BaseRequest
{
    public string $name;
    public string $email;
    public string $password;
    public float $balance;

    public function getRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'balance' => 'required|numeric|min:0',
        ];
    }
}
