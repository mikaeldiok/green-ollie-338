<?php

namespace Modules\Cashier\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Cashier\Models\Cashier;

class CashierDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * Cashiers Seed
         * ------------------
         */

        // DB::table('cashiers')->truncate();
        // echo "Truncate: cashiers \n";

        Cashier::factory()->count(20)->create();
        $rows = Cashier::all();
        echo " Insert: cashiers \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
