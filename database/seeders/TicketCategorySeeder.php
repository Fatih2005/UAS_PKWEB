<?php

namespace Database\Seeders;

use App\Models\TicketCategory;
use Illuminate\Database\Seeder;

class TicketCategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'Infrastruktur',
                'slug' => 'infrastruktur',
                'description' => 'Server, jaringan, dan layanan internal',
                'sla_hours' => 4,
            ],
            [
                'name' => 'Aplikasi',
                'slug' => 'aplikasi',
                'description' => 'Bug, fitur baru, dan gangguan sistem aplikasi',
                'sla_hours' => 8,
            ],
            [
                'name' => 'Keamanan',
                'slug' => 'keamanan',
                'description' => 'Insiden keamanan dan laporan kerentanan',
                'sla_hours' => 2,
            ],
            [
                'name' => 'Akun & Akses',
                'slug' => 'akun-akses',
                'description' => 'Permintaan akses, reset password, dan provisioning user',
                'sla_hours' => 4,
            ],
        ];

        foreach ($items as $item) {
            TicketCategory::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}
