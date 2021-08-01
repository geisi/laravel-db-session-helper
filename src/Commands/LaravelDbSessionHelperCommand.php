<?php

namespace Geisi\LaravelDbSessionHelper\Commands;

use Illuminate\Console\Command;

class LaravelDbSessionHelperCommand extends Command
{
    public $signature = 'laravel-db-session-helper';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
