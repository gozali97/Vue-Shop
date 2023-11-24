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
            'slug'=>str($name)->slug(),
            'image'=> 'https://images.unsplash.com/photo-1560131914-2e469a0e8607?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MzR8fG1vbml0b3J8ZW58MHx8MHx8fDA%3D'
        ]);
        Category::create([
            'name' => $name = 'Mouse',
            'slug'=>str($name)->slug(),
            'image'=> 'https://images.unsplash.com/photo-1658070429465-848c0796abf3?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NjN8fG1vdXNlJTIwZ2FtaW5nfGVufDB8fDB8fHww'
        ]);
        Category::create([
            'name' => $name = 'Keyboard',
            'slug'=>str($name)->slug(),
            'image'=> 'https://images.unsplash.com/photo-1672211775632-bcb4b68eb2bd?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8a2V5Ym9hcmQlMjBtZWNoYW5pY2FsfGVufDB8fDB8fHww'
        ]);
        Category::create([
            'name' => $name = 'Headphone',
            'slug'=> str($name)->slug(),
            'image'=> 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mjh8fG1vdXNlJTIwZ2FtaW5nfGVufDB8fDB8fHww'
        ]);
        Category::create([
            'name' => $name = 'Laptop',
            'slug'=> str($name)->slug(),
            'image'=> 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8bGFwdG9wfGVufDB8fDB8fHww'
        ]);
    }
}
