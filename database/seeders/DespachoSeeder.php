<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DespachoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('despachos')->insert([
            ['nombre' => 'Despacho 1'],
            ['nombre' => 'Despacho 2'],
            ['nombre' => 'Despacho 3'],
        ]);
    }
}
