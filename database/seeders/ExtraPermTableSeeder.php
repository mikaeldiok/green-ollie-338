<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Class ExtraPermissionTableSeeder.
 */
class ExtraPermTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {

        Artisan::call('auth:permissions', [
            'name' => 'foods',
        ]);
        echo "\n _Foods_ Permissions Created.";

        echo "\n\n";
    }

}
