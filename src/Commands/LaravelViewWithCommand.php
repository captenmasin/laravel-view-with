<?php

namespace Captenmasin\LaravelViewWith\Commands;

use Illuminate\Console\Command;

class LaravelViewWithCommand extends Command
{
    public $signature = 'laravel-view-with';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
