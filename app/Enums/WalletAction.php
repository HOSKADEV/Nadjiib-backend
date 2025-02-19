<?php

namespace App\Enums;

class WalletAction
{
    const DEPOSIT = 'Deposit';
    const WITHDRAW = 'Withdraw';
    const BUY = 'Buy';



    public static function lists()
    {
        return [
            self::DEPOSIT => trans('app.deposit'),
            self::WITHDRAW => trans('app.withdraw'),
            self::BUY => trans('app.buy'),
        ];
    }

    public static function lists2(){
      return[
        self::DEPOSIT,
        self::WITHDRAW,
        self::BUY
      ];
    }

    public static function get($type)
    {
        return self::lists()[$type] ?? null;
    }

    public static function getTypes()
    {
        return array_keys(self::lists());
    }

    public static function getValues()
    {
        return array_values(self::lists());
    }
}
