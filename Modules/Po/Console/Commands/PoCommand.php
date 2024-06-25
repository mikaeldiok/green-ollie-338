<?php

namespace Modules\Po\Console\Commands;

use Illuminate\Console\Command;

class PoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PoCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Po Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
