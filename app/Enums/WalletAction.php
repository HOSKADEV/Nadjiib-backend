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
            self::DEPOSIT => trans('wallet.types.deposit'),
            self::WITHDRAW => trans('wallet.types.withdraw'),
            self::BUY => trans('wallet.types.buy'),
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
