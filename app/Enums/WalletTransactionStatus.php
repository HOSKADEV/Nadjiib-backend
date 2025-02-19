<?php

namespace App\Enums;

class WalletTransactionStatus
{
  const PENDING = 'pending';
  const SUCCESS = 'success';
  const FAILED = 'failed';



  public static function lists()
  {
    return [
      self::PENDING => trans('app.status.pending'),
      self::SUCCESS => trans('app.status.success'),
      self::FAILED => trans('app.status.failed'),
    ];
  }
  public static function lists2()
  {
    return [
      self::PENDING,
      self::SUCCESS,
      self::FAILED
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
