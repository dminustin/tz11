<?php

namespace App\Domains\Operations\Jobs;

use App\Domains\Operations\Requests\CreateOperationRequest;
use App\Domains\Operations\Services\OperationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CreateOperationJob implements ShouldQueue
{
    use Queueable;

    public function __construct(protected CreateOperationRequest $request)
    {
        /**/
    }

    public function handle(): void
    {
        /** @var OperationService $service */
        $service = app()->make(OperationService::class);
        $operation = $service->createOperation($this->request);
    }
}
