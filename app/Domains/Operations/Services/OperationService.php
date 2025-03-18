<?php

namespace App\Domains\Operations\Services;

use App\BaseClasses\BaseService;
use App\Domains\Customers\Models\User;
use App\Domains\Operations\Enums\OperationTypeEnum;
use App\Domains\Operations\Models\Operation;
use App\Domains\Operations\Requests\CreateOperationRequest;
use Illuminate\Support\Facades\DB;

class OperationService extends BaseService
{

    public function createOperation(CreateOperationRequest $request): Operation
    {
        DB::beginTransaction();
        /** @var User $customer */
        $customer = User::find($request->user_id);

        $operation = new Operation($request->toArray());
        $operation->save();

        match ($request->operation_type) {
            OperationTypeEnum::OPERATION_TYPE_CREDIT->value => $amount = -$request->amount,
            default => $amount = $request->amount
        };

        $customer->update([
            'balance' => $customer->balance + $amount
        ]);
        DB::commit();

        return $operation;
    }
}
