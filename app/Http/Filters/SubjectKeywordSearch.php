<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class SubjectKeywordSearch implements Filter
{
    public function __invoke(Builder $query, $search, string $property = '')
    {
        $query->where(function ($q) use ($search) {
            $q->where('name_ar', "like", "%{$search}%");
            $q->orWhere('name_en', 'like', "%{$search}%");
            $q->orWhere('name_fr', 'like', "%{$search}%");
        });
    }
}
