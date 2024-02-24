<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\SectionSeeder;
use Database\Seeders\SubjectSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(30)->create();
        $this->call([
            SectionSeeder::class,
            SubjectSeeder::class,
        ]);
    }
}
