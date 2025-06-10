<?php

namespace Database\Seeders;

use App\Models\RppArchivo;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RppArchivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RppArchivo::factory(500)->create();
    }
}
