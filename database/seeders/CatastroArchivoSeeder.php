<?php

namespace Database\Seeders;

use App\Models\CatastroArchivo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatastroArchivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CatastroArchivo::factory(500)->create();
    }
}
