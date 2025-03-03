<?php

namespace Modules\Cirugias\Database\Seeders;

use Illuminate\Database\Seeder;

class CirugiasDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CirugiasTableSeeder::class
        ]);
    }
}
