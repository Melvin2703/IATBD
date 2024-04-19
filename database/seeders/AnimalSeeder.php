<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Animal;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('animals')->delete();

        Animal::create([
            'id'=>1,
            'name'=>'Hond'
        ]);

        Animal::create([
            'id'=>2,
            'name'=>'Kat'
        ]);

        Animal::create([
            'id'=>3,
            'name'=>'Vis'
        ]);

        Animal::create([
            'id'=>4,
            'name'=>'Hamster'
        ]);
    }
}
