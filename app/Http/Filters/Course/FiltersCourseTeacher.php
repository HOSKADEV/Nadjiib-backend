<?php

namespace App\Http\Filters\Course;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FiltersCourseTeacher implements Filter
{
    public function __invoke(Builder $query, $value, string $property = '')
    {
        $query->whereHas('teacher.user', function (Builder $query) use ($value) {
            $query->where('name', $value);
        });
    }
}
