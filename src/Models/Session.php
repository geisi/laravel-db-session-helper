<?php

namespace Geisi\LaravelDbSessionHelper\Models;

use Carbon\Carbon;
use Geisi\LaravelDbSessionHelper\Contracts\Session as SessionContract;
use Illuminate\Database\Eloquent\Model;

class Session extends Model implements SessionContract
{
    public $timestamps = false;
    protected $casts = [
        'last_activity' => 'datetime',
    ];
    protected $keyType = 'string';

    public function getTable()
    {
        return config('session.table', parent::getTable());
    }

    public function getIsOnlineAttribute(): bool
    {
        return $this->last_activity > now()->subMinutes(10);
    }

    public function getLastLoginAttribute(): ?Carbon
    {
        return $this->last_activity;
    }
}
