<?php

namespace Geisi\LaravelDbSessionHelper\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasDatabaseSessions
{
    public function scopeIsOnline(Builder $builder)
    {
        $builder->whereHas('session', function ($builder) {
            $builder->where('last_activity', '>', now()->subMinutes(config('db-session-helper.login_time_span')));
        })
            ->with('session');
    }

    public function scopeIsOffline(Builder $builder)
    {
        $builder->where(function (Builder $builder) {
            $builder->whereHas('session', function ($builder) {
                $builder->where('last_activity', '<', now()->subMinutes(config('db-session-helper.login_time_span')));
            })->orWhereDoesntHave('session');
        })
            ->with('session');
    }

    public function getIsOnlineAttribute(): bool
    {
        return $this->session && $this->session->is_online;
    }

    public function session(): HasOne
    {
        return $this->hasOne(config('db-session-helper.models.session'))->latestOfMany('last_activity');
    }

    public function getLastLoginAttribute(): ?Carbon
    {
        return optional($this->session)->last_activity;
    }
}
