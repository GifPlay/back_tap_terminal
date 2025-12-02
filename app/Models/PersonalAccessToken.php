<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Laravel\Sanctum\TransientToken;

class PersonalAccessToken extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'personal_access_tokens';

    protected $fillable = [
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'last_used_at',
    ];

    protected $casts = [
        'abilities' => 'array',
        'last_used_at' => 'datetime',
    ];

    public function tokenable()
    {
        return $this->morphTo();
    }

    public function can($ability)
    {
        return in_array('*', $this->abilities ?? []) ||
            in_array($ability, $this->abilities ?? []);
    }

    public function cant($ability)
    {
        return !$this->can($ability);
    }

    public function toTransient()
    {
        return new TransientToken($this->abilities);
    }
}
