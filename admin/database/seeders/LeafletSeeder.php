<?php

namespace Database\Seeders;

use App\Models\MLeaflet;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LeafletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = ['R. MATERNAL', 'R. NEO', 'GIZI', 'R. GENERAL'];

        $faker = Faker::create('id_ID');

        $jml = 100;

        for ($i = 1; $i <= $jml; $i++) {
            MLeaflet::create([
                'judul' => 'Judul ' . $i,
                'desc' => $faker->paragraph(),
                'unit' => $units[rand(0, 3)],
            ]);
        }
    }
}
