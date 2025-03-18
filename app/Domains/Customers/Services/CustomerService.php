<?php

namespace App\Domains\Customers\Services;

use App\BaseClasses\BaseService;
use App\Domains\Customers\Models\User;
use App\Domains\Customers\Requests\CreateCustomerRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CustomerService extends BaseService
{
    /**
     *
     * @param CreateCustomerRequest $request
     * @return User
     * @throws ValidationException
     */
    public function createUser(CreateCustomerRequest $request): User
    {
        return User::create($request->toArray());
    }
}
