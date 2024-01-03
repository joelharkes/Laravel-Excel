<?php
declare(strict_types=1);

namespace Maatwebsite\Excel\Concerns;

/**
 * Uses result of the validation instead.
 * {@see SkipsOnFailure} Only gets validated result if no validation failures occurred.
 * {@see OnEachRow} also does not receive the result of the validation.
 */
interface WithValidationResult extends WithValidation
{

}
