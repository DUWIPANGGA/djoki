<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'icon' => 'globe',
                'description' => 'Layanan pembuatan website landing page, company profile, hingga web app kompleks.',
            ],
            [
                'name' => 'Mobile App',
                'icon' => 'smartphone',
                'description' => 'Jasa pembuatan aplikasi Android dan iOS menggunakan Flutter atau Native.',
            ],
            [
                'name' => 'UI/UX Design',
                'icon' => 'figma',
                'description' => 'Desain antarmuka pengguna yang modern dan pengalaman pengguna yang intuitif.',
            ],
            [
                'name' => 'Cyber Security',
                'icon' => 'shield',
                'description' => 'Audit keamanan, penetration testing, dan pemulihan akun.',
            ],
            [
                'name' => 'Academic & Assignment',
                'icon' => 'book',
                'description' => 'Bantuan pengerjaan tugas kuliah IT, skripsi, dan riset teknologi.',
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
                'description' => $category['description']
            ]);
        }
    }
}
