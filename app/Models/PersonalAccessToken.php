<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use MongoDB\Laravel\Eloquent\Model;

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
        'last_used_at' => 'datetime',
    ];

    public static function findToken($token)
    {
        if (strpos($token, '|') !== false) {
            [$id, $plainTextToken] = explode('|', $token, 2);

            $instance = static::find($id);

            if (! $instance) {
                return null;
            }

            return hash_equals($instance->token, hash('sha256', $plainTextToken))
                ? $instance
                : null;
        }

        return static::where('token', hash('sha256', $token))->first();
    }


}

