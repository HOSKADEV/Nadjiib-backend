<?php

namespace App\Http\Filters\Course;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FiltersCourseSubject implements Filter
{
    public function __invoke(Builder $query, $value, string $property = '')
    {
        // $query->where(function ($q) use ($search) {
        //     $q->where('name', "like", "%{$search}%");
        //     // $q->orWhere('price', 'like', "%{$search}%");
        // });

        // $query->whereHas('subject', function (Builder $query) use ($value) {
        //     $query->where('name_ar', $value);
        // });
        $query->whereHas('subject', function (Builder $query) use ($value) {
            $query->where('name_ar', $value);
            $query->orWhere('name_en', $value);
            $query->orWhere('name_fr', $value);

            // $q->where('name_ar', "like", "%{$search}%");
            // $q->orWhere('name_en', "like", "%{$search}%");
            // $q->orWhere('name_fr', "like", "%{$search}%");
        });
    }
}
