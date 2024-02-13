<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'salman',
            'email' => 'salman@gmail.com',
            'username' => 'salman',
            'password' => bcrypt('123'),
        ]);
        // $this->call(LeafletSeeder::class);
    }
}
