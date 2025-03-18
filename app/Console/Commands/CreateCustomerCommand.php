<?php

namespace App\Console\Commands;

use App\Domains\Customers\Models\User;
use App\Domains\Customers\Requests\CreateCustomerRequest;
use App\Domains\Customers\Services\CustomerService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateCustomerCommand extends Command
{
    protected $signature = 'app:create-customer';
    protected $description = 'Create new customer with initial balance';

    /**
     * @throws BindingResolutionException
     * @throws ValidationException
     */
    public function handle()
    {
        $name = $this->ask('Введите имя');
        $email = $this->ask('Введите email');


        $password = $this->secret('Введите пароль');
        $passwordConfirmation = $this->secret('Подтвердите пароль');

        if ($password !== $passwordConfirmation) {
            $this->error('Пароли не совпадают');
            return Command::FAILURE;
        }

        $initialBalance = $this->ask('Введите начальный баланс (число)', 0);

        $service = app()->make(CustomerService::class);
        $user = $service->createUser(CreateCustomerRequest::createFromArray([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'balance' => $initialBalance,
        ]));

        $this->info("Пользователь {$user->email} успешно создан с балансом {$initialBalance}");

        return Command::SUCCESS;
    }
}
