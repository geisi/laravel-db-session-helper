<?php

namespace Geisi\LaravelDbSessionHelper\Contracts;

use Carbon\Carbon;

interface Session
{
    public function getIsOnlineAttribute(): bool;

    public function getLastLoginAttribute(): ?Carbon;
}
