<?php

namespace Maatwebsite\Excel\Tests\Data\Stubs;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomQuerySize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Tests\Data\Stubs\Database\Group;

class FromQueryWithCustomQuerySize implements FromQuery, WithCustomQuerySize, WithMapping, ShouldQueue
{
    use Exportable;

    public function query(): Builder
    {
        return Group::with('users')
            ->join('group_user', 'groups.id', '=', 'group_user.group_id')
            ->select('groups.*', DB::raw('count(group_user.user_id) as number_of_users'))
            ->groupBy('groups.id')
            ->orderBy('number_of_users');
    }

    /**
     * @return int
     */
    public function querySize(): int
    {
        return Group::has('users')->count();
    }

    /**
     * @param  Group  $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->number_of_users,
        ];
    }
}
