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
            'slug'=>str($name)->slug(),
            'image'=> 'https://images.unsplash.com/photo-1661347998423-b15d37d6f61e?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8c2Ftc3VuZyUyMGxvZ298ZW58MHx8MHx8fDA%3D'
        ]);
        Brand::create([
            'name' => $name = 'Acer',
            'slug'=>str($name)->slug(),
            'image'=> 'https://images.unsplash.com/photo-1683835444337-d81bb4ce325b?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8YWNlciUyMGxvZ298ZW58MHx8MHx8fDA%3D'
        ]);
        Brand::create([
            'name' => $name = 'Asus',
            'slug'=>str($name)->slug(),
            'image'=> 'https://images.unsplash.com/photo-1655437448243-08a76744b048?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8YXN1cyUyMGxvZ298ZW58MHx8MHx8fDA%3D'
        ]);
        Brand::create([
            'name' => $name = 'Razer',
            'slug'=> str($name)->slug(),
            'image'=> 'https://images.unsplash.com/photo-1605134513573-384dcf99a44c?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8cmF6ZXIlMjBsb2dvfGVufDB8fDB8fHww'
        ]);
        Brand::create([
            'name' => $name = 'Xiaomi',
            'slug'=> str($name)->slug(),
            'image'=> 'https://images.unsplash.com/photo-1662948100180-7bc43f6fcab3?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8eGlhb21pJTIwbG9nb3xlbnwwfHwwfHx8MA%3D%3D'
        ]);
        Brand::create([
            'name' => $name = 'HP',
            'slug'=> str($name)->slug(),
            'image'=> 'https://images.unsplash.com/photo-1654277040981-82984a49c63a?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGhwJTIwbG9nb3xlbnwwfHwwfHx8MA%3D%3D'
        ]);
    }
}
