<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => $name = 'Monitor',
            'slug'=>str($name)->slug()
        ]);
        Category::create([
            'name' => $name = 'Mouse',
            'slug'=>str($name)->slug()
        ]);
        Category::create([
            'name' => $name = 'Keyboard',
            'slug'=>str($name)->slug()
        ]);
        Category::create([
            'name' => $name = 'Headphone',
            'slug'=> str($name)->slug()
        ]);
    }
}
