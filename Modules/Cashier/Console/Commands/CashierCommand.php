<?php

namespace Modules\Cashier\Console\Commands;

use Illuminate\Console\Command;

class CashierCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CashierCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cashier Command description';

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
