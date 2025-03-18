<?php

namespace App\Console\Commands;

use App\Domains\Customers\Models\User;
use App\Domains\Operations\Enums\OperationTypeEnum;
use App\Domains\Operations\Requests\CreateOperationRequest;
use App\Domains\Operations\Services\OperationService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Validation\ValidationException;

class CreateOperationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-operation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws BindingResolutionException
     */
    public function handle()
    {
        $email = $this->ask('Введите email пользователя');
        $amount = (float) $this->ask('Введите сумму операции');
        $description = $this->ask('Введите описание операции');
        $operationTypeInput = $this->choice(
            'Тип операции',
            ['debit' => 'Начисление', 'credit' => 'Списание'],
            'debit'
        );
        $operationType = $operationTypeInput === 'credit'
            ? OperationTypeEnum::OPERATION_TYPE_CREDIT->value
            : OperationTypeEnum::OPERATION_TYPE_DEBIT->value;

        $user = User::where('email', $email)->firstOrFail();

        $data = [
            'user_id' => $user->id,
            'amount' => $amount,
            'description' => $description,
            'operation_type' => $operationType,
        ];

        try {
            $request = CreateOperationRequest::createFromArray($data);
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    $this->error($message);
                }
            }
            return self::FAILURE;
        } catch (\Exception $e) {
            $this->error('Ошибка: ' . $e->getMessage());
            return self::FAILURE;
        }

        /** @var OperationService $service */
        $service = app()->make(OperationService::class);
        $operation = $service->createOperation($request);

        $this->info('Операция успешно проведена. ID: ' . $operation->id);
        return self::SUCCESS;
    }
}
