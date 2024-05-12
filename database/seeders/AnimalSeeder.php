<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('animal')->insert([
            'name' => Str::random(10),
            'birth' => date::random(),
            'race' => Str::random(10),
            'color' => Str::random(10),
            'lost' => 0
        ]);
    }
}
