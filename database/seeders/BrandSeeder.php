<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::create([
            'name' => $name = 'Samsung',
            'slug'=>str($name)->slug()
        ]);
        Brand::create([
            'name' => $name = 'Acer',
            'slug'=>str($name)->slug()
        ]);
        Brand::create([
            'name' => $name = 'Asus',
            'slug'=>str($name)->slug()
        ]);
        Brand::create([
            'name' => $name = 'Razer',
            'slug'=> str($name)->slug()
        ]);
        Brand::create([
            'name' => $name = 'Xiaomi',
            'slug'=> str($name)->slug()
        ]);
        Brand::create([
            'name' => $name = 'LG',
            'slug'=> str($name)->slug()
        ]);
    }
}
