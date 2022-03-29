<?php

namespace Hemengeliriz\ParamposLaravel\Commands;

use Illuminate\Console\Command;

class ParamposLaravelCommand extends Command
{
    public $signature = 'parampos-laravel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
