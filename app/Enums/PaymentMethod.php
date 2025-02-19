<?php

namespace App\Enums;

class PaymentMethod
{
  const BARIDIMOB = 'baridimob';
  const CHARGILY = 'chargily';
  const POSTE = 'poste';



  public static function lists()
  {
    return [
      self::BARIDIMOB => trans('app.bardimob'),
      self::CHARGILY => trans('app.chargily'),
      self::POSTE => trans('app.poste'),
    ];
  }
  public static function lists2()
  {
    return [
      self::BARIDIMOB,
      self::CHARGILY,
      self::POSTE
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
