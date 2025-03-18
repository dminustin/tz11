<?php

namespace App\BaseClasses;

use \Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

abstract class BaseRequest extends FormRequest
{
    abstract public function getRules(): array;

    protected function passedValidation(): void
    {
        foreach ($this->validated() as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @throws ValidationException
     */
    public static function createFromArray(array $data = []): static
    {
        $instance = new static;
        foreach ($data as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->{$key} = $value;
            }
        }
        $validator = ValidatorFacade::make($data, $instance->getRules());
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $instance;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
