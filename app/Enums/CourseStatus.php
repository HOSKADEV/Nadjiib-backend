<?php
namespace App\Enums;

class CourseStatus
{
    const PENDING = 'Pending' ;
    const ACCEPTED = 'Accepted';
    const REFUSED = 'Refused' ;

    public static function lists()
    {
        return [
            self::PENDING => trans('app.status.'.self::PENDING),
            self::ACCEPTED => trans('app.status.'. self::ACCEPTED),
            self::REFUSED => trans('app.status.'. self::REFUSED),
        ];
    }

    // public static function orderLists()
    // {
    //     return [
    //         self::ACCEPTED => trans('app.status_ar.'. self::ACCEPTED),
    //         self::PENDING => trans('app.status_ar.'. self::PENDING),
    //         self::REFUSED => trans('app.status_ar.'. self::REFUSED),
    //     ];
    // }
}
