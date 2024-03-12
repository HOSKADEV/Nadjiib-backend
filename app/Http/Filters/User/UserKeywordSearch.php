<?php

namespace App\Http\Filters\User;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class UserKeywordSearch implements Filter
{
    public function __invoke(Builder $query, $search, string $property = '')
    {
        $query->where(function ($q) use ($search) {
            $q->where('name', "like", "%{$search}%");
            $q->orWhere('email', 'like', "%{$search}%");
            $q->orWhere('phone', 'like', "%{$search}%");
        });
    }
}