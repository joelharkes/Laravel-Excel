<?php

namespace Maatwebsite\Excel\Tests\Data\Stubs\Database;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Maatwebsite\Excel\Tests\Data\Stubs\Database\Factories\GroupFactory;
use Maatwebsite\Excel\Tests\Data\Stubs\Database\Factories\UserFactory;

class User extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];

    /**
     * @var array
     */
    protected $hidden = ['password', 'email_verified_at', 'options'];

    /**
     * @return BelongsToMany
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    protected static function newFactory(): UserFactory
    {
        return new UserFactory();
    }
}
