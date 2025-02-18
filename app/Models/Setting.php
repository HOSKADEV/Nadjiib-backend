<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'value',
    ];


    public static function pusher_credentials(){
      return [
        'instanceId' => self::where('name','pusher_instance_id')->value('value'),
        'secretKey' => self::where('name','pusher_primary_key')->value('value'),
      ];
    }

    public static function chargily_credentials(){
      return [
        'mode' => self::where('name','chargily_mode')->value('value'),
        'public' => self::where('name','chargily_pk')->value('value'),
        'secret' => self::where('name','chargily_sk')->value('value'),
      ];
    }
}
