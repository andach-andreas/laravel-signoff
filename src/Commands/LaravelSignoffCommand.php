<?php

namespace Andach\LaravelSignoff\Commands;

use Illuminate\Console\Command;

class LaravelSignoffCommand extends Command
{
    public $signature = 'laravel-signoff';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
