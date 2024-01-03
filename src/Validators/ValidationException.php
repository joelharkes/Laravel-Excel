<?php

namespace Maatwebsite\Excel\Validators;

use Illuminate\Validation\ValidationException as IlluminateValidationException;

class ValidationException extends IlluminateValidationException
{
    /**
     * @var Failure[]
     */
    protected array $failures;

    /**
     * @param  IlluminateValidationException  $previous
     * @param  array  $failures
     */
    public function __construct(IlluminateValidationException $previous, array $failures)
    {
        parent::__construct($previous->validator, $previous->response, $previous->errorBag);
        $this->failures = $failures;
    }

    /**
     * @return string[]
     */
    public function errors(): array
    {
        return collect($this->failures)->map->toArray()->all();
    }

    /**
     * @return Failure[]
     */
    public function failures(): array
    {
        return $this->failures;
    }
}
