<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notice extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title_ar',
        'title_fr',
        'title_en',
        'content_ar',
        'content_fr',
        'content_en',
        'type',
    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function users()
    {
        return $this->hasManythrough(User::class, Notification::class);
    }
}
