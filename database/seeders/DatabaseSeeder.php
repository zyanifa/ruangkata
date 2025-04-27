<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'beng',
            'username' => 'beng',
            'email' => 'beng@gmail.com'
        ]);
        
        $categories = [
            'AI',
            'Blockchain',
            'Cloud Computing',
            'Cyber Security',
            'Data Science',
            'Deep Learning',
            'DevOps',
            'Game Development',
            'Internet of Things',
            'Jaringan Komputer',
            'Machine Learning',
            'Mobile Development',
            'Pemrograman',
            'Robotika',
            'Sistem Operasi',
            'UI/UX Design',
            'Web Development',
        ];
        

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }

        // Post::factory(100)->create();
    }
}
