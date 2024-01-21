<?php

namespace Maatwebsite\Excel\Concerns;

/**
 * Validates each row before importing via {@see ToModel}
 * {@see SkipsOnError} Skips the rows that have validation failures.
 */
interface WithValidation
{
    /**
     * @return array
     */
    public function rules(): array;
}
