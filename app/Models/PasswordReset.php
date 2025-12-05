<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class PasswordReset extends Model
{
    protected $collection = 'password_resets';
    protected $connection = 'mongodb';

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];

    public $timestamps = false;
}
