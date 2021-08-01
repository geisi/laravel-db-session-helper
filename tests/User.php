<?php

namespace Geisi\LaravelDbSessionHelper\Tests;

use Geisi\LaravelDbSessionHelper\Traits\HasDatabaseSessions;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Model implements AuthorizableContract, AuthenticatableContract
{
    use Authorizable;
    use Authenticatable;
    use HasDatabaseSessions;

    public $timestamps = false;
    protected $fillable = ['email'];
    protected $table = 'users';
}

