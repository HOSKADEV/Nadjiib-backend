<?php

namespace App\Http\Filters\Course;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CourseKeywordSearch implements Filter
{
    public function __invoke(Builder $query, $search, string $property = '')
    {
        $query->where(function ($q) use ($search) {
            $q->where('name', "like", "%{$search}%");
            // $q->orWhere('price', 'like', "%{$search}%");
        });
    }
}
