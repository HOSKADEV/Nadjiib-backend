<?php

namespace App\Enums;

class CouponType
{
    const LIMITED = 'limited';
    const INVITATION = 'invitation';

    public static function lists()
    {
        return [
            self::LIMITED => trans('coupon.types.' . self::LIMITED),
            self::INVITATION => trans('coupon.types.' . self::INVITATION),
        ];
    }
}
