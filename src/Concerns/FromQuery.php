<?php

namespace Maatwebsite\Excel\Concerns;


use Illuminate\Contracts\Database\Query\Builder;

interface FromQuery
{
    /**
     * @return Builder
     */
    public function query();
}
