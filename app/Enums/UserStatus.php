<?php

namespace App\Enums;

class UserStatus
{
    const ACTIVE = 'Active';
    const INACTIVE = 'Inactive';

    public static function lists()
    {
        return [
            self::ACTIVE => trans('app.status.' . self::ACTIVE),
            self::INACTIVE => trans('app.status.' . self::INACTIVE),
        ];
    }
}
