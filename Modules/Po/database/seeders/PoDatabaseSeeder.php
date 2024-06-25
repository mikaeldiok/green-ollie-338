<?php

namespace Modules\Po\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Po\Models\Po;

class PoDatabaseSeeder extends Seeder
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
         * Pos Seed
         * ------------------
         */

        // DB::table('pos')->truncate();
        // echo "Truncate: pos \n";

        Po::factory()->count(20)->create();
        $rows = Po::all();
        echo " Insert: pos \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
