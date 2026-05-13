<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $webDev = ServiceCategory::where('name', 'Web Development')->first();
        $mobile = ServiceCategory::where('name', 'Mobile App')->first();
        $academic = ServiceCategory::where('name', 'Academic & Assignment')->first();

        $services = [
            // Web Dev
            [
                'category_id' => $webDev->id,
                'name' => 'Landing Page Premium',
                'min_price' => 500000,
                'description' => 'Website satu halaman dengan desain modern dan responsif.',
            ],
            [
                'category_id' => $webDev->id,
                'name' => 'Fullstack Web Laravel',
                'min_price' => 2500000,
                'description' => 'Sistem web lengkap dengan database dan panel admin.',
            ],
            // Mobile
            [
                'category_id' => $mobile->id,
                'name' => 'Android App Flutter',
                'min_price' => 3000000,
                'description' => 'Aplikasi android performa tinggi dengan Flutter.',
            ],
            // Academic
            [
                'category_id' => $academic->id,
                'name' => 'Tugas Coding Python',
                'min_price' => 100000,
                'description' => 'Pengerjaan tugas algoritma atau scripting Python.',
            ],
            [
                'category_id' => $academic->id,
                'name' => 'Bimbingan Skripsi IT',
                'min_price' => 1500000,
                'description' => 'Konsultasi dan bantuan teknis pembuatan aplikasi skripsi.',
            ],
        ];

        foreach ($services as $service) {
            Service::create([
                'category_id' => $service['category_id'],
                'name' => $service['name'],
                'slug' => Str::slug($service['name']),
                'description' => $service['description'],
                'min_price' => $service['min_price'],
                'is_active' => true,
            ]);
        }
    }
}
