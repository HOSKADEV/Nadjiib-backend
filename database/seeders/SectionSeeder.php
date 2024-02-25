<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->insert([
          [
            'id' => 1,
            'name_ar' => 'الطور الابتدائي',
            'name_fr' => 'Cycle primaire',
            'name_en' => 'Elementary stage',
          ],
          [
            'id' => 2,
            'name_ar' => 'الطور المتوسط',
            'name_fr' => 'Cycle moyen',
            'name_en' => 'Middle stage',
          ],
          [
            'id' => 3,
            'name_ar' => 'الطور الثانوي',
            'name_fr' => 'Cycle secondaire',
            'name_en' => 'High stage',
          ],
        ]);
    }
}
