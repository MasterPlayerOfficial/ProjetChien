<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('animal')->insert([
            'name' => Str::random(10),
            'birth' => Date::random(),
            'race' => Str::random(10),
            'color' => Str::random(10),
            'lost' => 0
        ]);
    }
}
