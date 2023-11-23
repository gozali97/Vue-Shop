<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::create([
            'name' => $name = 'banner 1',
            'slug'=>str($name)->slug(),
            'image'=> 'https://images.unsplash.com/photo-1519638831568-d9897f54ed69?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NTF8fGNhbWVyYXxlbnwwfHwwfHx8MA%3D%3D'
        ]);
        Banner::create([
            'name' => $name = 'banner 2',
            'slug'=>str($name)->slug(),
            'image' => 'https://images.unsplash.com/photo-1599139894727-62676829679b?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjR8fGhlYWRwaG9uZXxlbnwwfHwwfHx8MA%3D%3D'
        ]);
        Banner::create([
            'name' => $name = 'banner 3',
            'slug'=>str($name)->slug(),
            'image' => 'https://images.unsplash.com/photo-1612832988915-703f0eb9e437?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTIwfHxtb25pdG9yfGVufDB8fDB8fHww'
        ]);
    }
}
