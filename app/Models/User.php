<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'username',
        'password',
        'name'
    ];

    public function getAuthIdentifierName()
    {
        return 'username';
    }
    public function getAuthIdentifier()
    {
        return $this->username;
    }
    public function getAuthPassword()
    {
        return $this->password;
    }
    public function getRememberToken()
    {
        return $this->token;
    }
    public function getRememberTokenName()
    {
        return 'token';
    }
    public function setRememberToken($value)
    {
        return $this->token = $value;
    }
}
