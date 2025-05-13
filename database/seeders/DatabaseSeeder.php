<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create regular user
        User::factory()->create([
            'name' => 'beng',
            'username' => 'beng',
            'email' => 'beng@gmail.com',
            'password' => Hash::make('hanifrifki'),
            'email_verified_at' => now(),
            'is_admin' => false,
        ]);
        
        // Create admin user
        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);
        
        $categories = [
            'AI',
            'Blockchain',
            'Cloud Computing',
            'Cyber Security',
            'Database',
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
            'Quantum Computing'
        ];
        
        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }

        // Post::factory(100)->create();
    }
}